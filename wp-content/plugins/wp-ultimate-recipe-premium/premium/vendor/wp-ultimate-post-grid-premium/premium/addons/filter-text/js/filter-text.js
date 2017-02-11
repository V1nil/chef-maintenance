WPUltimatePostGrid = WPUltimatePostGrid || {};
WPUltimatePostGrid.ajaxUpdateTimer = null;

WPUltimatePostGrid.initFilterText = function(container) {
    var grid_id = container.data('grid');
    var input = container.find('.wpupg-filter-text-input');
    var grid = WPUltimatePostGrid.grids[grid_id];

    if(input.val() !== '') {
        WPUltimatePostGrid.ajaxFilterText(grid, input);
    }

    input.on('keyup change', function() {
        clearTimeout(WPUltimatePostGrid.ajaxUpdateTimer);
        var search = input.val();
        
        if(search != grid.filter_text_search) {
            WPUltimatePostGrid.ajaxUpdateTimer = setTimeout(function() {
                if(search == '') {
                    grid.filter_text = false;
                    grid.filter_text_search = '';
                    grid.filter_text_posts = [];
                    WPUltimatePostGrid.filterGrid(grid_id);
                } else {
                    WPUltimatePostGrid.ajaxFilterText(grid, container, search);
                }
            }, 500);
        }
    });
};

WPUltimatePostGrid.updateFilterText = function(container, taxonomy, search) {
    var input = container.find('.wpupg-filter-text-input');
    input.val(search).change();
};

WPUltimatePostGrid.ajaxFilterText = function(grid, container, search) {
    var data = {
        action: 'wpupg_filter_text',
        security: wpupg_public.nonce,
        grid: container.data('grid'),
        search: search
    };

    jQuery.post(wpupg_public.ajax_url, data, function(html) {
        var posts = jQuery(html).toArray();
        
        var posts_to_add = [];
        var posts_to_filter = [];

        for(var i=0; i < posts.length; i++) {
            var post_id = jQuery(posts[i]).data('id');

            if(post_id !== undefined) {
                if(jQuery.inArray(post_id, grid.posts) == -1) {
                    posts_to_add.push(posts[i]);
                }
                posts_to_filter.push(post_id);
            }
        }

        WPUltimatePostGrid.insertPosts(container.data('grid'), posts_to_add);
        grid.filter_text = true;
        grid.filter_text_search = search;
        grid.filter_text_posts = posts_to_filter;
        WPUltimatePostGrid.filterGrid(container.data('grid'));
    });
};