<link  href="<?php echo url::site('/plugins/translator/views/css/translator.css') ?>" rel="stylesheet" type="text/css" >
     <script type="text/javascript">
//if(!window.jQuery){
  //  document.write('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"/>');
//}
</script>
<div class="translator_wrap">
<?php if(!empty($translate_fields)){ ?>
    <input type="button" onclick="translate_fields();" value="Перевести &darr;">
    <input type="button" onclick="re_translate_fields();" value="Перевести &uarr;">
<?php }?>
<?php foreach ($translate_fields as $field){ ?>
    <?php if ($field['type']=='text'){?>
        <input type="text" name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>" value="<?php echo $field['value'];?>" >
    
    <?php }elseif ($field['type']=='textarea'){?>
         <textarea  name="<?php echo $field['name'];?>" id="<?php echo $field['name'];?>"><?php echo $field['value'];?></textarea>
         
    <?php }?>
<?php }?>
</div>
<script type="text/javascript">
function translate_fields(){
    <?php foreach ($translate_fields as $field){ ?>   
        translate_field("#<?php echo $field['original_name'];?>","#<?php echo $field['name'];?>");    
    <?php }?>
}

function translate_field(from, to){
   // jQuery.getJSON('https://translate.yandex.net/api/v1.5/tr.json/translate?text='+  encodeURIComponent(jQuery(from).val(), "UTF-8") +
    jQuery.ajax({
        url: 'https://translate.yandex.net/api/v1.5/tr.json/translate?text='+  encodeURIComponent(jQuery(from).val(), "UTF-8") +
        '&lang=<?php echo Kohana::config('translator.original_lang_ya_name')?>-<?php echo Kohana::config('translator.second_lang_ya_name')?>'+
        '&format=html&key=<?php echo Kohana::config('translator.yandex_key')?>&callback=datacallback',
        type:'GET',
        dataType: 'jsonp',
         contentType: "application/json",
         crossDomain: true,
         success: function(data){
            if (data.code==200){
                jQuery(to).val(data.text);
            }
        }
    });
}

function datacallback(){
    
}

function re_translate_fields(){
    <?php foreach ($translate_fields as $field){ ?>   
        re_translate_field("#<?php echo $field['original_name'];?>","#<?php echo $field['name'];?>");    
    <?php }?>
}

function re_translate_field(to, from){
    jQuery.ajax({
        url: 'https://translate.yandex.net/api/v1.5/tr.json/translate?text='+  encodeURIComponent(jQuery(from).val(), "UTF-8") +
        '&lang=<?php echo Kohana::config('translator.second_lang_ya_name')?>-<?php echo Kohana::config('translator.original_lang_ya_name')?>'+
        '&format=html&key=<?php echo Kohana::config('translator.yandex_key')?>&callback=datacallback',
        type:'GET',
        dataType: 'jsonp',
         contentType: "application/json",
         crossDomain: true,
         success: function(data){
            if (data.code==200){
                jQuery(to).val(data.text);
            }
        }
    });
}
</script>
