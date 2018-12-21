<?php
/**
 * Controller
 * User: louis_de_bruijn
 * Date: 05-12-18
 * Time: 17:45
 */

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_final', 'ddwt18','ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

// Global variables for all routes
    /* Navigation */
    $navigation_tpl = Array(
        1 => Array(
            'name' => 'Home',
            'url' => '/DDWT18/' ),
        2 => Array(
            'name' => 'Overview',
            'url' => '/DDWT18/overview/' ),
        3 => Array(
            'name' => 'Login',
            'url' => '/DDWT18/login/' ),
        4 => Array(
            'name' => 'Register',
            'url' => '/DDWT18/register/'),
        5 => Array(
            'name' => 'My Account',
            'url' => '/DDWT18/myaccount/'),
        6 => Array(
            'name' => 'Add room',
            'url' => '/DDWT18/add/',
        ));
    /* Root folder */
    $root = '/DDWT18';

/* Home GET */
$router->get('/', function() use($db, $navigation_tpl, $root) {
    /* Check if user is logged in */
    check_login();

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 1);

    /* Get msg from POST route */
    if ( isset($_GET['msg']) ) {
        $view_msg = get_error($_GET['msg']);
    }

    /* Page */
    $page_title = 'Home';
    $page_subtitle = 'Wat gaan we hiermee doen';
    $page_content = 'Tot nu toe niet heel veel';
    include use_template('main');

});

/* Overview GET */
$router->get('/overview', function() use ($db, $navigation_tpl, $root) {
    /* Check if user is logged in */
    check_login();

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 2);

    /* Get msg from POST route */
    if ( isset($_GET['msg']) ) {
        $view_msg = get_error($_GET['msg']);
    }

    /* Get rooms from db */
    $rooms = get_rooms($db);

    /* Page */
    $page_title = 'Overview';
    $page_subtitle = 'Rooms in Groningen';
    $page_content = 'An overview of available rooms in Groningen';
    $left_content = get_rooms_table($db, $rooms);
    $nbr_rooms = count_rooms($db);
    include use_template('main');

});

/* Single room mount */
$router->mount('/room', function() use ($router, $db, $navigation_tpl, $root) {

    /* Single room GET */
    $router->get('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if user is logged in */
        check_login();

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 2);

        /* Get msg from POST route */
        if ( isset($_GET['msg']) ) {
            $view_msg = get_error($_GET['msg']);
        }

        /* Get room_id from $_GET variables */
        $room_id = $_GET['room_id'];

        /* Check whether $_GET variables are set */
        if (check_url_var($room_id)){
            redirect('/DDWT18/overview/');
        }

        /* Display buttons */
        $display_buttons = display_buttons($db, get_user_id(), $room_id);

        /* get room info from database */
        #redundant -> kan ook gewoon als $room_info['name'] in de view
        $room_id = $_GET['room_id'];
        $room_info = get_room_info($db, $room_id);
        $room_name = $room_info['name'];
        $room_streetname = $room_info['streetname'];
        $room_streetnumber = $room_info['streetnumber'];
        $room_postalcode = $room_info['postalcode'];
        $room_city = $room_info['city'];
        $room_type = $room_info['type'];
        $room_price = $room_info['price'];
        $room_size = $room_info['size'];

        /* Page */
        $page_title = 'View Room';
        $page_subtitle = 'View the room';
        $page_content = 'Below you can find the details of the room.';
        include use_template('room');

    });

    /* Single room REMOVE */
    $router->post('/remove', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Remove room from database */
        #fout: deze functie werkt nog niet.
        $feedback = remove_room($db, get_user_id(), $_POST);

        /* Redirect to room GET route */
        #redirect(sprintf('/DDWT18/overview/?error_msg=%s', json_encode($feedback)));
        $error_msg = get_error($feedback);

    });

        /* Edit single room GET */
    $router->get('/edit', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Get msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Get room_id from $_GET variables */
        $room_id = $_GET['room_id'];

        /* Check whether url variables are set */
        if (check_url_var($room_id)){
            redirect('/DDWT18/overview/');
        }

        /* Get current room details */
        $room_info = get_room_info($db, $room_id);

        /* Check user route authorization */
        if (check_route(get_user_id(), $room_info['owner'])) {
            redirect('/DDWT18/overview/');
        }

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        #redundant: deze code kan redundant worden door de functie get_room_cards !
        /* Show example image or room images */
        if (is_dir_empty('../DDWT18/images/users/uploads/'.$room_info['owner'].'/rooms/'.$room_id.'/')){
            $image_src = '/DDWT18/images/avatar.jpg';
        } else {
            $files = scandir ('../DDWT18/images/users/uploads/'.$room_info['owner'].'/rooms/'.$room_id.'/');
            $image_src = '/DDWT18/images/users/uploads/'.$room_info['owner'].'/rooms/'.$room_id.'/'.$files[2]; // because [0] = "." [1] = ".."
        }

        /* Add images */
        $img_form_action = '/DDWT18/room/image';
        $add_pictures = image_card($img_form_action, 'Upload', $image_src, $room_id);

        /* Page */
        $page_title = 'Edit Room';
        $page_subtitle = 'Edit your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Edit room";
        $form_action = '/DDWT18/room/edit';
        include use_template('new-step2');

    });

    /* Upload images single room POST */
    $router->post('/image', function() use ($router, $db, $navigation_tpl, $root) {
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Upload image */
        $directory_name = "images/users/uploads";
        $target_dir = create_directory($directory_name, get_user_id(), 'rooms/'.$_POST['room_id']);

        $feedback = upload_file($db, get_user_id(), $target_dir, $_POST['room_id']);

        #fout: hier moet nog een mooie redirect komen
    });

    /* Edit single room POST */
    $router->post('/edit', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Edit serie to database */
        $feedback = update_room($db, $_POST, get_user_id());

        /* Redirect to serie GET route */
        redirect(sprintf('/DDWT18/room/?error_msg=%s', json_encode($feedback)));

    });

});


/* Login GET */
$router->get('/login', function() use ($db, $navigation_tpl, $root) {
    /* Check if logged in */
    if ( check_login() ) {
        redirect('/DDWT18/myaccount/');
    }

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 3);

    /* Get error msg from POST route to GET route */
    if ( isset($_GET['error_msg']) ) {
        $view_msg = get_error($_GET['error_msg']);
    }

    /* Page */
    $page_title = 'Login';
    include use_template('login');


});

/* Login POST */
$router->post('/login', function() use ($db, $navigation_tpl, $root) {
    /* Login user */
    $feedback = login_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/login/?error_msg=%s', json_encode($feedback)));

});

/* Logout GET */
$router->get('/logout', function() use ($db) {

    /* Logout user */
    $feedback = logout_user();

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/?msg=%s',
        json_encode($feedback)));

});

/* Register GET */
$router->get('/register', function() use ($db, $navigation_tpl, $root) {
    /* Check if user is logged in */
    check_login();

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 4);

    /* Get error msg from POST route to GET route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Page */
    $page_title = 'Register';
    include use_template('register');

});

/* Register POST */
$router->post('/register', function() use ($db, $navigation_tpl, $root) {

    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/register/?error_msg=%s', json_encode($error_msg)));

});

/* Add room mount */
$router->mount('/add', function() use ($router, $db, $navigation_tpl, $root) { #waarom moet ik bij elke route weer opnieuw deze variabelen aanroepen

    /* Add room GET */
    $router->get('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Get msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Page  */
        $page_title = 'Add Room';
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Continue";
        $form_action = '/DDWT18/add/';
        include use_template('new-step1');

    });

    /* Add room POST-step1 */
    $router->post('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }
        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);


        /* Call postcode API */
        $postcode_data = postcode($db, $_POST);
        var_dump($postcode_data);

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Page info */
        $page_title = 'Add Room';

        #fout: hier ga je de error messages nooit krijgen want dit is een post route, dus dit moet je anders doen, dus die error message van step-1 moet je in de post-variabele meegeven

        /* Postalcode API data */
        $postalcode = $_POST['postalcode'];
        $streetnumber = $_POST['streetnumber'];
        $city = $postcode_data['city'];
        $street = $postcode_data['street'];

        /* Page  */
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Add room";
        $form_action = '/DDWT18/add/next';
        include use_template('new-step2');

    });

    /* Add room POST-step2 */
    $router->post('/next', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Page */
        $page_title = 'Add Room';
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Add serie to database */
        $feedback = add_room($db, $_POST, get_user_id());;

        #fout: beste is om te valideren wat er WEL uit moet komen en al het andere is een danger message!
        #fout: if $feedback = type 'danger' dan redirect naar deze pagina en else redirect naar de andere pagina.

        #fout: hoe maak je nou dat de $feedback doormoet naar de overview pagina maar de #error message naar dezelfde add/room pagina. ????

        /* Redirect to serie GET route */
        redirect(sprintf('/DDWT18/overview/?error_msg=%s', json_encode($feedback)));

    });
});

/* Account mount */
$router->mount('/myaccount', function() use ($router, $db, $navigation_tpl, $root) {

    /* Account GET */
    $router->get('/', function() use ($db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 5);

        /* Get msg from POST route */
        if ( isset($_GET['msg']) ) {
            $view_msg = get_error($_GET['msg']);
        }

        /* Get rooms from db */
        $rooms = get_rooms($db);
        $rooms_cards = get_rooms_cards2(get_image_src($db, $rooms, get_user_id()));

        /* Avatar image */
        $avatar = check_avatar(get_user_id());

        /* User first name and last name */
        $name = get_username($db, get_user_id());

        /* Get account info from db */
        $user_info = get_account_info($db, get_user_id()); #fout: deze functie is PRECIES hetzelfde als get_serieinfo() en is dus redundant, maar nu voor nu voldoet het even. We kunnen later get_serieinfo() herschrijven zodat we die ook hier kunnen gebruiken.

        /* Page info */
        $page_title = 'My Account';
        $page_subtitle = 'Edit your account here';
        $page_content = 'An overview of your account ';
        include use_template('account');

    });

    /* Account POST */
    $router->post('/', function() use ($db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

    });

    /* Edit Account GET */
    $router->get('/edit', function() use ($db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 5);

        /* Get msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Avatar & Name card */
        $avatar = check_avatar(get_user_id());
        $name = get_username($db, get_user_id());

        /* Change avatar */
        $avatar = check_avatar(get_user_id());
        $form_action_avatar = '/DDWT18/myaccount/avatar';
        $submit_btn_avatar = 'Upload';

        /* Get account info from db */
        $user_info = get_account_info($db, get_user_id()); #deze functie is PRECIES hetzelfde als get_serieinfo() en is dus redundant, maar nu voor nu voldoet het even. We kunnen later get_serieinfo() herschrijven zodat we die ook hier kunnen gebruiken.
        $user_id = get_user_id();

        /* Page info */
        $root = '/DDWT18/';
        $page_title = 'My Account';
        $page_subtitle = 'Edit your account here';
        $page_content = 'An overview of your account';
        $form_action = '/DDWT18/myaccount/edit';
        $submit_btn = 'Edit';
        include use_template('user_edit');

        /* Redirect to homepage */
        redirect(sprintf('/DDWT18/myaccount?error_msg=%s',
            json_encode($error_msg)));


    });

    /* Edit user account POST */
    $router->post('/edit', function() use ($db, $navigation_tpl, $root) {

        /* Update user in database */
        $feedback = update_user($db, $_POST);
        $error_msg = get_error($feedback);

        var_dump($feedback, $error_msg); #hiermee kunnen jullie zien welke message je op deze pagina krijgt

        /* Get user info from db */
        $user_id = $_POST['user_id'];
        $user_info = get_account_info($db, $user_id);

        /* Get user account information from db
        #redundant: deze variabelen omschrijven is niet nodig.
        $navigation = get_navigation($navigation_tpl, 5);
        $name = get_username($db, get_user_id());
        $page_title = 'edit account';
        $page_subtitle = 'edit here your personal account';
        $page_content = '';
        $user_id = $_GET['user_id'];
        $user_info = get_account_info($db, $user_id);
        $user_firstname = $user_info['firstname'];
        $user_lastname = $user_info['lastname'];
        $user_birthdate = $user_info['birthdate']; #je kan niet veranderen van tenant of owner dus die hebben we er niet in
        $user_biography = $user_info['biography'];
        $user_occupation = $user_info['occupation'];
        $user_language = $user_info['language'];
        $user_email = $user_info['email'];
        $user_phone = $user_info['phone'];

        #we moeten deze nog doen!!!!!!! */

    });

    /* Edit user avatar POST */
    $router->post('/avatar', function() use ($db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Create directory */
        $directory_name = "images/users/uploads";
        $target_dir = create_directory($directory_name, get_user_id(), 'avatar');

        /* Upload file */
        $feedback = upload_file($db, get_user_id(), $target_dir, $_POST['room_id']);

    });


});


$router->set404(function() {
    // will result in an error message on page 404
    header('HTTP/1.1 404 Not Found');
    http_response_code(404);
    echo 'Error: HTTP/1.1 404 Not Found';
});

/* Run the router */
$router->run();

