<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/themes/g5_hydrogen/custom/particles/slideshow.yaml',
    'modified' => 1465384931,
    'data' => [
        'name' => 'Slideshow',
        'description' => 'Display slideshow.',
        'type' => 'particle',
        'form' => [
            'fields' => [
                'enabled' => [
                    'type' => 'input.checkbox',
                    'label' => 'Enabled',
                    'description' => 'Globally enable slideshow particle.',
                    'default' => true
                ],
                '_note' => [
                    'type' => 'separator.note',
                    'class' => 'alert alert-info',
                    'content' => '<strong>This Particle requires the "UIkit for Gantry5" Atom to be loaded.</strong>'
                ],
                'height' => [
                    'type' => 'input.text',
                    'label' => 'Slideshow Height',
                    'description' => 'Set the slideshow height in pixels (do NOT type in \'px\', enter just the digits). Default is \'auto\'.',
                    'default' => 'auto'
                ],
                'autoplay' => [
                    'type' => 'select.select',
                    'label' => 'Autoplay',
                    'description' => 'Enable or disable the Slideshow autoplay.',
                    'placeholder' => 'Select...',
                    'default' => 'true',
                    'options' => [
                        'true' => 'Enabled',
                        'false' => 'Disabled'
                    ]
                ],
                'autoplayInterval' => [
                    'type' => 'input.text',
                    'label' => 'Autoplay Interval',
                    'description' => 'Set the timespan in miliseconds between switching slideshow items.',
                    'default' => 7000
                ],
                'navigation' => [
                    'type' => 'select.select',
                    'label' => 'Navigation',
                    'description' => 'Select the Slideshow navigation.',
                    'placeholder' => 'Select...',
                    'default' => 'arrows',
                    'options' => [
                        'arrows' => 'Arrows',
                        'dots' => 'Dots',
                        'both' => 'Both',
                        'none' => 'None'
                    ]
                ],
                'animation' => [
                    'type' => 'select.select',
                    'label' => 'Animation',
                    'description' => 'Select the Slideshow animation.',
                    'placeholder' => 'Select...',
                    'default' => 'fade',
                    'options' => [
                        'fade' => 'Fade',
                        'scroll' => 'Scroll',
                        'scale' => 'Scale',
                        'swipe' => 'Swipe',
                        'slice-down' => 'Slice-down',
                        'slice-up' => 'Slice-up',
                        'slice-up-down' => 'Slice-up-down',
                        'fold' => 'Fold',
                        'puzzle' => 'Puzzle',
                        'boxes' => 'Boxes',
                        'boxes-reverse' => 'Boxed-reverse',
                        'random-fx' => 'Random'
                    ]
                ],
                'animationDuration' => [
                    'type' => 'input.text',
                    'label' => 'Animation Duration',
                    'description' => 'Set the animation duration in miliseconds.',
                    'default' => 500
                ],
                'kenburns' => [
                    'type' => 'select.select',
                    'label' => 'Ken Burns Effect',
                    'description' => 'Enable or disable the Ken Burns effect.',
                    'placeholder' => 'Select...',
                    'default' => 'false',
                    'options' => [
                        'true' => 'Enabled',
                        'false' => 'Disabled'
                    ]
                ],
                'pauseOnHover' => [
                    'type' => 'select.select',
                    'label' => 'Pause on Hover',
                    'description' => 'Pause autoplay when hovering the slideshow.',
                    'placeholder' => 'Select...',
                    'default' => 'true',
                    'options' => [
                        'true' => 'Enabled',
                        'false' => 'Disabled'
                    ]
                ],
                'fullscreen' => [
                    'type' => 'input.checkbox',
                    'label' => 'Fullscreen',
                    'description' => 'Make the Slideshow fullscreen that stretches to fill the entire viewport.',
                    'default' => 0
                ],
                'css.class' => [
                    'type' => 'input.selectize',
                    'label' => 'CSS Classes',
                    'description' => 'CSS class name for the particle.',
                    'default' => NULL
                ],
                'extra' => [
                    'type' => 'collection.keyvalue',
                    'label' => 'Tag Attributes',
                    'description' => 'Extra Tag attributes.',
                    'key_placeholder' => 'Key (data-*, style, ...)',
                    'value_placeholder' => 'Value',
                    'exclude' => [
                        0 => 'id',
                        1 => 'class'
                    ]
                ],
                'items' => [
                    'type' => 'collection.list',
                    'array' => true,
                    'label' => 'Slideshow Items',
                    'description' => 'Create each slideshow item to display.',
                    'value' => 'name',
                    'ajax' => true,
                    'fields' => [
                        '.image' => [
                            'type' => 'input.imagepicker',
                            'label' => 'Image',
                            'description' => 'Select an image for the slide.'
                        ],
                        '.videoiframe' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Video',
                            'description' => 'Paste the whole embed video iframe code (including the iframe tags) and modify it as needed.'
                        ],
                        '.alt' => [
                            'type' => 'input.text',
                            'label' => 'Image Alt Tag'
                        ],
                        '.title' => [
                            'type' => 'input.text',
                            'label' => 'Title'
                        ],
                        '.link' => [
                            'type' => 'input.text',
                            'label' => 'Title Link'
                        ],
                        '.target' => [
                            'type' => 'select.select',
                            'label' => 'Target',
                            'description' => 'Target browser window when item is clicked.',
                            'placeholder' => 'Select...',
                            'default' => '_parent',
                            'options' => [
                                '_parent' => 'Self',
                                '_blank' => 'New Window'
                            ]
                        ],
                        '.description' => [
                            'type' => 'textarea.textarea',
                            'label' => 'Description'
                        ],
                        '.overlaystyle' => [
                            'type' => 'select.select',
                            'label' => 'Overlay Style',
                            'description' => 'Select the overlay style (Title and Description).',
                            'placeholder' => 'Select...',
                            'default' => 'style1',
                            'options' => [
                                'style1' => 'Style 1',
                                'style2' => 'Style 2'
                            ]
                        ],
                        '.overlayposition' => [
                            'type' => 'select.select',
                            'label' => 'Overlay Position',
                            'description' => 'Select the overlay position (Title and Description).',
                            'placeholder' => 'Select...',
                            'default' => 'bottom',
                            'options' => [
                                'bottom' => 'Bottom',
                                'left' => 'Left',
                                'right' => 'Right',
                                'top' => 'Top',
                                'bottom-left' => 'Bottom Left',
                                'bottom-center' => 'Bottom Center',
                                'bottom-right' => 'Bottom Right',
                                'middle-left' => 'Middle Left',
                                'middle-center' => 'Middle Center',
                                'middle-right' => 'Middle Right',
                                'top-left' => 'Top Left',
                                'top-center' => 'Top Center',
                                'top-right' => 'Top Right'
                            ]
                        ],
                        '.overlayanimation' => [
                            'type' => 'select.select',
                            'label' => 'Overlay Animation',
                            'description' => 'Select the overlay animation.',
                            'placeholder' => 'Select...',
                            'default' => 'fade',
                            'options' => [
                                'fade' => 'Fade',
                                'slide-left' => 'Slide Left',
                                'slide-left-short' => 'Slide Left (Short)',
                                'slide-right' => 'Slide Right',
                                'slide-right-short' => 'Slide Right (Short)',
                                'slide-top' => 'Slide Top',
                                'slide-top-short' => 'Slide Top (Short)',
                                'slide-bottom' => 'Slide Bottom',
                                'slide-bottom-short' => 'Slide Bottom (Short)',
                                'scale' => 'Scale'
                            ]
                        ],
                        '.overlaywidth' => [
                            'type' => 'select.select',
                            'label' => 'Overlay Width',
                            'description' => 'Select the overlay width.',
                            'placeholder' => 'Select...',
                            'default' => 'auto',
                            'options' => [
                                'auto' => 'Auto',
                                1 => '100%',
                                2 => '50%',
                                3 => '33.3%',
                                4 => '25%',
                                5 => '20%',
                                6 => '16.6%'
                            ]
                        ],
                        '.class' => [
                            'type' => 'input.selectize',
                            'label' => 'CSS Class'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
