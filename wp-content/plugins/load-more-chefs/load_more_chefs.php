<?php

/**
 * Archivo para llamadas AJAX y cargar más desde un offset determinado
 */

function get_chefs_offset($offset,$atts){

    
    
    $args = array (
                    'number' =>'4',
                    'offset' => $offset
                    );
    
    //Añadimos los argumentos necesarios en funcion del shortcode
    $filter=$atts['filter'];
    
    switch($filter){
        case 'featured':
            $args['meta_key'] = 'wpfui2i_featured_user';
            break;
        case 'most-viewed':
            $args['meta_key'] = '_chef_visits';
            $args['orderby']  = 'meta_value_num';
            $args['order'] = 'desc';            
            break;
        case 'more-valued':
            
            break;
        case 'city':
            $args['meta_key'] = '_chef_city';
            $args['meta_value'] = $atts['city'];
            break;
        default:
            break;
    }
    
    $user_query = new WP_User_Query( $args );

    if ( ! empty( $user_query->results ) ) {
    
        $response = "<div class='g-grid grid-chefs loadmore-chefs-grid'>";
        
        foreach ( $user_query->results as $user ) 
        { 
            
            $user_info = get_userdata($user->ID);
            $user_meta_info = get_user_meta($user->ID);

            if($user_meta_info["_chef_personal_photo"][0] != '') $personal_photo_chef= site_url($user_meta_info["_chef_personal_photo"][0]); else $personal_photo_chef ='/wp-content/uploads/users/user.jpg';
            if($user_meta_info["_chef_business_photo"][0] != '') $business_photo_chef = site_url($user_meta_info["_chef_business_photo"][0]); else $business_photo_chef ='/wp-content/uploads/users/logosombrero.png';
            if($user_meta_info["first_name"][0] != '') $nombre_chef = $user_meta_info["first_name"][0]; else $nombre_chef ='Nombre';
            if($user_meta_info["_chef_city"][0] != '') $ciudad_chef = $user_meta_info["_chef_city"][0]; else $ciudad_chef ='Ciudad';
            if($user_meta_info["_chef_country"][0] != '') $pais_chef = $user_meta_info["_chef_country"][0]; else $pais_chef ='País';
            if($user_meta_info["_chef_busi_name"][0] != '') $business_chef = $user_meta_info["_chef_busi_name"][0]; else $business_chef ='Nombre';
            if($user_meta_info["_chef_visits"][0] != '') $visitas = $user_meta_info["_chef_visits"][0]; else $visitas ='0';
            if($user_meta_info["wpfui2i_featured_user"][0] != 'yes') $destacado = false; else $destacado = true;
            
            $users = get_users();
            $cont_seguidores = 0;
            
            foreach ($users as $user_check) {
                $user_check_data = get_user_meta($user_check->data->ID);
                $following = json_decode($user_check_data['_chef_follow'][0]);
                if(in_array($user->ID,$following)){
                    $cont_seguidores++;
                }
            }
            
            $response = $response."<div class='chef-container'> 
                            <div class='g-content'>                                                            
                                <div class='g-array-item std-box'>
                                        <a href='http://desarrolloesencial.dev/mi-perfil/?perfil='".$user->ID."'><div class='img-box' style='background-image:url('".$business_photo_chef."');'>
                                        </div></a>
                                    <div class='autor-img-box-sidebar'>
                                        <a href='http://desarrolloesencial.dev/mi-perfil/?perfil='".$user->ID."'><img src='".$personal_photo_chef."'></a>
                                    </div>
                                    <div class='content-box-chefs text-center'>

                                        <h3><a href='http://desarrolloesencial.dev/mi-perfil/?perfil='".$user->ID."'>".$nombre_chef."</a></h3>
                                        <p class='small ciudad'>'".$ciudad_chef."', '".$pais_chef."'</p>
                                        <p>".$business_chef."</p>                           
                                    </div>

                                    <div class='text-center'>
                                        <a class='read-more' href='http://desarrolloesencial.dev/mi-perfil/?perfil='".$user->ID."'><i class='fa fa-plus-circle fa-3x' aria-hidden='true'></i></a>
                                        <div class='gap-20'></div>                                    
                                    </div>
                                    <div class='bottom-box'>
                                        <p class=''>&nbsp;
                                            <i class='fa fa-eye' aria-hidden='true'></i>".$visitas."  &nbsp;
                                            <i class='fa fa-star' aria-hidden='true'></i>".$cont_seguidores." &nbsp;             
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
        
        $response = $response."</div>";
                

        
    }

    return $response;
    
}

function get_chefs_favorites(){
    
    $users = get_users();
    

    
    
    return $chefsFavorites;
    
}