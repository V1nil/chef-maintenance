<?php
//function for pagination
 function msaispa_pagination($pages = '', $range = 4)
{ 
     $showitems = ($range * 2)+1; 
     //global $paged;
	 $paged = (sanitize_text_field( $_GET['paged'] )) ? sanitize_text_field( $_GET['paged'] ) : 1;
     if(empty($paged)) $paged = 1;
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;&lsaquo;</a>"; //previous
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;&rsaquo;</a>"; //next
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}


//function for post cout by meta key
function msaispa_get_post_count( $kword){
  
    $post_nct='';
	global $wpdb;
	ob_start();
	//all post types array
	$post_type_to_exclude=array('attachment','revision' , 'nav_menu_item');
	$post_type_to_include=array();
	$all_post_types = get_post_types( '', 'names' ); 
	foreach ( $all_post_types as $post_type ) {
		 if ( !in_array($post_type, $post_type_to_exclude)) {
			$post_type_to_include[]= $post_type;
		 }
	}
	
	$args = array(
		   'post_type' => $post_type_to_include,
		   'meta_key' => '_aioseop_title',
		   'post_status'       => 'publish',
		   'posts_per_page' => -1,
		   'meta_query' => array(
			   array(
				   'key' => '_aioseop_title',
				   'value' =>  $kword,
				   'compare' => '=',
			   )
		   )
		 );
	$the_query = new WP_Query( $args );	 
	$post_nct= $the_query->found_posts;
	return $post_nct; 
}



global $wpdb;
$keyword_to_search =sanitize_text_field( $_POST['sk'] );

//initialize variables
$order='ASC';
$ancorder='desc';
$classorder='asc';
$orderby='date';

if(sanitize_text_field( $_GET['orderby']) == 'meta_value' ){
$orderby='meta_value';
}

if(sanitize_text_field( $_GET['order']) == 'asc'){
$ancorder='desc';
$classorder='desc';
$order='ASC';
}

if(sanitize_text_field( $_GET['order']) == 'desc'){
$ancorder='asc';
$classorder='asc';
$order='DESC';
}

//all post types array
$post_type_to_exclude=array('attachment','revision' , 'nav_menu_item');
$post_type_to_include=array();
$all_post_types = get_post_types( '', 'names' ); 
foreach ( $all_post_types as $post_type ) {
	 if ( !in_array($post_type, $post_type_to_exclude)) {
		$post_type_to_include[]= $post_type;
	 }
}			 

?>
   
<div class="wrap netgo-admin-page-setting">
	<h2><?php _e('All in One SEO Title Stats','');?></h2>
	<?php 
	$paged = (sanitize_text_field( $_GET['paged'] )) ? sanitize_text_field( $_GET['paged'] ) : 1;
	$post_per_page=10;
	
	if($keyword_to_search != ''){ // search keyword
	
	$post_types= $post_type_to_include;
	
	if(sanitize_text_field( $_POST['pst_type'] ) != ''){
	 $post_types= sanitize_text_field( $_POST['pst_type'] );
	 $pst_ty= sanitize_text_field( $_POST['pst_type'] );
	}
	$args = array(
	   'post_type' => $post_types,
	   'meta_key' => '_aioseop_title',
	   'post_status'       => 'publish',
	   'posts_per_page' => $post_per_page,
	   'paged' => $paged,
	   'orderby'           => 'date',       
	   'order' => 'ASC',
	   'meta_query' => array(
		   array(
			   'key' => '_aioseop_title',
			   'value' => $keyword_to_search,
			   'compare' => 'LIKE',
		   )
	   )
	 );
	
	}else{ // all keyword
	
	 $post_types= $post_type_to_include;
	 $args = array(
	   'post_type' => $post_types,
	   'meta_key' => '_aioseop_title',
	   'post_status'       => 'publish',
	   'posts_per_page' => $post_per_page,
	   'paged' => $paged,
	   'orderby'           => 'meta_value',    
	   'order' => $order,
	   'meta_query' => array(
		   array(
			   'key' => '_aioseop_title',
			   'compare' => 'EXISTS',
		   )
	   )
	 );
	 
	} 

	$the_query = new WP_Query( $args );
	?>

  <table class="wp-list-table widefat fixed striped pages">
   <tr>
    <td colspan="2">
	<?php if($keyword_to_search !=''){ ?>
	<span>Search results for “<?php echo $keyword_to_search; ?>”</span>
	<?php } ?>
	</td>
	<td colspan="2">
	<div align="right">
	 <form method="post" action="<?php echo get_option('home');?>/wp-admin/admin.php?page=msaispa-title-stats" id="posts-filter">  
	    <select style="width:150px" id="all-post-type" name="pst_type">
		<option value="">Select Post type</option>
		 <?php 
		    $nottoshowarr=array('attachment','revision' , 'nav_menu_item');
			$post_types = get_post_types( '', 'names' ); 
			foreach ( $post_types as $post_type ) {
			 if ( !in_array($post_type, $nottoshowarr)) {
				?>
				  <option <?php if($pst_ty == $post_type){ ?>selected="selected" <?php } ?> value="<?php echo $post_type;?>"><?php echo $post_type;?></option>
				<?php
				} 
			}

		 ?>
			
		</select>
	 
		<input type="search" placeholder="Search Title" value="<?php echo $keyword_to_search;?>" name="sk" id="post-search-input">
		<input type="submit" value="Search Title" class="button" id="search-submit">
	 </form> 
	</div> 
	 </td>
	</tr>
  </table>
  <table class="wp-list-table widefat fixed striped pages"> 
   
	<thead>
	<tr>
	   <td width="50%"><strong><a class="class-to-<?php echo $classorder; ?>" href="<?php echo get_option('home');?>/wp-admin/admin.php?page=msaispa-title-stats&orderby=meta_value&order=<?php echo $ancorder; ?>"> Title</a></strong></td>
	   <td width="30%"><strong>Page /Post Title</strong></td>
	   <td width="10%"><strong>Color Flag</strong></td>
	   <td width="10%"><strong>Post Type</strong></td>
	</tr>
	</thead>
	<tbody>
	<?php 
	// The Loop
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$kword='';
	?>
	<tr>
	   <td width="50%"><?php echo $kword= get_post_meta( get_the_ID(), '_aioseop_title', true ); ?></td>
	   <td width="30%"><?php the_title(); ?></td>
	   <?php  $post_cnt= msaispa_get_post_count( $kword);
         $flagclass='flag-green';
		 if($post_cnt > 1){
		   $flagclass='flag-red';
		 }
	   ?>
	   <td width="10"><span class="<?php echo $flagclass; ?>"></span></td>
	   <td width="10%"><?php echo get_post_type( get_the_ID() ); ?></td>
	</tr>
	<?php		
	endwhile;
	endif;
	
	// if keword is not found 
	if($the_query->found_posts < 1){
	?>
	<tr>
	   <td colspan="4"><strong><i>No title yet.</i></strong></td>
	  
	</tr>
	<?php
	
	}
	
	// Reset Post Data
	wp_reset_postdata();
	?>
	
<?php 
//pagination 
if (function_exists("msaispa_pagination")) {
?>
	<tr>
	   <td colspan="4">
	    <div  style="float:right;"><?php msaispa_pagination($the_query->max_num_pages); ?></div>
	   </td> 
	</tr>
<?php
} 
?>

	
  </tbody>
  </table>
</div>

