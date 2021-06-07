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

		<?php 
		
		$notes = GET('notes'); 

		?>

	    <!-- CHAT -->
	    <?php if ( ($times->is_chat_open) && ( $bought || $free || $admin || $crew ) ): ?> 
	    <div class="site-chat"><iframe src="https://vimeo.com/live-chat/<?php echo GET('videoid'); ?>/<?php echo GET('chatid'); ?>" width="100%" height="100%" frameborder="0"></iframe></div>
	    <?php endif; ?>

	    <!-- WOOCOMMERCE STUFF -->
	    <?php if ( $free || $bought || $admin || $crew ): else: the_content(); endif; ?>

	    <!-- RIGHT COLUMN SHOW NOTES -->
	    <?php if ( ($times->is_late || $times->is_early) && !($times->is_chat_open) && ($bought || $free || $admin || $crew)): ?>
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
	    	<?php echo $notes; ?>
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
		<?php if ( ($times->is_chat_open) || !( $bought || $free || $admin || $crew ) ): 
	    $terms = get_the_terms($product->ID, 'product_cat');
	    foreach ($terms as $term) {
			$product_cat = $term->name;
			$product_slug = $term->slug;
			echo '<p><a href="' . GET('siteurl') . '/?/' . $product_slug . '/1">'. $product_cat . '</a></p>';
	    }
	    ?>
	    <p>...start transmission</p>
	    <?php echo $notes; ?>
	    <p>end transmission...</p>
	    <?php endif; ?>


    </div>


<!-- RELOAD IF SHOW GOES LIVE -->
<?php if( $times->is_early && $times->is_chat_open && ( $bought || $free || $admin || $crew ) ): ?>
<script>
	var TimeLeft = (<?php print $times->start_timestamp; ?> - <?php print $times->current_timestamp; ?>) * 1000;
	setTimeout(
		function(){
			document.getElementById("replace").textContent="LIVE";
			document.getElementById("replace").classList.add("live-text");
		},
		TimeLeft
	);
</script>
<?php endif; ?>



<?php 

endwhile; //end post loop

get_footer(); 

?> <?php
/**
 * Turn all URLs in clickable links.
 * 
 * @param string $value
 * @param array  $protocols  http/https, ftp, mail, twitter
 * @param array  $attributes
 * @return string
 */
public function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
{
	// Link attributes
	$attr = '';
	foreach ($attributes as $key => $val) {
		$attr .= ' ' . $key . '="' . htmlentities($val) . '"';
	}
	
	$links = array();
	
	// Extract existing links and tags
	$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
	
	// Extract text links for each protocol
	foreach ((array)$protocols as $protocol) {
		switch ($protocol) {
			case 'http':
			case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
			case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
			case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
			default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
		}
	}
	
	// Insert all link
	return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}?>