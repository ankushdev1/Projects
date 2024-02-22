<?php
/*
Plugin Name:Combo Product
Description:Custom plugin for combo product 
*/
// Add custom product setting tab
function filter_woocommerce_product_data_tabs( $default_tabs ) {
    $default_tabs['combo_product'] = array(
        'label'     => __( 'Combo Product', 'woocommerce' ),
        'target'    => 'add_coumbo_product',
        'priority'  => 80,
        'class'     => array()
    );

    return $default_tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'filter_woocommerce_product_data_tabs', 10, 1 );

// Contents custom product setting tab
function action_woocommerce_product_data_panels() {
    global $post;

    $product_ids = get_post_meta( $post->ID, 'save_coumbo_product', true );
    $product_ids = unserialize($product_ids);
	?>
    <!-- Note the 'id' attribute needs to match the 'target' parameter set above -->
    <div id="add_coumbo_product" class="panel woocommerce_options_panel hidden">
        <p class="form-field stock_sync_data">
            <label for="stock_sync_data"><?php esc_html_e( 'Search Product', 'woocommerce' ); ?></label>
            <select class="wc-product-search select2-hidden-accessible" multiple="multiple" style="width: 50%;"  name="stock_sync_data[]" data-exclude="212674">
                <?php  
                foreach ( $product_ids as $product_id ) {
                $title = get_the_title( $product_id );
				$title = ( mb_strlen( $title ) > 50 ) ? mb_substr( $title, 0, 49 ) . '...' : $title;
                ?>
				<option value="<?php echo $product_id;?>" selected="selected"><?php echo $title;?></option>
				<?php
                }
                ?>
            </select>    
        </p>
    </div>
    <?php
}
add_action( 'woocommerce_product_data_panels', 'action_woocommerce_product_data_panels' );
/* function add_combo_prdouct_js() {     
    wp_enqueue_script( 'combojs', plugin_dir_url( __FILE__ ) . 'js/combo.js');
}   
add_action('admin_enqueue_scripts', 'add_combo_prdouct_js'); */
function add_combo_prdouct_js() {   
    wp_enqueue_script( 'jquery' );   
    wp_enqueue_script( 'combojs', plugin_dir_url( __FILE__ ) . 'js/cddddwfdddfff.js'); 
	 wp_localize_script( 'combojs', 'ajax', array(  
        'ajaxurl' => admin_url( 'admin-ajax.php' )
    ) );   
}   
add_action('wp_enqueue_scripts', 'add_combo_prdouct_js');
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Text Field
    $woo_combo_pro  = $_POST['stock_sync_data'];
	$woo_combo_pro = serialize($woo_combo_pro);
        update_post_meta($post_id, 'save_coumbo_product',$woo_combo_pro);	
}    
function get_combo_products_list(){
ob_start();  
$product_id = get_the_id();
$save_coumbo_product_id = get_post_meta($product_id,'save_coumbo_product',true);
$save_coumbo_product_id = unserialize($save_coumbo_product_id);
if(!empty($save_coumbo_product_id)){
$args = array(
    'post_type' => 'product',
    'posts_per_page'=>-1,
	'post_status'=>"publish",
	'post__in'=>$save_coumbo_product_id,
);
$post_query = new WP_Query($args);
$ids_gett = array();
while($post_query->have_posts()):$post_query->the_post();
$idd =get_the_id();
$term = get_term_by('term_id',$idd, 'product_cat'); 
$name_cat = $term->name;
$discontinue_pro = get_post_meta($idd,"_discontinued_product",true);
$stock_discontinued = get_post_meta($idd,"_stock_discontinued_product",true);
if($discontinue_pro == "yes" || $stock_discontinued == "yes"||$name_cat == "Uncategorised"){
  
}
else{
$ids_gett[]=$idd;	
}
endwhile;
wp_reset_postdata();
array_unshift($ids_gett , $product_id);
?>
<h2 class="combo_pro_heading">Pick the Combo</h2>
<div class="buy_togther_pro">
<div class="mian_combo_list">
<?php
$idselected=array();
$ids_pro=array();
foreach($ids_gett as $save_coumbo_product_id2){
$ids_pro[]= $save_coumbo_product_id2;
$get_products = wc_get_product($save_coumbo_product_id2);

$current_prducts = $get_products->get_children();
$get_pro_title = $get_products->get_title(); 
$product_image = wp_get_attachment_image_src(get_post_thumbnail_id($save_coumbo_product_id2 ), 'full');
?>  
<?php
if($save_coumbo_product_id2 == $product_id){	
?>	
<div class="inner_selected_product"> 
<a href="<?php echo get_the_permalink($save_coumbo_product_id2);?>"><img src="<?php  echo $product_image[0]; ?>">
<h2 class="title_coumbo_pro"><?php echo $get_pro_title;?></h2></a>
<?php 
$product_price1 = $get_products->get_price_html();
if($product_price1){
?>
<?php echo $product_price1;?> 
<?php
}?>
<select class="get_select_productss">
<?php 
foreach($current_prducts as $current_prductsmain){
	$product_variation1 = wc_get_product($current_prductsmain); 
    $size_pro1 = $product_variation1->get_attribute( 'size' );
	//$stock_var_status1 = get_post_meta( $current_prducts2,'_stock_status', true );
?>
<option value="<?php echo $current_prductsmain;?>" data-status="<?php //echo $stock_var_status;?>"><?php echo $size_pro1;?></option>

<?php	
}  
?>
</select>
</div>
<?php	
}
else{
	?>
<div class="inner_selected_product"> 
<a href="<?php echo get_the_permalink($save_coumbo_product_id2);?>"><img src="<?php  echo $product_image[0]; ?>" style="width=80px;height:80px">
<h2 class="title_coumbo_pro"><?php echo $get_pro_title;?></h2></a>
<?php 
$product_price1 = $get_products->get_price_html();
if($product_price1){
?>
<?php echo $product_price1;?> 
<?php
}  

if(!empty($current_prducts)){ ?> 
<select name="get_select_productss" class="get_select_productss">
<option value="">Select variation</option>
<?php 

foreach($current_prducts as $current_prducts2){
	$idselected[]=$current_prducts2;
	$product_variation = wc_get_product($current_prducts2); 
    $size_pro = $product_variation->get_attribute( 'size' );
	$stock_var_status = get_post_meta( $current_prducts2,'_stock_status', true );
?>
<option value="<?php echo $current_prducts2;?>" data-status="<?php echo $stock_var_status;?>"><?php echo $size_pro;?></option>
<?php
}

?> 
</select>  
<span class="stock_msg_text"></span>
<form method="post" class="coumbo_btn_form">
<input type="hidden" name="product_idd" class="productid" value="<?php echo $save_coumbo_product_id2;?>">
<input type="hidden" name="prodoct_var_select" class="prodoct_var_select">
<input type="submit" name="buy_item_var" value="Add to cart" class="mutiple_var_pro" disabled>
</form>  


<?php } 
else{
	?>
  <form method="post">	
  <input type="hidden" name="single_pro_id" value="<?php echo $save_coumbo_product_id2;?>">
  <input type="submit" name="but_single_product" value="Add to cart" class="single_var_pro">	
  </form>	
	<?php
}
?>
</div>	
<?php	
}

?>

<?php 
  	
}

?>
</div>
<?php
//$ids_pro=implode(",",$ids_pro);
?> 
</div>
<?php

}
$data = ob_get_contents();
ob_end_clean();
return $data; 	
}  
add_shortcode("combo_pro_list","get_combo_products_list");

function new_ajax_coumbo(){
$get_val_pro = $_POST['get_val_pro'];
echo $stock_status = get_post_meta($get_val_pro,'_stock_status',true);
wp_die();	
}
add_action("wp_ajax_nopriv_coumbo_select_product","new_ajax_coumbo");
add_action("wp_ajax_coumbo_select_product","new_ajax_coumbo"); 