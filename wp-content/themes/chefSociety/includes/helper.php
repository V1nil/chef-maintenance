<?php
/**
 * Helper class G5ThemeHelper containing useful theme functions and hooks
 */

// Extend Timber context
add_filter('timber_context', array('G5ThemeHelper', 'add_to_context'));

// Modify the default Admin Bar margins to render properly in the mobile mode
add_theme_support('admin-bar', array('callback' => array('G5ThemeHelper', 'admin_bar_margins')));

// Add comments pagination link attributes
add_filter('previous_comments_link_attributes', array('G5ThemeHelper', 'comments_pagination_attributes'));
add_filter('next_comments_link_attributes', array('G5ThemeHelper', 'comments_pagination_attributes'));

class G5ThemeHelper
{
    /**
     * Extend the Timber context
     *
     * @param array $context
     *
     * @return array
     */
    public static function add_to_context(array $context)
    {
        $context['is_user_logged_in'] = is_user_logged_in();
        $context['pagination']        = Timber::get_pagination();

        return $context;
    }

    /**
     * Single comment callback
     *
     * Using the callback so the walker can go through and give us nested comments
     *
     * @param type $comment
     * @param type $args
     * @param type $depth
     */
    public static function comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; ?>


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
                        //Foto
                        $user_comment = get_user_meta($comment->user_id);
                        $user_comment_photo = $user_comment['_chef_personal_photo'][0];
                        if($user_comment_photo != ''){
                                $photo_path = site_url(get_the_author_meta('_chef_personal_photo'));
                        }else{
                                $photo_path = site_url('/wp-content/uploads/users/user.jpg');
                        }
                        
                        //Nombre
                        $profile = site_url('mi-perfil/?perfil='.$comment->user_id);
                        if($user_comment['first_name'][0] != '' ){
                           $user_name = $user_comment['first_name'][0];
                        }else{
                           $user_name = $user_comment['nickname'][0];
                        }
                    ?>
                <div class="comment-avatar-chef"><a href="<?php echo $profile; ?>"><img class="autor-img-box-header" src="<?php echo $photo_path; ?>"></a></div>
                    <div class="comment-name-date">
                        <h4><a href="<?php echo $profile; ?>"><?php  echo $user_name;?></a></h4>
                        <p class="comment-date-chef"><em><?php echo 'Hace '.$amount.' '.$unit ;?></em></p>
                    </div>
            </div>
            <div class="comment-body-chef">
                <p><?php comment_text(); ?></p>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare ac sem ut posuere. Pellentesque eget eleifend quam. Suspendisse libero purus, malesuada at erat eget, sagittis viverra purus. Nam ut lacus commodo, congue massa at, elementum tellus. Nam fringilla, dolor elementum interdum placerat, lacus odio luctus nisi, sit amet interdum tellus tortor vitae velit. Donec imperdiet purus in</p>-->
            </div>
        </div>

<!--        <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <header class="comment-author">
                <div class="author-avatar">
                    <?php echo get_avatar($comment, $size = '48'); ?>
                </div>
                <div class="author-meta vcard">
                    <?php printf(__('<span class="author-name">%s</span>', 'g5_chefSociety'), get_comment_author_link()); ?>
                    <time datetime="<?php echo comment_date('c'); ?>">
                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                            <?php printf(__('%1$s', 'g5_chefSociety'), get_comment_date(), get_comment_time()); ?>
                        </a>
                    </time>
                    <?php edit_comment_link(__('(Edit)', 'g5_chefSociety'), '<span class="edit-link">', '</span>'); ?>
                </div>
            </header>

            <section class="comment-content">
                <?php if ($comment->comment_approved == '0') : ?>
                    <div class="notice">
                        <p class="alert-info"><?php _e('Your comment is awaiting moderation.', 'g5_chefSociety'); ?></p>
                    </div>
                <?php endif; ?>

                <?php comment_text(); ?>

                <?php comment_reply_link(array_merge($args,
                    array('add_below' => 'div-comment', 'before' => '<div class="comment-reply">', 'after' => '</div>', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </section>

        </article>-->
        <?php
    }

    // Add comments pagination link attributes
    public static function comments_pagination_attributes($attributes)
    {
        $attributes .= 'class="button"';
        return $attributes;
    }

    // Modify the default Admin Bar margins to render properly in the mobile mode
    public static function admin_bar_margins()
    { ?>
        <style type="text/css" media="screen">
            html {
                margin-top: 32px !important;
            }

            * html body {
                margin-top: 32px !important;
            }

            @media screen and ( max-width: 782px ) {
                html {
                    margin-top: 46px !important;
                }

                * html body {
                    margin-top: 46px !important;
                }

                #g-offcanvas {
                    margin-top: 46px !important;
                }
            }

            @media screen and ( max-width: 600px ) {
                html {
                    margin-top: 0 !important;
                }

                * html body {
                    margin-top: 0 !important;
                }

                #g-page-surround {
                    margin-top: 46px !important;
                }
            }
        </style>
        <?php
    }
}
