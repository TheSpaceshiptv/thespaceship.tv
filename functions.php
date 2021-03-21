<?php



// ⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣴⣶⡀⠀⠀⠀⠀
// ⠀⠀⠀⠀⠀⠀⠀⠀⢱⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣼⣿⣿⣷⠀⠀⠀⠀
// ⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣶⡀⠀⠀⠀⠀⣀⣀⣀⣀⣀⣼⣿⣿⡏⢹⠀⠀⠀⠀
// ⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⣿⣿⡿⣻⣿⡷⣿⣿⣿⣿⣿⣿⣿⣿⣧⡀⠀⠀⠀⠀
// ⠀⠀⢀⣀⣠⠤⣤⣤⣼⣿⣿⣿⣇⢋⠟⣿⡿⠿⠛⠛⠛⠛⠛⠛⠿⢧⣤⣀⣀⠀
// ⢠⡖⠉⠴⢾⣿⡿⠋⠐⠈⢹⣿⣇⠢⡎⠁⠀⠀⠀⠀⠀⠀⠀⠀⡀⠀⠈⣿⣿⡇
// ⢸⠁⠀⣃⣀⠃⠀⠀⠀⠀⢸⡟⠀⠈⣧⠀⠀⠀⠀⠀⠀⠀⠀⠀⠁⠀⠀⣿⠁⠀
// ⠈⡇⠀⠈⠉⠁⠀⠀⠀⠀⡜⠀⢰⡀⠘⣆⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣿⠀⠀
// ⠀⠹⡀⠀⠀⠀⠀⠀⡠⠚⣠⣔⣶⠀⢀⡘⢦⣀⠀⠀⠀⠀⠀⠀⠀⢀⣾⢿⡆⠀
// ⠀⠀⠈⠐⠲⠶⠒⠋⠁⢾⡎⠻⠉⠡⠾⠋⣀⡈⠙⢒⣒⠠⠤⣤⣖⣿⣿⣿⡇⠀
// ⠀⠀⠀⠀⠀⠀⣄⡀⠀⢋⠉⠀⠁⠀⠐⠐⠲⣶⣶⣿⠧⠁⢀⠶⣿⢿⣿⣿⣿⣄
// ⠀⠀⠀⠀⠀⣆⣙⢿⣷⣼⣛⠿⡷⠶⢶⣶⡾⢟⡋⢅⠀⠀⠀⢈⣁⣺⣿⣿⣿⣿
// ⠀⠀⢀⢀⣠⣿⣿⣯⣭⣽⣿⡿⠛⠻⢿⣿⣯⣧⡨⣮⡶⡤⠢⠽⠽⠿⣿⣿⣷⣿
// ⠀⠀⡨⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢷⣤⠉⢹⣯⣿⣜⣟⠊⠁⠀⣰⢶⣿⣿⣿⣿
// ⠀⢼⢻⣿⣿⣿⣿⣿⣿⣿⣟⢹⣿⡿⡵⣴⡌⠋⡟⠿⠎⡓⠞⠏⠙⠉⣉⣄⣼⣶



function custom_remove_all_quantity_fields( $return, $product ) {return true;}
add_filter( 'woocommerce_is_sold_individually','custom_remove_all_quantity_fields', 10, 2 );

// function cw_remove_quantity_fields( $return, $product ) { return true; }

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_theme_support( 'post-thumbnails' );

add_filter('term_links-post_tag','limit_to_five_tags');
function limit_to_five_tags($terms) {
return array_slice($terms,0,5,true);
}



add_action('admin_head', 'hide_editor');
function hide_editor() {
  echo '<style>
    .woocommerce-page #postdivrich,
    #wp-pods-form-ui-pods-meta-show-notes-editor-tools,
    #wp-admin-bar-new-content {
      display: none;
    } 
  </style>';
}

add_filter('pods_meta_default_box_title','changethatname');
function changethatname($value) {
$value = 'Show Details';
return $value;
}

function GET($i) {
    if($i == 'googlefont')  return 'https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100;0,400;0,700;1,400&display=swap';
    if($i == 'themeurl')    return bloginfo('template_url');
    if($i == 'siteurl')     return site_url();
    if($i == 'sitename')    return bloginfo('name');
    if($i == 'videoid')     return implode(",",get_post_meta( get_the_ID(), 'vimeo_id' ));
    if($i == 'notes')       return implode(",",get_post_meta( get_the_ID(), 'show_notes' ));
    if($i == 'start')       return implode(",",get_post_meta( get_the_ID(), 'start_time' ));
    if($i == 'end')         return implode(",",get_post_meta( get_the_ID(), 'end_time' ));
    if($i == 'cat')         return implode(",",get_post_meta( get_the_ID(), 'product_category' ));
    if($i == 'now')         return gmdate("Y-m-d, G:i", (strtotime(date('Y-m-d, G:i')) - 18000));
    if($i == 'startf')      return strtotime(GET('start'));
    if($i == 'endf')        return strtotime(GET('end'));
    if($i == 'nowf')        return strtotime(GET('now'));
    if($i == 'userid')      return get_current_user_id();
    if($i == 'useremail')   return get_userdata(get_current_user_id())->user_email;
    if($i == 'id')          return get_the_ID();
    if($i == 'permalink')   return get_permalink();
    if($i == 'bought')      return wc_customer_bought_product(GET('useremail'), GET('userid'), GET('id'));
    if($i == 'loggedin')    return is_user_logged_in();
    if($i == 'early')       return GET('nowf') < GET('startf');
    if($i == 'late')        return GET('nowf') > GET('endf');
    if($i == 'ontime')      return !GET('early') && !GET('late');
}

function show_info() {
    $date = GET('startf');
    if (has_post_thumbnail()){ 
        echo 
            '<img src="',
            the_post_thumbnail_url('thumbnail'),
            '">';
    }else{ 
        echo 
            '<img src="',
            bloginfo('template_url') ,
            '/assets/thumb' ,
            rand(1,5) ,
            '.jpg">'; 
    }
    if(GET('early')) echo '<div class="early-text">UPCOMING</div>';
    if(!(GET('early') || GET('late'))) echo '<div class="early-text live-text">LIVE</div>';
  
    echo
        '<div class="date-text">' .
        date('M j', $date) .
        '</div>';
    echo (GET('early') || GET('ontime')) ?
        '<div class="time-text">' .
        date('g:i A', $date) .
        '</div>' :
        '<div class="time-text">' .
        date('Y', $date) .
        '</div>' ;

    
}

function convert($input) {
    $pattern = '@(http(s)?://)?(([a-zA-Z0-9])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])+(?=<)@';
    return $output = preg_replace($pattern, '<a href="http$2://$3">$0</a>', $input);
 }

 add_filter('add_to_cart_redirect', 'lw_add_to_cart_redirect');
 function lw_add_to_cart_redirect() {
  global $woocommerce;
  $lw_redirect_checkout = $woocommerce->cart->get_checkout_url();
  return $lw_redirect_checkout;
 }

 // To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Buy Now', 'woocommerce' ); 
}