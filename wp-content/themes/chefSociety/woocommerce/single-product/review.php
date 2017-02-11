<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$rating   = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

            <div class="row comment-block bk-w">
                <div class="comment-header-chef">
                    <?php 
                        $now = time(); // 
                        $your_date = strtotime(get_comment_date('c'));
                        $datediff = $now - $your_date;
                        $amount=floor($datediff/(60*60*24));
                        if($amount == 0){
                            $unit='horas';
                            $amount = floor($datediff/(60*60));
                        }elseif($amount == 1){
                            $unit='día';                            
                        }else{
                            $unit='días';                                                        
                        }
                    ?>
                    <?php 
                        //Recuperamos la fotografia del usuario que comentó si es que tiene y sino le ponemos la por defecto
                        $wp_user_data = get_user_meta($comment->user_id);         
                        if($wp_user_data['_chef_personal_photo'][0] != ''){
                            $wp_user_personal_photo = site_url($wp_user_data['_chef_personal_photo'][0]);
                        }else{
                            $wp_user_personal_photo = site_url('/wp-content/uploads/users/user.jpg');
                        }
        
                    ?>
                    <div class="comment-avatar-chef">
                        <img class="autor-img-box-header" src="<?php echo $wp_user_personal_photo; ?>" >
                    </div>
                    <div class="comment-name-date">
                        <h4><?php printf(__('<span>%s</span>', 'g5_chefSociety'), get_comment_author_link()); ?></h4>
                        <p class="comment-date-chef"><em><?php echo 'Hace '.$amount.' '.$unit ;?></em></p>
                    </div>
                </div>
                <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
                    <span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
                </div>
                <div class="comment-body-chef">
                    <p><?php comment_text(); ?></p>
                </div>
            </div>
            
            
            <!-- Orignalmente habia: -->
		<?php//  echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '' ); 
        do_action( 'woocommerce_review_before', $comment );
        ?>

	<!--	<div class="comment-text">

			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) : ?>
				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
				</div>
			<?php endif; ?>
			<?php do_action( 'woocommerce_review_before_comment_meta', $comment ); ?>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>
			<?php else : ?>
				<p class="meta">
					<strong itemprop="author"><?php comment_author(); ?></strong> <?php
						if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
							if ( $verified )
								echo '<em class="verified">(' . __( 'verified owner', 'woocommerce' ) . ')</em> ';
					?>&ndash; <time itemprop="datePublished" datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( wc_date_format() ); ?></time>:
				</p>
			<?php endif; ?>
			<?php 
            do_action( 'woocommerce_review_meta', $comment );
            do_action( 'woocommerce_review_before_comment_text', $comment ); ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>
			<?php do_action( 'woocommerce_review_after_comment_text', $comment ); ?>

		</div> -->
	</div>
