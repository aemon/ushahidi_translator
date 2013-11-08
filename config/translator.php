<?php defined('SYSPATH') OR die('No direct access allowed.');
    // table alias in filter
    $config['table_alias'] = 'i';
    // event to display translator for edit item
    $config['display_admin_translate'] = 'ushahidi_action.display_admin_translate';
    // event to save item and translator (save report)
    $config['event_save_admin_translator']  = 'ushahidi_action.report_edit';
    // event to translate by value and element id
    $config['run_translate_value']  = 'ushahidi_action.run_translate_value';
    
    // event to translate filter sql
    $config['run_translate_value_sql']  = 'ushahidi_filter.run_translate_value_sql';
   // example
  /* if (Session::instance()->get('locale',FALSE)==Kohana::config('translator.second_lang')){
            Event::run('ushahidi_filter.run_translate_value_sql', $sql);
         
        }*/
  
    // list of fields, type can be text or textarea  
    $config['translate_fields'] = array (
                                        array('type'=>'text','name'=>'title','original_name'=>'incident_title', 'value'=>''),
                                        array('type'=>'textarea','name'=>'text','original_name'=>'incident_description', 'value'=>'')
                                        
                                        );
                                        
    $config['original_lang'] = 'ru_RU';
    $config['original_lang_ya_name'] = 'ru';
    $config['second_lang'] = 'uk_UA';
    $config['second_lang_ya_name'] = 'uk';
    // key from yandex-translate service 
    $config['yandex_key'] = 'trnsl.1.1.20130920T141311Z.5214cfd4bd193fc7.105b47aa6bb6b0df1db2cd9599d2cfe6c0a0c428';
    
?>