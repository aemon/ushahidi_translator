jQuery(document).ready(function(){
    var chosen_params = {
        width: "200px",
        no_results_text: '<a class="add_chosen_val" href ="#">+</a>'
    };
    jQuery('#marks_select').chosen(chosen_params);
    jQuery('.add_chosen_val').live('click',function(){
        name = jQuery(this).parents('.chzn-container').find('ul.chzn-choices li.search-field input').val();
        ind = 0; 
        jQuery(this).parents('.chosen_wrap').find('select.chosen_marks').append('<option selected="selected" value="'+ind+'">'+name+'</option>')
        
        // don`t work standart chosen update   
        jQuery('#marks_select_chzn').remove();  
        jQuery('#marks_select').removeClass('chzn-done'); 
        jQuery('#marks_select').chosen(chosen_params);
        jQuery('#hidden_marks').html('');
        jQuery('#marks_select option').filter(':selected').each(function(){
            if (jQuery(this).val()==0){
                jQuery('#hidden_marks').append('<option value="'+jQuery(this).text()+'" selected="selected"></option>');
            }
        })
        //----------------                               

    });
    jQuery('#marks_select').change(function(){
        jQuery('#hidden_marks').html('');
        jQuery('#marks_select option').filter(':selected').each(function(){
            if (jQuery(this).val()==0){
                jQuery('#hidden_marks').append('<option value="'+jQuery(this).text()+'" selected="selected"></option>');
            }
        }) 
    })

})