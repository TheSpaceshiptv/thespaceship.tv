<?php 


get_header(); 

$actual_link = "https://$_SERVER[HTTPS_HOST]$_SERVER[REQUEST_URI]";
$bang = '/?/';

$is_bang = ( strpos($actual_link, $bang) !== false ) ? true : false;

if ($is_bang): $after_bang = end(explode($bang, $actual_link));
else: $after_bang = '1';
endif;



$per_page = '14';
$is_cat = ( strpos($after_bang, '/') !== false ) ? true : false;

if(explode('/', $after_bang, 2)[0] == 'merch'):

	$my_cat 	= explode('/', $after_bang, 2)[0];
    $after_cat 	= end(explode($my_cat, $after_bang));
    $my_page 	= end(explode('/', $after_cat));
    $my_offset = $per_page * ($my_page - 1);
    $total_shows = (new WP_Query( array( 'post_type' => 'product', 'product_cat' => $my_cat, 'post_status' => 'publish', 'posts_per_page' => -1 ) ))->found_posts;
    $total_pages = ceil($total_shows / $per_page);
    $first_page = ($my_page == 1) ;
    $last_page = ($my_page == $total_pages) ;
    $next_page = GET('siteurl') . $bang . $my_cat . '/' . ($my_page + 1);
    $prev_page = GET('siteurl') . $bang . $my_cat . '/' . ($my_page - 1);

    wp_reset_query(); 
    $args = array( 
      'post_type' => 'product', 
      'posts_per_page' => $per_page, 
      'product_cat' => $my_cat,  
      'orderby' => 'meta_value', 
      'order' => 'DESC', 
      'offset' => $my_offset
    );

elseif($is_cat):

	$my_cat 	= explode('/', $after_bang, 2)[0];
    $after_cat 	= end(explode($my_cat, $after_bang));
    $my_page 	= end(explode('/', $after_cat));
    $my_offset = $per_page * ($my_page - 1);
    $total_shows = (new WP_Query( array( 'post_type' => 'product', 'product_cat' => $my_cat, 'post_status' => 'publish', 'posts_per_page' => -1 ) ))->found_posts;
    $total_pages = ceil($total_shows / $per_page);
    $first_page = ($my_page == 1) ;
    $last_page = ($my_page == $total_pages) ;
    $next_page = GET('siteurl') . $bang . $my_cat . '/' . ($my_page + 1);
    $prev_page = GET('siteurl') . $bang . $my_cat . '/' . ($my_page - 1);

    wp_reset_query(); 
    $args = array( 
      'post_type' => 'product', 
      'posts_per_page' => $per_page, 
      'product_cat' => $my_cat, 
      'meta_key' => 'start_time', 
      'orderby' => 'meta_value', 
      'order' => 'DESC', 
      'offset' => $my_offset
    );

else:

    $my_page 	= $after_bang;
    $my_offset = $per_page * ($my_page - 1);
    $total_shows = (new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => -1 ) ))->found_posts;
    $total_pages = ceil($total_shows / $per_page);
    $first_page = ($my_page == 1);
    $last_page = ($my_page == $total_pages);
    $next_page = GET('siteurl') . $bang . ($my_page + 1);
    $prev_page = GET('siteurl') . $bang . ($my_page - 1);

    wp_reset_query(); 
    $args = array( 
      'post_type' => 'product', 
      'posts_per_page' => $per_page, 
      'product_cat' => $my_cat, 
      'meta_key' => 'start_time', 
      'orderby' => 'meta_value', 
      'order' => 'DESC', 
      'offset' => $my_offset 
    );

endif;


$loop = new WP_Query( $args );
$featured_active = false;

while ( $loop->have_posts() ) : $loop->the_post(); 
  global $product; 

  $times = get_times();
  
  if (!$featured_active && !$times->is_late) {
    echo "<div class=featured>";
    $featured_active = true;
  } 
  elseif ($featured_active && $times->is_late) {
    echo '</div>  <!-- end featured section -->';
    $featured_active = false;
  }

?>




<?php if($my_cat=='merch'):?>
<script>
      document.body.classList.add("body-merch");
</script>
<?php endif; ?>





<article class="site-card <?php echo $my_cat?>"> 
    <?php $notes = GET('notes'); ?>

    <a href="<?php echo GET('permalink')?>" class="aside show-info">
		<?php show_info();?>
    </a>
    
    <div class="main">
    
        <a href="<?php echo GET('permalink') ?>">
            <h1><?php the_title();  ?></h1>
        </a>
        
        
        
        
<?php
        $terms = get_the_terms($product->ID, 'product_cat');
        foreach ($terms as $term) {

            $product_cat = $term->name;
            $product_slug = $term->slug;
            echo '<p><a href="' . GET('siteurl') . '/?/' . $product_slug . '/1">'. $product_cat . '</a></p>';
        }
 ?>
        
        
        
        
		<?php echo $notes; ?>
        
		

        <a href="<?php echo GET('permalink')?>" class="card-button">
            <?php
            if ($my_cat=='merch'): echo '$' . number_format((float)(
              $product->get_price()
            ), 2, '.', '');
            elseif ( $times->is_showtime ): echo 'LIVE NOW';
            elseif ( GET('bought') && $times->is_early ): echo 'WATCH SOON';
            elseif ( GET('bought') ): echo 'WATCH NOW';
            elseif ( $product->get_price() == 0): echo 'WATCH FREE';
            elseif ( $times->is_late): echo 'WATCH FOR $' . $product->get_price();
            else: echo '$' . $product->get_price() . ' TICKETS';
            endif; ?> 
            ⇨
        </a>
        

    </div>

</article>


<?php 
endwhile;
?>


<nav id="page-links" class="page-links">
<?php 
if($total_pages > 1) {
  echo '<div id="page-select"><span class="page-select-label">Select a page: </span>';
  for ($x = 1; $x <= $total_pages; $x++) {
    if ($x == $my_page){
      echo '<a class="selected">' . $x . '</a>';
    }
    else {
      echo '<a href="' . GET('siteurl') . $bang;
      echo ($is_cat) ? $my_cat . '/' : ''; 
      echo ($x) . '">' . $x . '</a>';  
    }
  }
  echo '<a href="#page-links">Cancel</a></div>';
}
if ($my_page == 2 && !$is_cat):
  echo '<a class="bubble" href="' . GET('siteurl') . '">⇦</a>';
else:
  echo ($first_page) ? '' : '<a class="bubble" href="' . $prev_page . '">⇦</a>';
endif;
echo ($total_pages > 1) ? '<span class="page-display">Page <a class="current-page" href="#page-select">' . $my_page . '</a><a href="#page-links" class="current-page cancel">×</a> of ' . $total_pages . '</span>' : '';

echo ($last_page) ? '' : '<a class="bubble" href="' . $next_page . '">⇨</a>';
?>
</nav>


<?php
echo '<nav class="filter_shows">';

if ($my_cat=='merch') { 
  ?>
  <a href="<?php echo GET('siteurl')?>">⇦ Go Home</a> 
  <?php 
}

else {
  echo '<a href="' . GET('siteurl') .'"' . (($is_cat) ? '' : 'class="active"') . '>All </a>';
    $taxonomy     = 'product_cat';
    $orderby      = 'name';  
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no  
    $title        = '';  
    $empty        = 0;

    $args = array(
          'taxonomy'     => $taxonomy,
          'orderby'      => $orderby,
          'show_count'   => $show_count,
          'pad_counts'   => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li'     => $title,
          'hide_empty'   => $empty
    );
  $all_categories = get_categories( $args );
  foreach ($all_categories as $cat) {
      if($cat->category_parent == 0) {
          $category_id = $cat->term_id;       
          if($my_cat == $cat->slug) { $active = ' class="active"'; } else { $active = ''; }
          echo '<a href="' . GET('siteurl') . $bang . $cat->slug . '/1"' . $active . '>'. $cat->name .'</a>';

          $args2 = array(
                  'taxonomy'     => $taxonomy,
                  'child_of'     => 0,
                  'parent'       => $category_id,
                  'orderby'      => $orderby,
                  'show_count'   => $show_count,
                  'pad_counts'   => $pad_counts,
                  'hierarchical' => $hierarchical,
                  'title_li'     => $title,
                  'hide_empty'   => $empty
          );
          $sub_cats = get_categories( $args2 );
          if($sub_cats) {
              foreach($sub_cats as $sub_category) {
                  echo  $sub_category->name ;
              }   
          }
      }       
  }
}
echo '</nav>';
?>


<?php wp_reset_query(); ?>
<?php get_footer(); ?>
