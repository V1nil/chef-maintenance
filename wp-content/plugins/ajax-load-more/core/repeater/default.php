<?php 
//Array con los tipos de alergenos
$alergenos_array = array('Celiaco','Cereal','Marisco','Huevo','Pescado','Lupino','Leche','Molusco','Mostaza','Frutos secos','Cacahuete','Sesamo','Soja','Sulfitos');
//Array con los tipos de platos
$platos_array = array('Primer Plato','Segundo Plato','Entrante','Postre','Bebida');
global $product;

//Comprobamos si es o no un producto y de que tipo
$post_ID = get_the_ID();
$post_type = get_post_type($post_ID);
$product_type = get_the_terms($post_ID, 'product_cat');
$promocion = $taller = false;
if($product_type[0]->slug == 'promocion'){
	$promocion = true;
};
if($product_type[0]->slug == 'taller'){
	$taller = true;
};

//Recuperamos sus metas y otra información de interés y que puede ser común a toda la template
$meta = get_post_meta( $post_ID );

$excerpt = get_the_excerpt();

$author = get_the_author_meta('ID');
$perfil = site_url('mi-perfil/?perfil='.$author);
$photo = get_the_author_meta('_chef_personal_photo');
$businame = get_the_author_meta('_chef_busi_name');
if($photo != ''){
    $author_photo = site_url(get_the_author_meta('_chef_personal_photo'));
}else{
    $author_photo = site_url('/wp-content/uploads/users/user.jpg');
}
?>

<?php 

//Seccion para mostrar SOLO los post de Ayuda, por el else se va al resto de post
$categories = wp_get_post_categories($post_ID);
$ayuda_content = get_the_content();
$ayuda_title = get_the_title();
if($post_type == 'post' && in_array('91',$categories)){ 
?>
    <div style="display:flex">
        <div style="width: 10%">
            <i class="fa fa-file-text fa-2x" aria-hidden="true"></i>
        </div>
        <div style="width: 90%">
            <h3 class="m-t-0 c-r"><?php echo $ayuda_title; ?></h3>
            <p><?php echo $ayuda_content; ?></p>
            <p class="small"><em><?php the_time("d/m/Y"); ?></em></p>
        </div>
    </div>
        
<?php 
}else{ 
?>

    <div class="std-box-load-more">
        <?php 
        if ( has_tag('Nuevo') || $meta['_featured'][0] == 'yes') {
            echo '<div class="new">Nuevo</div>';
        }  
        ?>

        <a href="<?php the_permalink(); ?>">
            <div class="img-box" style="background-image:url('<?php if(has_post_thumbnail()){ the_post_thumbnail_url();}?>');"></div>
        </a>
        <div>
            <a href="<?php echo $perfil?>"><img class="autor-img-box" src="<?php echo $author_photo ?>"></a>
        </div>

        <?php 
        //Alturas de la caja del contenido contenido dependiendo de qué se esté mostrando
        //Los productos y promos necesitan de más altura
        if($promocion == true || $taller == true || $post_type == 'empleo'){
        ?>
            <div class="content-box-products">
        <?php 
        }else{ 
        ?>
            <div class="content-box">
        <?php 
        }
        ?>
                <h3>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        //Delimitamos a 7 palabras el titulo del post
                        $array_title=explode(' ', get_the_title($post_ID));
                        echo implode(' ', array_slice($array_title, 0, 7));
                        if(count($array_title) > 7){
                            echo '...';
                        }
                        ?>
                    </a>
                </h3>
                <?php
                //Noticias
                //Si es una noticia o un empleo, mostramos el resumen (delimitado a 15 palabras)
                if($promocion == false && $taller == false && ($post_type == 'post' || $post_type == 'empleo')){
                ?>
                    <p> <?php echo implode(' ', array_slice(explode(' ', $excerpt), 0, 15)).'...' ?> </p>
                <?php 
                } 
                ?>
                <?php 
                if($post_type == 'recipe' || $post_type == 'post' ){
                    $author_first = get_the_author_meta('first_name');
                    $author_last = get_the_author_meta('last_name');
                    if($post_type == 'recipe') {
                        echo '<p class="small receta-author">Una receta de:<br><strong>'.$author_first.' '.$author_last.'</strong></p>';
                        echo '<p class="restaurante-author"><strong>'.$businame.'</strong></p>';
                    };
                    if($post_type == 'post') {
                        echo '<p class="small receta-author">Una noticia de:<br><strong>'.$author_first.' '.$author_last.'</strong></p>';
                    };
                }
                ?>

                <?php 
                //Talleres
                if($taller == true){
                    $promo_regular_price =$meta['_regular_price'][0];
                    $partner_price = round($promo_regular_price-(($meta['_descuento_socios'][0]/100)*$promo_regular_price));
                    echo '<p class="small">Un taller de:<br><strong>'.$businame.'</strong></p>';
                    echo '<p class="small">Patrocinado por <b>'.$meta['_patrocinador_nombre'][0].'</b></p>';

                    echo '<div class="price">
                            <hr class="m-b-0">';
                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                    sprintf( '<div class="gap-10"></div>'
                            . '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="btn btn-primary w-100 %s product_type_%s">'
                                . '<i class="fa fa-shopping-cart" aria-hidden="true"></i> %s'
                            . '</a>'
                            . '<div class="gap-10"></div>',
                            esc_url( $product->add_to_cart_url() ),
                            esc_attr( $product->id ),
                            esc_attr( $product->get_sku() ),
                            $product->is_purchasable() ? 'add_to_cart_button' : '',  
                            esc_attr( $product->product_type ),
                            esc_html( $product->add_to_cart_text().' ' .$meta['_regular_price'][0].'€' )
                            ),
                            $product );
                            echo '<!--
                                <button class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Comprar '.$meta['_regular_price'][0].'€  </button>-->
                                <div>
                                    <span class="partner">'.$partner_price.'€ socios ('.$meta['_descuento_socios'][0].'% desc)</span>
                                </div>
                                </div>
                                <!--<p class="small patrocinado">Código descuento:<br>
                                    <span class="codigo">'.$meta['_codigo_descuento'][0].'</span>
                                </p>-->';
                } 
                ?>

                <?php 
                //Promos
                if($promocion == true){
                    $promo_sale_price = $meta['_sale_price'][0];
                    $promo_regular_price =$meta['_regular_price'][0];
                    $partner_price = round($promo_regular_price-(($meta['_descuento_socios'][0]/100)*$promo_regular_price));
                    $discount = round(100-(($promo_sale_price*100)/$promo_regular_price));
                    $from_date = date("d/m/Y",$meta['_sale_price_dates_from'][0]);
                    $to_date = date("d/m/Y",$meta['_sale_price_dates_to'][0]);
                    echo '<p class="small">Una promoción de:<br> <b>'.$businame.'</b></p>';
                    echo '<p class="small">Patrocinado por <b>'.$meta['_patrocinador_promo_nombre'][0].'</b></p>';
                    $linkpromo = get_permalink();
                    echo'<div class="price">
                            <hr class="m-b-0">
                            <div class="gap-10"></div>      	
                            <a href="'.$linkpromo.'" class="btn btn-primary"> <!--<i class="fa fa-shopping-cart" aria-hidden="true"></i>-->Leer más</a>
                            <div class="gap-10"></div>
                        <div>
                        <!--<span class="partner">'.$partner_price.'€ socios ('.$meta['_descuento_socios'][0].'% desc)</span>-->
                        </div>
                        </div><!--<p class="small patrocinado">Código descuento:<br><span class="codigo">'.$meta['_codigo_descuento'][0].'</span></p>-->'; 
                     
                }
                ?>

                <?php 
                //Recetas
                if($post_type == 'recipe'){
                    $recipe_terms = unserialize($meta['recipe_terms'][0]);
                    $precioracion = $meta['recipe_precio_racion'][0];
                    echo '<hr class="m-b-0">';
                    echo '<div class="">';	
                    //Platos
                    $platos_dir = site_url('/wp-content/themes/chefSociety/images/platos/');
                    foreach ($recipe_terms['course'] as $plato_id){
                        if($plato_id != 0){
                            $plato = get_term($plato_id);
                            if(in_array($plato->name,$platos_array) == true){
                                echo '<img src="'.$platos_dir.$plato->slug.'.png" title="'.$plato->name.'" class="plato" />';                    
                            }
                        }            	
                    }
                    echo '</div>';
                    //Alergenos
                    $alergenos_dir = site_url('/wp-content/themes/chefSociety/images/alergenos/');
                    foreach ($recipe_terms['post_tag'] as $alergeno_id){
                        if($alergeno_id != 0){            	
                            $alergeno = get_term($alergeno_id);
                            if(in_array($alergeno->name,$alergenos_array) == true){
                                    /*echo '<img src="'.$alergenos_dir.$alergeno->slug.'.png" title="'.$alergeno->name.'" class="alergenos"/>'; */               
                            }
                        }
                    }
                    echo '<div class="precio">
                            <span class="precio-receta precio-plato"></span> '.$precioracion.' € 
                        </div>
                        <div class="gap-10"></div>';
                }
                ?>

                <?php 
                //Empleos
                if($post_type == 'empleo'){
                    echo '<p class="small ciudad">'.$meta['acf-fecha-inicio-convocatoria'][0].' - '.$meta['acf-fecha_fin_convocatoria'][0].'</p>'
                    . '<p class="prof">'.$meta['acf-field-puesto'][0].'</p>
                          <p class="small ciudad">'.$meta['acf-ciudad'][0].', España</p>';
                }
                ?>
                
            </div>
            <!-- Permalink -->
            <div class="text-center">
                <a class="read-more" href="<?php the_permalink(); ?>">
                    <i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i>
                </a>
                <div class="gap-20"></div>    
            </div>
            

            <!--Botom box-->
            <div class="bottom-box">
                <p>
            
            <?php 
            //Dependiendo de que tipo de post sea se muestran unas u otras opciones
            if($promocion == true || $taller == true || $post_type == 'recipe'){
            ?>
                <i class="fa fa-eye" aria-hidden="true"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
                <?php
                //Valoracion media (en caso de ser promocion o taller)
                if($promocion == true || $taller == true){
                    GLOBAL $product;
                    $rating = $product->get_average_rating();
                    $rating_100 = ($rating / 5 ) *100;
                ?>
                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <?php echo $rating_100; ?>% (<?php comments_number(' 0',' 1','%') ?>)
                <?php
                }        
                ?>
                <?php 
                //Seguidores
                $users = get_users();
                $cont_followers = 0;
                foreach($users as $user){           
                    $user_data = get_user_meta($user->data->ID);
                    $following = json_decode($user_data[_chef_follow][0]);

                    if(in_array($author,$following)){
                        $cont_followers++;
                    }
                }
                ?>
                <i class="fa fa-heart" aria-hidden="true"></i><?php echo $cont_followers; ?>
            <?php 
            } 
            ?>
            
            <?php
            //Si es un empleo
            if($post_type == 'empleo'){
            ?>
                <i class="fa fa-eye" aria-hidden="true"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
            <?php
            }
            ?>
            
            <?php
            //Si es una noticia
            if($promocion == false && $taller == false && $post_type == 'post'){
            ?>
                <i class="fa fa-comment-o fa-lg" aria-hidden="true"></i><?php comments_number(' 0',' 1','%') ?>
            <?php
            } 
            ?>
                </p>
            </div>
        </div>
<?php 
}
?>