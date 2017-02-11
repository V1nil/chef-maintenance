<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/plugins/gantry5/engines/nucleus/particles/mobile-menu.yaml',
    'modified' => 1465381214,
    'data' => [
        'name' => 'Mobile Menu',
        'description' => 'Renders the mobile menu container for the offcanvas section.',
        'type' => 'particle',
        'icon' => 'fa-ellipsis-v',
        'hidden' => false,
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Globally enable spacer.',
                    'default' => true
                ],
                '_note' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => '<p>This Particle is the container target where, on Mobile, the Menu will be injected.</p><p>Please note that this Particle <strong>must</strong> be unique in the Layout and positioned in the Offcanvas section. You will also need a Menu present in the Layout.</p>'
                ]
            ]
        ]
    ]
];
