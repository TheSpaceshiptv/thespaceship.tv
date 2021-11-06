<?php get_header(); ?>
<div style="background:rgba(0,0,0,.75); border-radius:20px; margin:20px; padding: 20px; box-shadow: 0 0 20px black;">
	<h1>Page not found!</h1>
    <p><a href="<?php echo site_url(); ?>" >Sorry, this page doesn't seem to exist. Click here to go home.</a></p>
</div>

<?php if ( WC()->cart->get_cart_contents_count() == 0 ) {
    echo "test";
}
else {
    echo "not test";
}
?>

<?php get_footer(); ?>
