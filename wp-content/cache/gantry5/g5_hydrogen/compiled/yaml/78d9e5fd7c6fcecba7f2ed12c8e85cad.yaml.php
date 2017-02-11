<?php
return [
    '@class' => 'Gantry\\Component\\File\\CompiledYamlFile',
    'filename' => '/var/www/clients/client1/web2/web/wp-content/themes/g5_hydrogen/custom/config/home/layout.yaml',
    'modified' => 1465398497,
    'data' => [
        'version' => 2,
        'preset' => [
            'image' => 'gantry-admin://images/layouts/home.png',
            'name' => 'home',
            'timestamp' => 1464365796
        ],
        'layout' => [
            '/header/' => [
                
            ],
            '/navigation/' => [
                0 => [
                    0 => 'logo-4787 20',
                    1 => 'menu-6328 50',
                    2 => 'custom-7486 25',
                    3 => 'spacer-7827 5'
                ]
            ],
            '/showcase/' => [
                0 => [
                    0 => 'slideshow-1416'
                ]
            ],
            '/feature/' => [
                0 => [
                    0 => 'custom-6713'
                ],
                1 => [
                    0 => 'contentarray-8752'
                ]
            ],
            '/main/' => [
                0 => [
                    0 => 'custom-5245'
                ]
            ],
            '/subfeature/' => [
                0 => [
                    0 => 'sample-3'
                ]
            ],
            '/footer/' => [
                0 => [
                    0 => 'custom-8263 25',
                    1 => 'custom-9934 25',
                    2 => 'custom-6364 25',
                    3 => 'custom-3189 25'
                ],
                1 => [
                    0 => 'spacer-spacer-8710 45',
                    1 => 'totop-7446 10',
                    2 => 'spacer-spacer-6049 45'
                ],
                2 => [
                    0 => 'position-footer'
                ],
                3 => [
                    0 => 'copyright-1704 40',
                    1 => 'logo-3894 35',
                    2 => 'social-5363 25'
                ],
                4 => [
                    0 => 'branding-6631'
                ]
            ],
            'offcanvas' => [
                0 => [
                    0 => 'mobile-menu-7167'
                ]
            ]
        ],
        'structure' => [
            'header' => [
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'navigation' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'showcase' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => '2',
                    'class' => ''
                ]
            ],
            'feature' => [
                'type' => 'section',
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'main' => [
                'attributes' => [
                    'boxed' => ''
                ]
            ],
            'subfeature' => [
                'type' => 'section',
                'attributes' => [
                    'class' => 'flush',
                    'boxed' => ''
                ]
            ],
            'footer' => [
                'attributes' => [
                    'boxed' => ''
                ]
            ]
        ],
        'content' => [
            'logo-4787' => [
                'title' => 'Logo / Image',
                'attributes' => [
                    'image' => 'gantry-media://chefsociety1.png',
                    'class' => ''
                ]
            ],
            'menu-6328' => [
                'attributes' => [
                    'menu' => 'menu-main'
                ],
                'block' => [
                    'extra' => [
                        0 => [
                            'style' => 'padding-top:1em'
                        ]
                    ]
                ]
            ],
            'custom-7486' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<form>
       <input type="text" class="search-input-top" placeholder="Search">

        <button type="submit" class="search-btn-top"><i class="fa fa-search fa-lg" aria-hidden="true"></i>
</button>
      </form>'
                ]
            ],
            'slideshow-1416' => [
                'attributes' => [
                    'height' => '400',
                    'items' => [
                        0 => [
                            'image' => 'gantry-media://slide.jpg',
                            'videoiframe' => '',
                            'alt' => '',
                            'title' => '',
                            'link' => '',
                            'target' => '_parent',
                            'description' => '',
                            'overlaystyle' => 'style1',
                            'overlayposition' => 'bottom',
                            'overlayanimation' => 'fade',
                            'overlaywidth' => 'auto',
                            'class' => '',
                            'name' => 'Slide 1'
                        ],
                        1 => [
                            'image' => 'gantry-media://slide-2.jpg',
                            'videoiframe' => '',
                            'alt' => '',
                            'title' => '',
                            'link' => '',
                            'target' => '_parent',
                            'description' => '',
                            'overlaystyle' => 'style1',
                            'overlayposition' => 'bottom',
                            'overlayanimation' => 'fade',
                            'overlaywidth' => 'auto',
                            'class' => '',
                            'name' => 'Slide 2'
                        ],
                        2 => [
                            'image' => 'gantry-media://slide-3.jpg',
                            'videoiframe' => '',
                            'alt' => '',
                            'title' => '',
                            'link' => '',
                            'target' => '_parent',
                            'description' => '',
                            'overlaystyle' => 'style1',
                            'overlayposition' => 'bottom',
                            'overlayanimation' => 'fade',
                            'overlaywidth' => 'auto',
                            'class' => '',
                            'name' => 'Slide 3'
                        ]
                    ]
                ]
            ],
            'custom-6713' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<h2>Qué se cuece</h2>
<strong>A global community of creative chefs and foodie</strong>'
                ]
            ],
            'contentarray-8752' => [
                'title' => 'WordPress Posts',
                'attributes' => [
                    'post' => [
                        'filter' => [
                            'categories' => '33'
                        ],
                        'limit' => [
                            'total' => '4',
                            'columns' => '4'
                        ],
                        'display' => [
                            'text' => [
                                'limit' => '200'
                            ],
                            'read_more' => [
                                'label' => 'Leer mas...'
                            ]
                        ]
                    ]
                ]
            ],
            'custom-5245' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<h2>Call to action</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
'
                ]
            ],
            'sample-3' => [
                'title' => 'Key Features',
                'attributes' => [
                    'headline' => 'Comunidad de Chefs',
                    'description' => '<p>ChefSociety - A global community of creative chefs and foodie</p>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ornare ac sem ut posuere.</p>',
                    'samples' => [
                        0 => [
                            'icon' => 'fa fa-users',
                            'subtitle' => '',
                            'description' => '<p>Una comunidad de chefs donde compartir ideas y mostrar creaciones</p>',
                            'id' => '',
                            'class' => '',
                            'variations' => '',
                            'title' => 'Chefs como tu'
                        ],
                        1 => [
                            'icon' => 'fa fa-newspaper-o',
                            'subtitle' => '',
                            'description' => '<p>Las ultimas noticias del mundo de la cocina</p>',
                            'id' => '',
                            'class' => '',
                            'variations' => '',
                            'title' => 'Noticias'
                        ],
                        2 => [
                            'icon' => 'fa fa-cubes',
                            'subtitle' => '',
                            'description' => '<p>Crea, publica y date a conocer</p>',
                            'id' => '',
                            'class' => '',
                            'variations' => '',
                            'title' => 'Conocimiento'
                        ]
                    ]
                ]
            ],
            'custom-8263' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<h4>Secciones</h4>
<p><a href="/que-se-cuece.php">Qué se cuece</a></p>
<p><a href="/talleres-culinarios.php">Talleres culinarios</a</p>
<p><a href="/recetas.php">Recetas</a</p>'
                ]
            ],
            'custom-9934' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<h4>&nbsp;</h4>
<p><a href="/promociones.php">Promociones</a></p>
<p><a href="/eventos.php">Eventos</a></p>
<p><a href="/empleo.php">Empleo</a></p>'
                ]
            ],
            'custom-6364' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<h4>Informacion</h4>
<p><a href="/aviso-legal.php">Aviso legal</a></p>
<p><a href="/contacto.php">Contacto</a></p>
<p><a href="/recetas.php">Condiciones de uso</a></p>
'
                ]
            ],
            'custom-3189' => [
                'title' => 'Custom HTML',
                'attributes' => [
                    'html' => '<div class="col-md-5">
                <h4>Suscríbete a nuestra newsletter</h4>
                <p>Recibe promociones, noticias, ...</p>
                	<form enctype="application/x-www-form-urlencoded" action="http://chefsociety.ip-zone.com/ccm/subscribe/index/form/ixdcgqi7u7" method="post">
						<dl class="zend_form">
 							<dt id="groups-label"> </dt>
 							<dd id="groups-element">
 								<input name="groups[]" value="2" type="hidden">
                            </dd>
 								<!--<dt id="email-label">
 									<label for="email" class="required">Email</label>
 								</dt>-->
                                <div class="row">
                                	<div class="col-md-8">
 										<dd id="email-element">
 											<input class="form-control" name="email" id="email" value="" placeholder="Email" type="text" required="">
                            			</dd>
                                     </div>
                                     <div class="col-md-4">
 										<dt id="submit-label"> </dt>
 										<dd id="submit-element">
 											<input class="btn btn-primary" name="submit" id="submit" value="Suscribirme" type="submit">
                                        </dd>
                                      </div>
                                  </div>
						</dl>
					</form>
                    
                </div>'
                ]
            ],
            'totop-7446' => [
                'title' => 'To Top',
                'attributes' => [
                    'icon' => 'fa fa-angle-double-up fa-3x'
                ]
            ],
            'position-footer' => [
                'attributes' => [
                    'key' => 'footer'
                ]
            ],
            'logo-3894' => [
                'title' => 'Logo / Image',
                'attributes' => [
                    'image' => 'gantry-media://chefsociety.png'
                ]
            ],
            'social-5363' => [
                'attributes' => [
                    'css' => [
                        'class' => 'social-items'
                    ],
                    'items' => [
                        0 => [
                            'icon' => 'fa fa-twitter',
                            'text' => '',
                            'link' => 'http://twitter.com/rockettheme',
                            'name' => 'Twitter'
                        ],
                        1 => [
                            'icon' => 'fa fa-facebook',
                            'text' => '',
                            'link' => 'http://facebook.com/rockettheme',
                            'name' => 'Facebook'
                        ],
                        2 => [
                            'icon' => 'fa fa-google',
                            'text' => '',
                            'link' => 'http://plus.google.com/+rockettheme',
                            'name' => 'Google'
                        ],
                        3 => [
                            'icon' => 'fa fa-rss',
                            'text' => '',
                            'link' => 'http://www.rockettheme.com/product-updates?rss',
                            'name' => 'RSS'
                        ]
                    ]
                ],
                'block' => [
                    'variations' => 'center'
                ]
            ],
            'mobile-menu-7167' => [
                'title' => 'Mobile Menu'
            ]
        ]
    ]
];
