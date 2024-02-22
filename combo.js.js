/* jQuery(document).on("change",".get_select_productss",function(){
	var get_val_pro = jQuery(this).val();
	if(get_val_pro == "Select variation" ||get_val_pro == ""){ 
	jQuery('.pro_id_buy').val("");	
	jQuery(".buy_combo_btn").prop('disabled', true); 
	jQuery(this).parent('.inner_selected_product').children('.show_staus_pro').text("");
	jQuery(this).parent('.inner_selected_product').removeClass("out_stock_pro"); 
	}      
	else{		
	var valuesget = [];  
    var status_insert = [];	
	jQuery('.get_select_productss option:selected').each(function(){
        valuesget.push(jQuery(this).val());
		valuesget = valuesget.filter(item => item);  
        status_insert.push(jQuery(this).attr('data-status'));
       var datastatus = jQuery(this).attr("data-status");
		if(datastatus == "outofstock"){
	jQuery(this).parent(".get_select_productss").parent('.inner_selected_product').addClass("out_stock_pro")
		}
		else{
		jQuery(this).parent(".get_select_productss").parent('.inner_selected_product').removeClass("out_stock_pro")	
		}
		
    });  

	var selected_ele = valuesget.length;
	var total_length = jQuery('.get_select_productss').length;
    
	if(selected_ele == total_length && !jQuery(".inner_selected_product").hasClass("out_stock_pro")){  
	jQuery(".buy_combo_btn").prop('disabled', false); 	  	
	}
	else{
	jQuery(".buy_combo_btn").prop('disabled',true);  			
	}
	
	jQuery('.pro_id_buy').val(valuesget);  
	
	var dataVariable = {
		 'action': 'coumbo_select_product',
		 get_val_pro:get_val_pro,  
     };    
	 var curent_el = jQuery(this);
    jQuery.ajax({
           url: ajax.ajaxurl, // this will point to admin-ajax.php
           type: 'POST',  
           data: dataVariable, 
           success: function (data) { 
		   //alert(data);
		   if(data == "outofstock"){
        curent_el.parent('.inner_selected_product').children('.show_staus_pro').text("Out of stock");	           
           } 
		  else{
		curent_el.parent('.inner_selected_product').children('.show_staus_pro').text(" ");  
		  } 
		   
		   }
        });   	
	}
	
  
});
jQuery(document).ready(function(){
var len_products = jQuery('.inner_selected_product').length;
if(len_products == 1){
jQuery('.inner_selected_product').addClass("pro_first_div");	
}
else{
jQuery('.inner_selected_product').removeClass("pro_first_div");		
} 
}); */       

jQuery(document).on("change",".get_select_productss",function(){
	var get_val_pro = jQuery(this).val();
	jQuery('.prodoct_var_select').val(get_val_pro);
	if(get_val_pro == "Select variation" ||get_val_pro == ""){ 
	jQuery(this).parent(".inner_selected_product").children('.coumbo_btn_form').children(".mutiple_var_pro").prop('disabled', true);
	}
	else{	  
	
	if(jQuery(this).find('option:selected').attr('data-status') == "outofstock"){
	jQuery(this).parent(".inner_selected_product").children('.coumbo_btn_form').children(".mutiple_var_pro").prop('disabled', true);	  
	jQuery(this).parent('.inner_selected_product').children(".stock_msg_text").text("Out of stock");
	}
	else{
	jQuery(this).parent(".inner_selected_product").children('.coumbo_btn_form').children(".mutiple_var_pro").prop('disabled', false);
	jQuery(this).parent('.inner_selected_product').children(".stock_msg_text").text("");
	}	
	}
	
	
	
});