<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mark - Load All Events
 **/

class translator {
    
    protected $table_prefix;

    public function __construct()
    {
        Event::add('ushahidi_action.get_domain_locale', array($this, 'get_domain_locale'));  
//        mysql_query("SET NAMES utf8");
        Event::add('system.pre_controller', array($this, 'add'));
        
        
        $this->table_prefix = Kohana::config('database.default.table_prefix');
        $this->table_alias = Kohana::config('translator.table_alias');
        $this->translate_fields = Kohana::config('translator.translate_fields');
        $this->request = ($_SERVER['REQUEST_METHOD'] == 'POST')? $_POST : $_GET;
        
    }

    public function add()
    {    
        Event::add( Kohana::config('translator.display_admin_translate'), array($this, 'display_admin_translate')); 
        Event::add(Kohana::config('translator.event_save_admin_translator'),  array($this, 'save_translator')); 
        Event::add(Kohana::config('translator.run_translate_value'),  array($this, 'replace_value_for_translate')); 
        Event::add(Kohana::config('translator.run_translate_value_sql'),  array($this, 'replace_sql_for_translate')); 
        Event::add('ushahidi_action.add_translator_to_forwardreport',  array($this, 'add_translator_to_forwardreport')); 
        Event::add('ushahidi_action.get_translator_from_forwardreport',  array($this, 'get_translator_from_forwardreport')); 
        Event::add('ushahidi_action.get_translator_from_forwardreport',  array($this, 'get_translator_from_forwardreport')); 
        
    }
    
    public function  display_admin_translate(){      

        $element_id = Event::$data;
        $view = View::factory('translator_fields'); 
        if (!empty($element_id))
            $this->get_fields_value($element_id);
        $view->translate_fields = $this->translate_fields;     
        
        $view->render(TRUE);    
      }
      
      public function get_fields_value($element_id=0){
          $db = Database::instance(); 
          foreach  ($this->translate_fields as $ind=>$field){
              $query = "SELECT value FROM translator".
              " WHERE field='".$field['name']."' AND element_id=".$element_id;
              $query = $db->query($query); 
              $result = $query->result_array(FALSE);
              if (!empty($result))
                $this->translate_fields[$ind]['value']=$result[0]['value']; 
          }
      }
      
      public function save_translator(){
          $db = Database::instance();    
          $element_id = Event::$data;
          $location = Kohana::config('translator.second_lang');
          foreach ($this->translate_fields as $field){
            $val = (!empty($this->request[$field['name']]))?$this->request[$field['name']]:'';  
           
            $val = addslashes($val);
            $query = "SELECT id FROM translator WHERE element_id=".$element_id.
                        " AND location='".$location."' AND field='".$field['name']."'";
            $query = $db->query($query); 
            $result = $query->result_array(FALSE);
            if (!empty($result)){
               $query = "UPDATE translator SET element_id=".$element_id.
                        ", location='".$location."', field='".$field['name']."', value='".$val."' ".
                        " WHERE id=".$result[0]['id'] ;
            }
            else{  
                $query = "INSERT INTO translator SET element_id=".$element_id.
                        ", location='".$location."', field='".$field['name']."', value='".$val."'";
            }
            $query = $db->query($query);             
          }
           
      }
      
   /* function replace_for_translate(){
        $db = Database::instance();    
        $element_id = Event::$data['id']; 
        $location =  Session::instance()->get('locale',FALSE);
        var_dump($location);
        if ($location==Kohana::config('translator.event_save_admin_translator')){  
            $query = "SELECT id FROM translator WHERE element_id=".$element_id.
                        " AND location='".$location."' ";
            $query = $db->query($query); 
            $result = $query->result_array(FALSE);
            if (!empty($result)){
                foreach($result as $row){
                    
                }
            }
        }
    } */
    
    function replace_value_for_translate(){
        $db = Database::instance();    
        $element_id = Event::$data['id']; 
        $field = Event::$data['field']; 
        $location =  Session::instance()->get('locale',FALSE);
        //var_dump($location);
        if ($location==Kohana::config('translator.second_lang')){  
            $query = "SELECT * FROM translator WHERE element_id=".$element_id.
                        " AND location='".$location."' AND field='".$field."' ";
            $query = $db->query($query); 
            $result = $query->result_array(FALSE);
            if (!empty($result)){
                if (!empty($result[0]['value'])){
                    Event::$data['value'] = stripcslashes($result[0]['value']); 
                } 
            }
        }
    }
    
function replace_sql_for_translate(){
        $db = Database::instance();     
        $sql = Event::$data; 
        
        $location =  Session::instance()->get('locale',FALSE);
        if ($location==Kohana::config('translator.second_lang')){ 
            
            $i=1;
            foreach ($this->translate_fields as $field){
                $before = $this->get_before_isert($sql); 

                $sql = substr($sql,0,$before)." LEFT JOIN translator as translator".$i." ON translator".$i.".element_id=".$this->table_alias.".id AND translator".$i.".field='".$field['name']."' ".substr($sql,$before, strlen($sql)); 
                //var_export($sql);die;
                $sql = str_ireplace($this->table_alias.".".$field['original_name'], "IF ((translator".$i.".value IS NULL OR translator".$i.".value='')  , ".$this->table_alias.".".$field['original_name'].", translator".$i.".value ) as ".$field['original_name']." " ,
                $sql);
                $i++;
            }
            Event::$data = $sql; 
            
            
        }
    }
    
    function get_before_isert($sql=''){
            $before = strpos($sql, 'LEFT JOIN');
            if (!$before){
                $before = strpos($sql, 'RIGHT JOIN');
                if (!$before){
                    $before = strpos($sql, 'JOIN');
                    if (!$before){
                        $before = strpos($sql, 'WHERE'); 
                    }
                }
            }
            return $before;      
    }
    
    function add_translator_to_forwardreport(){
        //$reportParams = Event::$data;
        //$report_id =  Event::$data->report_id;
        $report_id =  Event::$data['report_id'];
        $db = Database::instance(); 
        $query = "SELECT location, field,value FROM translator WHERE element_id=".$report_id ;
        $query = $db->query($query);
        $translation = $query->result_array(FALSE);
        //Event::$data->translation = json_encode($translation);
        Event::$data['translator'] = json_encode($translation);
    }    
    
    function get_translator_from_forwardreport(){
        //$db = Database::instance();  
        //$query = "INSERT INTO translator SET value='123'";
        //$query = $db->query($query); 
        //$translator_json = Event::$data->translator;
      //  $report_id =  Event::$data->incident_id;
        /*$translator = json_decode($translator_json);
        if (!empty($translator)){
            $db = Database::instance();
            foreach ($translation as $tr){
                $query = "INSERT INTO translator SET ";
                foreach ($tr as $k=>$val){
                    $query.=" ".$k."='".$val."', ";
                } 
                    $query.=" element_id=".$report_id;
                $query = $db->query($query);
            }
        } */
    }

    function get_domain_locale(){

        if (Kohana::config('translator.use_different_domains')==true){
            $domains_langs = Kohana::config('translator.domains_lang');
            $locale = $domains_langs[$_SERVER['HTTP_HOST']];
	  // var_dump($_SERVER['HTTP_HOST']); 
	  // var_dump($locale);
            if (!empty($locale)){
                Session::instance()->set('locale',$locale);
                Kohana::config_set('locale.language', $locale);
            }
       }

    }
}

new translator();
