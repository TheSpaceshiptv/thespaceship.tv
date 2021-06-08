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
    if($i == 'videoid')     return get_post_meta( get_the_ID(), 'vimeo_id', 1);
    if($i == 'chatid')      return get_post_meta( get_the_ID(), 'chat_id', 1);
    if($i == 'notes')       return get_post_meta( get_the_ID(), 'show_notes', 1);
    //if($i == 'notesf')      return convert(GET('notes'));
    if($i == 'start')       return get_post_meta( get_the_ID(), 'start_time', 1);
    if($i == 'end')         return get_post_meta( get_the_ID(), 'end_time', 1);
    if($i == 'cat')         return implode(",",get_post_meta( get_the_ID(), 'product_category' ));
    if($i == 'startf')      return strtotime(GET('start'));
    if($i == 'endf')        return strtotime(GET('end'));
    if($i == 'userid')      return get_current_user_id();
    if($i == 'useremail')   return get_userdata(get_current_user_id())->user_email;
    if($i == 'id')          return get_the_ID();
    if($i == 'permalink')   return get_permalink();
    if($i == 'bought')      return wc_customer_bought_product(GET('useremail'), GET('userid'), GET('id'));
    if($i == 'loggedin')    return is_user_logged_in();
}


function make_links_clickable($text){
    return preg_replace('([^ ]+)\.', '<a href="$1">$1</a>', $text);
}

function show_info() {
    $times = get_times();
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
    if( $times->is_early ) echo '<div class="early-text" id="replace">UPCOMING</div>';
    if( $times->is_showtime ) echo '<div class="early-text live-text">LIVE</div>';
  
    echo
        '<div class="date-text">' .
        date('M j', $times->start_timestamp ) .
        '</div>';
    echo ( $times->is_early ) ?
        '<div class="time-text">' .
        date('g:i A', $times->start_timestamp ) .
        '</div>' :
        '<div class="time-text">' .
        date('Y', $times->start_timestamp ) .
        '</div>' ;
}


function convert($input) {
    $pattern = '(http(s)?://)?(([a-zA-Z0-9])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])+(?=<)';
    return $output = preg_replace($pattern, '<a href="http$2://$3">$0</a>', $input);
}



// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Buy Now', 'woocommerce' ); 
}



add_action('pre_get_posts', 'wpa_44672' );
function wpa_44672( $wp_query ) {
    //$wp_query is passed by reference.  we don't need to return anything. whatever changes made inside this function will automatically effect the global variable
    $excluded = array(4);  //made it an array in case you  need to exclude more than one
    // only exclude on the home page
    if( is_home() ) {
        set_query_var('category__not_in', $excluded);
        //which is merely the more elegant way to write:
        //$wp_query->set('category__not_in', $excluded);
    }
}



// a function to get the times for an event and do a bunch of calculation/evaluation
function get_times() {
    // empty object for us to start filling with info
    $times = new stdClass;

    // get the current time based on our timezone
    $current = new DateTime( "now", new DateTimeZone('America/Chicago') );

    // format current time, store it, and make a unix timestamp version of it
    $times->current_human = $current->format( "M j, Y g:i a" );
    $times->current_timestamp = strtotime( $times->current_human );

    // get the start time, and convert to unix timestamp
    $times->start_human = GET('start');
    $times->start_timestamp = strtotime( $times->start_human );

    // get the end time, and convert to unix timestamp
    $times->end_human = GET('end');
    $times->end_timestamp = strtotime( $times->end_human );

    // boolean for if chat is open (chat opens one hour before event)
    $times->is_chat_open = $times->current_timestamp >= ( $times->start_timestamp - 3600 ) && $times->current_timestamp <+ ( $times->end_timestamp + 3600 );

    // boolean for if chat is open (chat opens one hour before event)
    $times->is_showtime = $times->current_timestamp >= ( $times->start_timestamp ) && $times->current_timestamp <+ ( $times->end_timestamp );

    // boolean for if it's before show starts
    $times->is_early = $times->current_timestamp < $times->start_timestamp;

    // boolean for if it's after show ends
    $times->is_late = $times->current_timestamp >= $times->end_timestamp;

    // send the times back to the single template
    return $times;
}




