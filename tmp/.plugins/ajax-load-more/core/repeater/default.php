<div class="std-box-load-more">
	<div class="img-box" style="background-image:url('<?php if ( has_post_thumbnail() ) 	{ the_post_thumbnail_url();
   }?>');">
	</div>
	<div class="autor-img-box" style="background-image:url('http://desarrolloesencial.dev/wp-content/themes/chefSociety/images/user.jpg');">
		<a href="chef.php"></a>
	</div>
    <div class="content-box">

   		<h3><?php the_title(); ?></h3>
    	<p class="small"><em><?php the_time("F d, Y"); ?></em></p>
    	<p> <?php $excerpt = get_the_excerpt(); echo substr($excerpt,0,140); ?> </p>
    	<a class="read-more" href="<?php the_permalink(); ?>">
        	<i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>
    	</a>
    	<div class="gap-20"></div>
    </div>
    <div class="bottom-box">
    	<p><i class="fa fa-comment-o fa-lg" aria-hidden="true"></i><?php comments_number(' 0',' 1','%') ?></p>
    </div>
 </div>