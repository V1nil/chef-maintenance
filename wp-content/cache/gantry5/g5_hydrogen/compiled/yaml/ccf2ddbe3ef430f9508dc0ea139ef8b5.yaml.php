<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/themes/g5_hydrogen/gantry/theme.yaml',
    'modified' => 1464365796,
    'data' => [
        'details' => [
            'name' => 'Hydrogen',
            'version' => '5.2.18',
            'icon' => 'paper-plane',
            'date' => 'May 27, 2016',
            'author' => [
                'name' => 'RocketTheme, LLC',
                'email' => 'support@rockettheme.com',
                'link' => 'http://www.rockettheme.com'
            ],
            'documentation' => [
                'link' => 'http://docs.gantry.org/gantry5'
            ],
            'support' => [
                'link' => 'https://gitter.im/gantry/gantry5'
            ],
            'updates' => [
                'link' => 'http://updates.rockettheme.com/themes/hydrogen.yaml'
            ],
            'copyright' => '(C) 2005 - 2016 RocketTheme, LLC. All rights reserved.',
            'license' => 'GPLv2',
            'description' => 'Hydrogen Theme',
            'images' => [
                'thumbnail' => 'admin/images/preset1.png',
                'preview' => 'admin/images/preset1.png'
            ]
        ],
        'configuration' => [
            'gantry' => [
                'platform' => 'wordpress',
                'engine' => 'nucleus'
            ],
            'theme' => [
                'parent' => 'hydrogen',
                'base' => 'gantry-theme://common',
                'file' => 'gantry-theme://includes/theme.php',
                'class' => '\\Gantry\\Framework\\Theme',
                'textdomain' => 'g5_hydrogen'
            ],
            'fonts' => [
                'roboto' => [
                    400 => 'gantry-theme://fonts/roboto_regular_macroman/Roboto-Regular-webfont',
                    500 => 'gantry-theme://fonts/roboto_medium_macroman/Roboto-Medium-webfont',
                    700 => 'gantry-theme://fonts/roboto_bold_macroman/Roboto-Bold-webfont'
                ]
            ],
            'css' => [
                'compiler' => '\\Gantry\\Component\\Stylesheet\\ScssCompiler',
                'paths' => [
                    0 => 'gantry-theme://scss',
                    1 => 'gantry-engine://scss'
                ],
                'files' => [
                    0 => 'hydrogen',
                    1 => 'hydrogen-wordpress',
                    2 => 'custom'
                ],
                'persistent' => [
                    0 => 'hydrogen'
                ],
                'overrides' => [
                    0 => 'hydrogen-wordpress',
                    1 => 'custom'
                ]
            ],
            'dependencies' => [
                'gantry' => '5.0.*',
                'engine/nucleus' => '1.0.*',
                'asset/font-awesome' => 4.2000000000000002,
                'particle/menu' => '1.0.*'
            ],
            'block-variations' => [
                'Box Variations' => [
                    'box1' => 'Box 1',
                    'box2' => 'Box 2',
                    'box3' => 'Box 3',
                    'box4' => 'Box 4'
                ],
                'Effects' => [
                    'shadow' => 'Shadow 1',
                    'shadow2' => 'Shadow 2',
                    'rounded' => 'Rounded',
                    'square' => 'Square'
                ],
                'Utility' => [
                    'disabled' => 'Disabled',
                    'align-right' => 'Align Right',
                    'align-left' => 'Align Left',
                    'center' => 'Center',
                    'full-width' => 'Full Width',
                    'equal-height' => 'Equal Height',
                    'nomarginall' => 'No Margin',
                    'nopaddingall' => 'No Padding'
                ]
            ]
        ],
        'chrome' => [
            'gantry' => [
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>'
            ]
        ],
        'admin' => [
            'styles' => [
                'section' => [
                    0 => 'header',
                    1 => 'showcase',
                    2 => 'subfeature'
                ],
                'core' => [
                    0 => 'base'
                ]
            ],
            'content' => [
                'general' => [
                    0 => 'wpautop'
                ],
                'blog' => [
                    0 => 'content',
                    1 => 'heading',
                    2 => 'featured-image',
                    3 => 'title',
                    4 => 'meta-date',
                    5 => 'meta-author',
                    6 => 'meta-comments',
                    7 => 'meta-categories',
                    8 => 'meta-tags',
                    9 => 'read-more'
                ],
                'single' => [
                    0 => 'featured-image',
                    1 => 'title',
                    2 => 'meta-date',
                    3 => 'meta-author',
                    4 => 'meta-comments',
                    5 => 'meta-categories',
                    6 => 'meta-tags'
                ],
                'page' => [
                    0 => 'featured-image',
                    1 => 'title',
                    2 => 'meta-date',
                    3 => 'meta-author'
                ],
                'archive' => [
                    0 => 'content',
                    1 => 'heading',
                    2 => 'featured-image',
                    3 => 'title',
                    4 => 'meta-date',
                    5 => 'meta-author',
                    6 => 'meta-comments',
                    7 => 'meta-categories',
                    8 => 'meta-tags',
                    9 => 'read-more'
                ]
            ]
        ]
    ]
];
