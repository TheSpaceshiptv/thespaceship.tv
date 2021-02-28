<?php get_header(); ?>
<!-- single product layout: -->

<p style="color:red;"> NOTICE: If you are paying with a credit card, please enter your information manually, to avoid errors. We are currently working to resolve this problem. Thank you for understanding. </p>
<?php while(have_posts()): the_post();?><article class = "site-card"> 



    <?php the_content(); ?>


</article><?php endwhile;?>

<?php get_footer(); ?>