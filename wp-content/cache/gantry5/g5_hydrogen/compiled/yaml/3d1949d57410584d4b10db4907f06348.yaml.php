<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/themes/g5_hydrogen/blueprints/content/single/meta-tags.yaml',
    'modified' => 1464365796,
    'data' => [
        'name' => 'Tags Meta',
        'description' => 'Options for displaying tags meta',
        'type' => 'single',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Display Tags',
                    'description' => 'Display post tags.',
                    'default' => 0
                ],
                'link' => [
                    'type' => 'input.checkbox',
                    'label' => 'Link Tags',
                    'description' => 'Link tags to their tag page.',
                    'default' => 1
                ],
                'prefix' => [
                    'type' => 'input.text',
                    'label' => 'Tags Prefix',
                    'description' => 'Display text directly before the tags list.',
                    'default' => 'Tags:'
                ]
            ]
        ]
    ]
];
