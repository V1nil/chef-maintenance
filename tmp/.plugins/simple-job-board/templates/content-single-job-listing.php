<section class="sjb-wrap single-job-listing">

    <?php
    /**
     * single_job_listing_start hook
     *
     * @hooked job_listing_meta_display - 20
     * 
     * @since 2.1.0
     */
    do_action('sjb_single_job_listing_start');
    ?>

    <article class="sjb-row sjb-job-details" id="sjb_job-detail-heading">
        <p id="sjb_line">
            <?php echo apply_filters('sjb_the_job_description', get_the_content()); ?>
        </p>

        <?php
        /**
         * single-job-listing-end hook
         * @hooked job_listing_features - 20
         * @hooked job_listing_application_form - 30
         * 
         * @since 2.1.0
         */
        do_action('sjb_single_job_listing_end');
        ?>
    </article>
</section>