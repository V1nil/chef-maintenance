<?php
/**
 * Single view Job Meta Box
 *
 * Hooked into single_job_listing_start priority 20
 *
 * @since  2.1.0
 */
global $post;

do_action('single_job_listing_meta_before');
?>
<?php do_action('single_job_listing_meta_start'); ?> 
<article class="sjb-row">
    <header class="sjb-col-md-6">
        <div class="sjb-row">
            <div class="sjb-company-logo">
                <?php
                if ($website = sjb_get_the_company_website()):
                    ?>
                    <a class="website" href="<?php echo esc_url($website); ?>"  target="_blank" rel="nofollow"><?php sjb_the_company_logo(); ?></a>
                    <?php
                else:
                    sjb_the_company_logo();
                endif;
                ?>
            </div>
            <div id="sjb-heading">
                <h4 id="sjb_job-heading">
                    <?php
                    the_title();
                    if (sjb_get_the_company_name()) {
                        if ($website = sjb_get_the_company_website()):
                            ?>
                            |  <a class="website" href="<?php echo esc_url($website); ?>" target="_blank" rel="nofollow"><?php sjb_the_company_name(); ?></a>
                            <?php
                        else:
                            echo ' | ';
                            sjb_the_company_name();
                        endif;
                    }
                    ?>
                </h4>
            </div>
        </div>
    </header>

    <div class="sjb-col-md-2">
        <?php if ($job_type = sjb_get_the_job_type()) {
            ?>
            <div id="sjb_job-bolits">
                <i class="fa fa-clock-o"></i><?php sjb_the_job_type(); ?>
            </div>
        <?php } ?> 
    </div>
    <div class="sjb-col-md-2">
        <?php if ($job_location = sjb_get_the_job_location()) {
            ?>
            <div id="sjb_job-bolits">
                <i class="fa fa-location-arrow"></i><?php sjb_the_job_location(); ?>
            </div>
        <?php } ?> 
    </div>
    <div class="sjb-col-md-2">
        <?php if ($job_posting_time = sjb_get_the_job_posting_time()) {
            ?>
            <div id="sjb_job-bolits">
                <i class="fa fa-calendar"></i><?php sjb_the_job_posting_time(); ?>
            </div>
        <?php } ?> 
    </div>
</article>
<?php do_action('single_job_listing_meta_end'); ?>


<?php if (sjb_get_the_company_tagline()): ?>
    <div class="sjb-row">
        <p class="sjb-company-tagline"><?php sjb_the_company_tagline(); ?></p>
    </div>
<?php endif; ?>

<?php
do_action('single_job_listing_meta_after');
