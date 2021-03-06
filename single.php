<?php get_header(); ?>  

<?php WC()->cart->empty_cart(); ?>

<?php while(have_posts()): the_post();?>

<article class = "site-card"> 
    
  
    <?php implode(",",get_post_meta( get_the_ID(), 'show_tag' )); ?>
    
    
	<?php 

	    $free       = $product->get_price() == 0;
	    $bought     = wc_customer_bought_product(get_userdata(get_current_user_id())->user_email, get_current_user_id(), get_the_ID());
	    $early      = GET('early');
	    $late       = GET('late');
	    $ontime     = GET('ontime');
	    $loggedin   = is_user_logged_in();
	    $admin	= current_user_can('administrator');
	    $crew	= current_user_can('crew');
	?>

	

	    <div class="aside">
		<div class="show-info"><?php show_info(); ?></div>
		<div class="sticky-container">



		    <!-- CHAT -->
		    <?php if ($ontime && ($bought || $free || $admin || $crew)): ?> 
		    <div class="site-chat"><iframe src="https://vimeo.com/live-chat/<?php echo GET('videoid'); ?>/" width="100%" height="100%" frameborder="0"></iframe></div>
		    <?php endif; ?>



		    <!-- WOOCOMMERCE STUFF -->
		    <?php if ($free || $bought || $admin || $crew): else: the_content(); endif; ?>



		    <!-- RIGHT COLUMN SHOW NOTES -->
		    <?php if (($late || $early) && ($bought || $free || $admin || $crew)): ?>
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
		<?php if ($bought || $free || $admin || $crew): ?> 
		    <div style="padding:56.25% 0 0 0;position:relative;" class="site-video"><iframe src="https://player.vimeo.com/video/<?php echo GET('videoid'); ?>?byline=0&portrait=0&title=0&color=#E966C2&transparent=0" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" ></iframe></div>        
		<?php endif; ?>


		<!-- LEFT COLUMN SHOW NOTES -->
		<?php if ( $ontime || !($bought || $free || $admin || $crew)): 
		    $terms = get_the_terms($product->ID, 'product_cat');
		    foreach ($terms as $term) {
			  $product_cat = $term->name;
			  $product_slug = $term->slug;
			  echo '<p><a href="' . GET('siteurl') . '/?/' . $product_slug . '/1">'. $product_cat . '</a></p>';
		    }
		    ?>
		    <p>...start transmission</p>
		    <?php echo convert(implode(",",get_post_meta( get_the_ID(), 'show_notes' ))); ?>
		    <p>end transmission...</p>
		    <?php endif; ?>



	    </div>

	
<!-- RELOAD IF SHOW GOES LIVE -->
<?php if($early): ?>
<script>
	var ShowTime = new Date('<?php GET('start'); ?>');
	var CurrentTime = new Date().toLocaleString();
	function CheckIfLive() {
		if(CurrentTime >= ShowTime) {
			location.reload();
		}
	}
	setInterval(
		CheckIfLive(),
		60000
	);
</script>
<?php endif; ?>
	
	
	
<?php 
	
endwhile; //end post loop
    
get_footer(); 
    
?>
