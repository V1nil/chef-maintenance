<?php
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
	<h2><?php _e('All in One SEO Meta Description Stats','');?></h2>
	<?php 
	$paged = (sanitize_text_field( $_GET['paged'] )) ? sanitize_text_field( $_GET['paged'] ) : 1;
	$post_per_page=10;
	
	if($keyword_to_search != ''){ // search Meta Description
	
	$post_types= $post_type_to_include;
	
	if(sanitize_text_field( $_POST['pst_type'] ) != ''){
	 $post_types= sanitize_text_field( $_POST['pst_type'] );
	 $pst_ty= sanitize_text_field( $_POST['pst_type'] );
	}
	$args = array(
	   'post_type' => $post_types,
	   'meta_key' => '_aioseop_description',
	   'post_status'       => 'publish',
	   'posts_per_page' => $post_per_page,
	   'paged' => $paged,
	   'orderby'           => 'date',       
	   'order' => 'ASC',
	   'meta_query' => array(
		   array(
			   'key' => '_aioseop_description',
			   'value' => $keyword_to_search,
			   'compare' => 'LIKE',
		   )
	   )
	 );
	
	}else{ // all keyword
	
	 $post_types= $post_type_to_include;
	 $args = array(
	   'post_type' => $post_types,
	   'meta_key' => '_aioseop_description',
	   'post_status'       => 'publish',
	   'posts_per_page' => $post_per_page,
	   'paged' => $paged,
	   'orderby'           => 'meta_value',    
	   'order' => $order,
	   'meta_query' => array(
		   array(
			   'key' => '_aioseop_description',
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
	 <form method="post" action="<?php echo get_option('home');?>/wp-admin/admin.php?page=mdsaiospa-description-stats" id="posts-filter">  
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
	 
		<input type="search" placeholder="Search Description" value="<?php echo $keyword_to_search;?>" name="sk" id="post-search-input">
		<input type="submit" value="Search Description" class="button" id="search-submit">
	 </form> 
	</div> 
	 </td>
	</tr>
  </table>
  <table class="wp-list-table widefat fixed striped pages"> 
   
	<thead>
	<tr>
	   <td width="50%"><strong><a class="class-to-<?php echo $classorder; ?>" href="<?php echo get_option('home');?>/wp-admin/admin.php?page=mdsaiospa-description-stats&orderby=meta_value&order=<?php echo $ancorder; ?>">Meta Description</a></strong></td>
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
	   <td width="50%"><?php echo $kword= get_post_meta( get_the_ID(), '_aioseop_description', true ); ?></td>
	   <td width="30%"><?php the_title(); ?></td>
	   <?php  $post_cnt= mdsaiospa_get_post_count( $kword);
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
	   <td colspan="4"><strong><i>No meta description yet.</i></strong></td>
	  
	</tr>
	<?php
	
	}
	
	// Reset Post Data
	wp_reset_postdata();
	?>
	
<?php 
//pagination 
if (function_exists("mdsaiospa_pagination")) {
?>
	<tr>
	   <td colspan="4">
	    <div  style="float:right;"><?php mdsaiospa_pagination($the_query->max_num_pages); ?></div>
	   </td> 
	</tr>
<?php
} 
?>

	
  </tbody>
  </table>
</div>

