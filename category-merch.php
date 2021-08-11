<?php 

get_header(); 

WC()->cart->empty_cart(); 

while ( have_posts() ): the_post();

?>

<article class="site-card"> 
    <?php the_content(); ?>


<?php 

endwhile; //end post loop

get_footer(); 

?> 