<?php 

get_header(); 

WC()->cart->empty_cart(); 

while ( have_posts() ): the_post();

?>

<article class="site-card"> 
    <?php 
    // do we need this? it's not doing anything, it's imploding a value and not outputting it or storing it or anything..
	// implode(",",get_post_meta( get_the_ID(), 'show_tag' )); 

	$free       = $product->get_price() == 0;
	$bought     = wc_customer_bought_product(get_userdata(get_current_user_id())->user_email, get_current_user_id(), get_the_ID());
	$loggedin   = is_user_logged_in();
	$admin		= current_user_can('administrator');
	$crew		= current_user_can('crew');

	// get the times object
	$times = get_times();

	/* EXAMPLE $times RESULT:
	stdClass Object
	(
	    [current_human] => Mar 23, 2021 10:06 pm
	    [current_timestamp] => 1616537160
	    [start_human] => March 26, 2021 9:00 pm
	    [start_timestamp] => 1616792400
	    [end_human] => March 26, 2021 10:00 pm
	    [end_timestamp] => 1616796000
	    [is_chat_open] => 
	    [is_showtime] => 
	    [is_early] => 1
	    [is_late] => 
	)
	*/



	?>

    <div class="aside">
	<div class="show-info"><?php show_info(); ?></div>
	<div class="sticky-container">

	    <!-- CHAT -->
	    <?php if ( ($times->is_showtime || $times->is_early) && ( $bought || $free || $admin || $crew ) ): ?> 
	    <div class="site-chat"><iframe src="https://vimeo.com/live-chat/<?php echo GET('videoid'); ?>/<?php echo GET('chatid'); ?>" width="100%" height="100%" frameborder="0"></iframe></div>
	    <?php endif; ?>

	    <!-- WOOCOMMERCE STUFF -->
	    <?php if ( $free || $bought || $admin || $crew ): else: the_content(); endif; ?>

	    <!-- RIGHT COLUMN SHOW NOTES -->
	    <?php if ( $times->is_late && ($bought || $free || $admin || $crew)): ?>
	    <div class="side-notes">
		    <?php
		    $terms = get_the_terms($product->ID, 'product_cat');
		    foreach ($terms as $term) {
			$product_cat = $term->name;
			$product_slug = $term->slug;
			echo '<p><a href="' . GET('siteurl') . '/?/' . $product_slug . '/1">'. $product_cat . '</a></p>';
		    }
		    if (!$loggedin): ?>
		    <p><i>Enjoying the show? Consider <?php echo do_shortcode( '[xoo_el_action type="register" display="link" text="SIGNING UP" redirect_to="same"]' ); ?> to catch our latest live shows!</i></p>
		    <?php endif; ?>
		    <p>...start transmission</p>
		    <?php echo convert(implode(",",get_post_meta( get_the_ID(), 'show_notes' ))); ?>
		    <p>end transmission...</p>
	    </div>
	    <?php endif; ?>



	</div>        
    </div>
    <div class="main">
		<h1><?php the_title(); ?></h1> 

		<!-- PLAYER-->
		<?php if ( $bought || $free || $admin || $crew ): ?> 
	    <div style="padding:56.25% 0 0 0;position:relative;" class="site-video"><iframe src="https://player.vimeo.com/video/<?php echo GET('videoid'); ?>?byline=0&portrait=0&title=0&color=#E966C2&transparent=0" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" ></iframe></div>        
		<?php endif; ?>


		<!-- LEFT COLUMN SHOW NOTES -->
		<?php if ( ($times->is_showtime || $times->is_early) || !( $bought || $free || $admin || $crew ) ): 
	    $terms = get_the_terms($product->ID, 'product_cat');
	    foreach ($terms as $term) {
			$product_cat = $term->name;
			$product_slug = $term->slug;
			echo '<p><a href="' . GET('siteurl') . '/?/' . $product_slug . '/1">'. $product_cat . '</a></p>';
	    }
	    ?>
	    <p>...start transmission</p>
	    <?php echo convert( implode( ",",get_post_meta( get_the_ID(), 'show_notes' ) ) ); ?>
	    <p>end transmission...</p>
	    <?php endif; ?>

<?php //delete this block:
	if($admin) {
		echo
			"<br> current human: " . $times->current_human .
			"<br> current timestamp: " . $times->current_timestamp .
			"<br> start human: " . $times->start_human .
			"<br> start timestamp: " . $times->start_timestamp .
			"<br> end human: " . $times->end_human .
			"<br> end timestamp: " . $times->end_timestamp .
			"<br> is chat open: " . $times->is_chat_open .
			"<br> is showtime: " . $times->is_showtime .
			"<br> is early: " . $times->is_early .
			"<br> is late: " . $times->is_late;
	}
?>

    </div>

	
<!-- RELOAD IF SHOW GOES LIVE -->
<?php if( $times->is_chat_open && ( $bought || $free || $admin || $crew ) ): ?>
<script>
	var IsShowtime;
	function CheckIfShowtime() {
		IsShowtime = <?php print $times->is_showtime ?>;
	 	if(IsShowtime) {
	 		location.reload();
	 	}
	}
	setInterval(
		CheckIfShowtime(),
		1000
	);
</script>
<?php endif; ?>
	
	
	
<?php 
	
endwhile; //end post loop
    
get_footer(); 
    
?> <!-- test -->
