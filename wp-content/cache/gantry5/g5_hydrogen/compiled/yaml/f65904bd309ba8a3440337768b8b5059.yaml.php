<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web//wp-content/themes/g5_hydrogen/blueprints/content/blog/meta-categories.yaml',
    'modified' => 1464365796,
    'data' => [
        'name' => 'Categories Meta',
        'description' => 'Options for displaying categories meta',
        'type' => 'blog',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Display Categories',
                    'description' => 'Display categories that the post has been assigned to.',
                    'default' => 1
                ],
                'link' => [
                    'type' => 'input.checkbox',
                    'label' => 'Link Categories',
                    'description' => 'Link categories to their category page.',
                    'default' => 1
                ],
                'prefix' => [
                    'type' => 'input.text',
                    'label' => 'Categories Prefix',
                    'description' => 'Display text directly before the category name.',
                    'default' => 'Categories:'
                ]
            ]
        ]
    ]
];
