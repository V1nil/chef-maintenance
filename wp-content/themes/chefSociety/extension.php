<?php

/**
 * Este archivo PHP nos permitirá jugar con AJAX y WP para devolver cosas de forma asincrona
 */

require( $_SERVER['DOCUMENT_ROOT']. '/wp-load.php' );

/*
 * Seccion POST
 */

//LOGIN - Create user
if(isset($_POST['custom_user_create']) && isset($_POST['user_login']) && isset($_POST['user_email']) && isset($_POST['user_pass'])){
    $user_name = filter_input(INPUT_POST, 'user_login');
    $user_pass = filter_input(INPUT_POST, 'user_pass');
    $user_email = filter_input(INPUT_POST, 'user_email');
    $day_birth = filter_input(INPUT_POST, 'day_birth');
    $month_birth = filter_input(INPUT_POST, 'month_birth');
    $year_birth = filter_input(INPUT_POST, 'year_birth');

    $user_id=wp_create_user( $user_name, $user_pass, $user_email );
        
    if(is_wp_error($user_id)){
        
        $response = json_encode( [
				"redirect"    => false,
                                "error"     => $user_id->get_error_message()
			] );
    }else{
        //Asignamos su fecha de nacimiento ya a los datos del user
        $user_data = get_user_meta($user_id);
        add_user_meta($user_id, '_chef_birthdate', $day_birth.'/'.$month_birth.'/'.$year_birth);

        $response = log_user($user_name, $user_pass);

    }
    
    send_response($response);    
    die();
}
//LOGIN - Login user
if(isset($_POST['custom_user_login']) && isset($_POST['user_login']) && isset($_POST['user_pass'])){
    
    $user_name = filter_input(INPUT_POST, 'user_login');
    $user_pass = filter_input(INPUT_POST, 'user_pass');
    
    $response = log_user($user_name, $user_pass);
    
    send_response($response);
    die();
}


function log_user($user_name, $user_pass){
    
    $creds = array();
    $creds['user_login'] = $user_name;
    $creds['user_password'] = $user_pass;
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
    if ( is_wp_error($user) ){
        $response = json_encode( [
                                "redirect"    => false,
                                "error"     => 'Usuario o contraseña no válidos'
        ] );        
    }else{
        $response = json_encode( [
                                "redirect"    => site_url()
        ] );

    }
    send_response($response);
    die();
}

// RESET PASSWORD
if( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) 
{
    global $wpdb;

    $error = '';
    $success = '';
    $redirect = true;
    $email = trim(filter_input(INPUT_POST, 'user_login'));

    if( empty( $email ) ) {
            $error = 'Introduzca un correo';
    } else if( ! is_email( $email )) {
            $error = 'Correo no válido';
    } else if( ! email_exists($email) ) {
            $error = 'No existe ninguna cuenta con dicho correo electronico';
    } else {
            //Generamos la nueva clave
            $random_password = wp_generate_password( 12, false );

            //Recuperamos el user
            $user = get_user_by( 'email', $email );

            $update_user = wp_update_user( array (
                            'ID' => $user->ID, 
                            'user_pass' => $random_password
                    )
            );

            //Si todo ha ido bien mandamos el correo
            if( $update_user ) {
                    $to = $email;
                    $subject = 'Restablecimiento de contraseña';
                    $sender = get_option('name');

                    $message = 'Su nueva contraseña es: '.$random_password;

                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers[] = "X-Mailer: PHP \r\n";
                    $headers[] = 'From: '.$sender.' < '.$email.'>' . "\r\n";

                    $mail = wp_mail( $to, $subject, $message, $headers );
                    if( $mail ){
                            $success = 'Compruebe su dirección de correo para ver su nueva contraseña';
                    }
            } else {
                    $error = 'Upps... algo ha ido mal actualizando su cuenta, intentalo de nuevo';
            }
    }
    
    if( ! empty( $error ) ){
        $redirect = false;
    }
    
    $response = json_encode( [
                                "redirect"    => $redirect,
                                "error"     => $error,
                                "success"   => $success
    ] );

    send_response($response);
    die();
}

function send_response($response){
    echo $response;
    ob_flush();
    flush();
}

//BUSCADOR de POST
if( isset( $_POST['action'] ) && 'search' == $_POST['action'] ) {
    
    $keyword= filter_input(INPUT_POST, 'search_input');
    
    //Podemos utilizar WP pero solo busca por titulo no en el content como especificaron... allá ellos
//    $query_args = array( 's' => $keyword );
//    $query = new WP_Query( $query_args );

    if(!empty($keyword)){
        $sqlSelect = $wpdb->prepare("SELECT {$wpdb->prefix}posts.ID, {$wpdb->prefix}posts.post_type "
                                    . "FROM {$wpdb->prefix}posts "
                                    . "WHERE 1=1 "
                                    . "AND ({$wpdb->prefix}posts.post_title LIKE '%s' OR {$wpdb->prefix}posts.post_content LIKE '%s') "
                                    . "AND {$wpdb->prefix}posts.post_type IN ('post', 'recipe', 'product') "
                                    . "AND ({$wpdb->prefix}posts.post_status = 'publish' OR {$wpdb->prefix}posts.post_status = 'closed') "
                                    . "ORDER BY {$wpdb->prefix}posts.post_date DESC",'%'.$keyword.'%','%'.$keyword.'%');
        $obj = $wpdb->get_col($sqlSelect);        
        
    }
    
    if ( !$obj ) {
        $message = '<p>No hay resultados... :(</p>';
        $results = false;
        
    }else{     
        $message = '<ul>';
        foreach($obj as $post_id) {
            
            $link=get_the_permalink($post_id);
            $title=get_the_title($post_id);

            $message = $message.'<li><a href="'.$link.'">'.$title.'</a></li>';
            $results = true;
            
        }
        $message = $message.'</ul>';
    }
    
    $response = json_encode( array(
                                    "message" => $message,
                                    "results" => $results
                                )
                            );
    send_response($response);        

    
    die();
}

/* EDICION DE MI PERFIL */

//Datos personales
if( isset( $_POST['action'] ) && 'edit-perfil' == $_POST['action'] ) {
    
    $user_id = filter_input(INPUT_POST, 'user');

    $user_name = filter_input(INPUT_POST, 'user_name');
    $birthdate = filter_input(INPUT_POST, 'birthdate');
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $country = filter_input(INPUT_POST, 'country');
    $city = filter_input(INPUT_POST, 'city');
    $gastronomy = filter_input(INPUT_POST, 'gastronomy');
     
    $user_data = get_user_meta($user_id);

    //Actualizamos o no dependiendo de si ha habido modificaciones
    if(!isset($user_data['nickname'])){
        add_user_meta($user_id, 'nickname', $user_name);
    }elseif ($user_data['nickname'][0] !== $user_name) {
        update_user_meta($user_id, 'nickname', $user_name);
    }

    if(!isset($user_data['_chef_birthdate'])){
        add_user_meta($user_id, '_chef_birthdate', $birthdate);
    }elseif ($user_data['_chef_birthdate'][0] !== $birthdate) {
        update_user_meta($user_id, '_chef_birthdate', $birthdate);
    }
        
    if(!isset($user_data['first_name'])){
        add_user_meta($user_id, 'first_name', $first_name);
    }elseif ($user_data['first_name'][0] !== $first_name) {
        update_user_meta($user_id, 'first_name', $first_name);
    }
    
    if(!isset($user_data['last_name'])){
        add_user_meta($user_id, 'last_name', $last_name);
    }elseif ($user_data['last_name'][0] !== $last_name) {
        update_user_meta($user_id, 'last_name', $last_name);
    }

    if(!isset($user_data['_chef_country'])){
        add_user_meta($user_id, '_chef_country', $country);
    }elseif ($user_data['_chef_country'][0] !== $country) {
        update_user_meta($user_id, '_chef_country', $country);
    }
    
    if(!isset($user_data['_chef_city'])){
        add_user_meta($user_id, '_chef_city', $city);
    }elseif ($user_data['_chef_city'][0] !== $city) {
        update_user_meta($user_id, '_chef_city', $city);
    }

    if(!isset($user_data['_gastronomy'])){
        add_user_meta($user_id, '_gastronomy', $gastronomy);
    }elseif ($user_data['_gastronomy'][0] !== $gastronomy) {
        update_user_meta($user_id, '_gastronomy', $gastronomy);
    }

    $response = json_encode( array(
                                    "message" => 'Datos guardados! :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    
    die();
}
//COnfiguracion de la cuenta
if( isset( $_POST['action'] ) && 'edit-conf' == $_POST['action'] ) {
    
    $user_id = filter_input(INPUT_POST, 'user');
    $user_email = filter_input(INPUT_POST, 'user_email');
    $new_pass = filter_input(INPUT_POST, 'user_pass');
    
    $user_data=get_userdata($user_id);

    if(!empty($new_pass)){
        wp_set_password($new_pass, $user_id);
    }
    
    if($user_data->data->user_email !== $user_email){        
        $updated_data = array ( 'ID' => $user_id,
                                'user_email' => $user_email );
        wp_update_user($updated_data);
    }
    
    $response = json_encode( array(
                                    "message" => 'Datos guardados! :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    
    die();
}

//Areas de interés
if( isset( $_POST['action'] ) && 'edit-areas' == $_POST['action'] ) {
    
    $user_id = filter_input(INPUT_POST, 'user');
    
    $user_data = get_user_meta($user_id);
    $areas_ids = filter_input(INPUT_POST, 'areas_ids');
    
    if(!isset($user_data['_areas_interes'])){
        add_user_meta($user_id, '_areas_interes', $areas_ids);
    }elseif ($user_data['_areas_interes'][0] !== $areas_ids) {
        update_user_meta($user_id, '_areas_interes', $areas_ids);
    }
    
    $response = json_encode( array(
                                    "message" => 'Datos guardados! :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    
    
    die();
    
}

//Areas de interés
if( isset( $_POST['action'] ) && 'edit-ficha' == $_POST['action'] ) {

    $user_id = filter_input(INPUT_POST, 'user');
    $user_web = filter_input(INPUT_POST, 'user_web');
    $user_job = filter_input(INPUT_POST, 'user_job');
    $user_available =  filter_input(INPUT_POST, 'user_available');
    if($user_available === 'true'){
        $user_available = 1;
    }else{
        $user_available = 0;
    }
    $user_data = get_user_meta($user_id);

    if(!isset($user_data['_chef_web'])){
        add_user_meta($user_id, '_chef_web', $user_web);
    }elseif ($user_data['_chef_web'][0] !== $user_web) {
        update_user_meta($user_id, '_chef_web', $user_web);
    }

    if(!isset($user_data['_chef_job'])){
        add_user_meta($user_id, '_chef_job', $user_job);
    }elseif ($user_data['_chef_job'][0] !== $user_job) {
        update_user_meta($user_id, '_chef_job', $user_job);
    }

    if(!isset($user_data['_chef_available'])){
        add_user_meta($user_id, '_chef_available', $user_available);
    }elseif ($user_data['_chef_available'][0] !== $user_available) {
        update_user_meta($user_id, '_chef_available', $user_available);
    }
    
    $response = json_encode( array(
                                    "message" => 'Datos guardados! :)',
                                    "results" => true
                                )
                            );
    send_response($response);

    die();
}

if( isset( $_POST['action'] ) && 'edit-business' == $_POST['action'] ) {
    
    $user_id = filter_input(INPUT_POST, 'user');
    $user_busi_name = filter_input(INPUT_POST, 'user_busi_name');
    $user_busi_address = filter_input(INPUT_POST, 'user_busi_address');
    $user_food_price = filter_input(INPUT_POST, 'user_food_price');
    $user_menu_price = filter_input(INPUT_POST, 'user_menu_price');
    $cocinas_ids = filter_input(INPUT_POST, 'cocinas_ids');
    
    $user_data = get_user_meta($user_id);
    
    if(!isset($user_data['_chef_busi_name'])){
        add_user_meta($user_id, '_chef_busi_name', $user_busi_name);
    }elseif ($user_data['_chef_busi_name'][0] !== $user_busi_name) {
        update_user_meta($user_id, '_chef_busi_name', $user_busi_name);
    }
    if(!isset($user_data['_chef_busi_address'])){
        add_user_meta($user_id, '_chef_busi_address', $user_busi_address);
    }elseif ($user_data['_chef_busi_address'][0] !== $user_busi_address) {
        update_user_meta($user_id, '_chef_busi_address', $user_busi_address);
    }

    if(!isset($user_data['_chef_food_price'])){
        add_user_meta($user_id, '_chef_food_price', $user_food_price);
    }elseif ($user_data['_chef_food_price'][0] !== $user_food_price) {
        update_user_meta($user_id, '_chef_food_price', $user_food_price);
    }

    if(!isset($user_data['_chef_menu_price'])){
        add_user_meta($user_id, '_chef_menu_price', $user_menu_price);
    }elseif ($user_data['_chef_menu_price'][0] !== $user_menu_price) {
        update_user_meta($user_id, '_chef_menu_price', $user_menu_price);
    }

    if(!isset($user_data['_tipos_cocina'])){
        add_user_meta($user_id, '_tipos_cocina', $cocinas_ids);
    }elseif ($user_data['_tipos_cocina'][0] !== $cocinas_ids) {
        update_user_meta($user_id, '_tipos_cocina', $cocinas_ids);
    }
    
    $response = json_encode( array(
                                    "message" => 'Datos guardados! :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    
    die();
}


//Fotos (personal y negocio)
if( isset( $_POST['action'] ) && 'edit-photo' == $_POST['action'] ) {

    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);
    
    $results = true;
    
    if(isset($_POST['kind']) && $_POST['kind'] == 'personal'){
        $kind='user';
        $meta_key = '_chef_personal_photo';
    }
    if(isset($_POST['kind']) && $_POST['kind'] == 'business'){
        $kind='business';
        $meta_key = '_chef_business_photo';
    }
    
    if(isset($_FILES["file"]["type"])) {
        $extensiones_validas = array("jpeg", "jpg", "png");
        $mark_up = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($mark_up); 
        if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 1000000)
        && in_array($file_extension, $extensiones_validas)) {
            if ($_FILES["file"]["error"] > 0){
                $results = false;
                $message = "Error subiendo el fichero";
            }else{
                if (file_exists(ABSPATH."wp-content/uploads/users/".$kind."-" . $user_id.".".$file_extension)) {
                    unlink(ABSPATH."wp-content/uploads/users/".$kind."-" . $user_id.".".$file_extension);                    
                }
                $fuente = $_FILES['file']['tmp_name'];
                $objetivo = ABSPATH."wp-content/uploads/users/".$kind."-" . $user_id.".".$file_extension;
                move_uploaded_file($fuente, $objetivo);
                chmod($objetivo, 0755);
                $message = "Imagen subida correctamente :)";
                $meta_path = "wp-content/uploads/users/".$kind."-" . $user_id.".".$file_extension;
                
                if(!isset($user_data[$meta_key])){
                    add_user_meta($user_id, $meta_key, $meta_path);
                }elseif ($user_data[$meta_key][0] !== $meta_path) {
                    //Borramos el fichero que hubiera y actualizamos
                    unlink(ABSPATH.$user_data[$meta_key][0]);
                    update_user_meta($user_id, $meta_key, $meta_path);
                }
            }
        } else {
            $results = false;
            $message = "Formato de imagen no válido o tamaño demasiado grande";
        }
    }
    
    
    $response = json_encode( array(
                                    "message" => $message,
                                    "results" => $results
                                )
                            );
    send_response($response);

    die();

}
//Borrado de la foto personal
if( isset( $_POST['action'] ) && 'del-photo' == $_POST['action'] ) {
    
    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);
    
    
    if(isset($_POST['kind']) && $_POST['kind'] == 'personal'){
        unlink(ABSPATH.$user_data['_chef_personal_photo'][0]);

        delete_user_meta($user_id, '_chef_personal_photo');
    }
    
    if(isset($_POST['kind']) && $_POST['kind'] == 'business'){
        unlink(ABSPATH.$user_data['_chef_business_photo'][0]);

        delete_user_meta($user_id, '_chef_business_photo');        
    }
    
    
    $response = json_encode( array(
                                    "message" => 'Imagen borrada correctamente! :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    
    die();
}

/**
 * Seccion de eventos del sidebar (seguir y añadir a favoritos)
 */
//Seguir
if( isset( $_POST['action'] ) && 'follow' == $_POST['action'] ) {

    $user_id = filter_input(INPUT_POST, 'user_following');
    $user_data = get_user_meta($user_id);
    
    $user_to_follow = filter_input(INPUT_POST, 'user_to_follow');
    $meta_key = "_chef_follow";

    if(!isset($user_data[$meta_key])){
        $chefs_followed = array($user_to_follow);
        $chefs_followed=  json_encode($chefs_followed);
        add_user_meta($user_id, $meta_key, $chefs_followed);
    }else{
        $chefs_followed = json_decode($user_data[$meta_key][0]);

        if(!in_array($user_to_follow, $chefs_followed)){
            $chefs_followed[]=$user_to_follow;
            $chefs_followed=  json_encode($chefs_followed);
            update_user_meta($user_id, $meta_key, $chefs_followed);            
        }
    }    
    
    $response = json_encode( array(
                                    "message" => 'Siguiendo :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    die();
}
//Eliminar de seguidos
if( isset( $_POST['action'] ) && 'unfollow' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user_following');
    $user_data = get_user_meta($user_id);
    
    $user_to_unfollow = filter_input(INPUT_POST, 'user_to_unfollow');
    $meta_key = "_chef_follow";    
    
    $chefs_followed = json_decode($user_data[$meta_key][0]);
    unset($chefs_followed[array_search($user_to_unfollow,$chefs_followed)]);
    $chefs_followed_formated = array_values($chefs_followed);
    $chefs_followed = json_encode($chefs_followed);
    update_user_meta($user_id, $meta_key, $chefs_followed);            

    $response = json_encode( array(
                                    "message" => 'Has dejado de seguir a este chef :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    die();
}


//Añadir
if( isset( $_POST['action'] ) && 'favorite' == $_POST['action'] ) {

    $user_id = filter_input(INPUT_POST, 'user_adding');
    $user_data = get_user_meta($user_id);
    
    $user_favorite = filter_input(INPUT_POST, 'user_favorite');
    $meta_key = "_chef_favorite";

    if(!isset($user_data[$meta_key])){
        $chefs_favorites = array($user_favorite);
        $chefs_favorites = json_encode($chefs_favorites);
        add_user_meta($user_id, $meta_key, $chefs_favorites);
    }else{
        $chefs_favorites = json_decode($user_data[$meta_key][0]);

        if(!in_array($user_favorite, $chefs_favorites)){
            $chefs_favorites[]=$user_favorite;
            $chefs_favorites = json_encode($chefs_favorites);
            update_user_meta($user_id, $meta_key, $chefs_favorites);            
        }            
    }
    
    $response = json_encode( array(
                                    "message" => 'Añadido :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    die();
}

//Eliminar de favoritos
if( isset( $_POST['action'] ) && 'unfavorite' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user_adding');
    $user_data = get_user_meta($user_id);
    
    $user_unfavorite = filter_input(INPUT_POST, 'user_unfavorite');
    $meta_key = "_chef_favorite";

    $chefs_favorites = json_decode($user_data[$meta_key][0]);
    unset($chefs_favorites[array_search($user_unfavorite,$chefs_favorites)]);
    $chefs_favorites_formated = array_values($chefs_favorites);
    $chefs_favorites = json_encode($chefs_favorites_formated);
    update_user_meta($user_id, $meta_key, $chefs_favorites);            

    $response = json_encode( array(
                                    "message" => 'Has quitado de favoritos a este chef :)',
                                    "results" => true
                                )
                            );
    send_response($response);
    die();
}

/**
 * Seccion de añadir recetas y promos a favoritos
 */
//Añadir receta a favoritos
if( isset( $_POST['action'] ) && 'add-favorite-recipe' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);

    $post_id = filter_input(INPUT_POST, 'post_id');
    $meta_key = "_chef_favorite_recipes";
    
    if(!isset($user_data[$meta_key])){
        $user_fav_recipes_array = array($post_id);
        $user_fav_recipes = json_encode($user_fav_recipes_array);
        add_user_meta($user_id, $meta_key, $user_fav_recipes);
    }else{
        $user_fav_recipes_array = json_decode($user_data[$meta_key][0]);

        if(!in_array($post_id, $user_fav_recipes_array)){
            $user_fav_recipes_array[]=$post_id;
            $user_fav_recipes = json_encode($user_fav_recipes_array);
            update_user_meta($user_id, $meta_key, $user_fav_recipes);
        }            
    }
}
//Quitar receta de favoritos
if( isset( $_POST['action'] ) && 'remove-favorite-recipe' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);
    
    $post_id = filter_input(INPUT_POST, 'post_id');
    $meta_key = "_chef_favorite_recipes";

    $user_fav_recipes_array = json_decode($user_data[$meta_key][0]);
    unset($user_fav_recipes_array[array_search($post_id,$user_fav_recipes_array)]);
    //Cambiamos a números consecutivos, sino grabará como un array asociativo
    $user_fav_recipes_formated = array_values($user_fav_recipes_array);
    $user_fav_recipes = json_encode($user_fav_recipes_formated);
    update_user_meta($user_id, $meta_key, $user_fav_recipes);
}
//Añadir promo a favoritos
if( isset( $_POST['action'] ) && 'add-favorite-promo' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);

    $post_id = filter_input(INPUT_POST, 'post_id');
    $meta_key = "_chef_favorite_promos";
    
    if(!isset($user_data[$meta_key])){
        $user_fav_promos_array = array($post_id);
        $user_fav_promos = json_encode($user_fav_promos_array);
        add_user_meta($user_id, $meta_key, $user_fav_promos);
    }else{
        $user_fav_promos_array = json_decode($user_data[$meta_key][0]);

        if(!in_array($post_id, $user_fav_promos_array)){
            $user_fav_promos_array[]=$post_id;
            $user_fav_promos = json_encode($user_fav_promos_array);
            update_user_meta($user_id, $meta_key, $user_fav_promos);
        }            
    }
}
//Quitar promo de favoritos
if( isset( $_POST['action'] ) && 'remove-favorite-promo' == $_POST['action'] ) {
    $user_id = filter_input(INPUT_POST, 'user');
    $user_data = get_user_meta($user_id);
    
    $post_id = filter_input(INPUT_POST, 'post_id');
    $meta_key = "_chef_favorite_promos";

    $user_fav_promos_array = json_decode($user_data[$meta_key][0]);
    unset($user_fav_promos_array[array_search($post_id,$user_fav_promos_array)]);
    //Cambiamos a números consecutivos, sino grabará como un array asociativo
    $user_fav_promos_formated = array_values($user_fav_promos_array);
    $user_fav_promos = json_encode($user_fav_promos_formated);
    update_user_meta($user_id, $meta_key, $user_fav_promos);
}