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
    if ( isset($_GET['msg']) ) {
        $view_msg = get_error($_GET['msg']);
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
    redirect(sprintf('/DDWT18/register/?msg=%s', json_encode($error_msg)));

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

    /* Count rooms card */
    $count_card = count_rooms($db);

    /* Get rooms from DB */
    $all_rooms = array();
    $rooms = get_rooms($db);

    /* Only show rooms that user owns */
    foreach ($rooms as $key => $room) {
            $rooms_card = get_rooms_cards(get_image_src($db, $room, get_carousel($db, $room['id'])));
            array_push($all_rooms, $rooms_card);
        }

    /* Page */
    $page_title = 'Overview';
    $page_subtitle = 'Rooms in Groningen';
    $page_content = 'View all available rooms here.';
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

        /* Get room info from DB */
        $room_id = $_GET['room_id'];
        $room_info = get_db_info($db, $room_id, 'r');

        /* Check if the route exists */
        route_exists($db, $room_id);

        /* Get images */
        $images = show_carousel(get_carousel($db, $room_id));

        /* Check whether $_GET variables are set */
        if (check_url_var($room_id)){
            redirect('/DDWT18/overview/');
        }

        /* Display buttons */
        $display_buttons = display_buttons($db, get_user_id(), $room_id);
        $display_optin = display_opt_button($db, get_user_id(), $room_id);
        #$display_optout = display_optout($db, get_user_id(), $room_id);


        /* Page */
        $page_title = $room_info['name'];
        $page_subtitle = nl2br($room_info['description']);
        $page_content = 'Room details';
        include use_template('room');

    });

    /* Single room REMOVE */
    $router->post('/remove', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Remove room from database */
        $feedback = remove_room($db, get_user_id(), $_POST['room_id']);

        /* Redirect to room GET route */
        redirect(sprintf('/DDWT18/overview/?msg=%s', json_encode($feedback)));

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
            $view_msg = get_error($_GET['error_msg']);
        }

        /* Get room_id from $_GET variables */
        $room_id = $_GET['room_id'];

        /* Check whether url variables are set */
        if (check_url_var($room_id)){
            redirect('/DDWT18/overview/');
        }

        /* Get current room details */
        $room_info = get_db_info($db, $room_id, 'r');

        /* Check user route authorization */
        if (check_route(get_user_id(), $room_info['owner'])) {
            redirect('/DDWT18/overview/');
        }

        /* Add images */
        $add_pictures = add_image_card('/DDWT18/room/image', 'Upload', $room_id);

        /* Remove images */
        $remove_images = remove_img_card($db, $room_id, '/DDWT18/room/image/remove', 'Remove');

        /* Page */
        $page_title = 'Edit Room';
        $page_subtitle = 'Edit your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = 'Edit room';
        $form_action = '/DDWT18/room/edit';
        include use_template('new-step2');

    });

    /* Edit single room POST */
    $router->post('/edit', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Edit room to database */
        $feedback = update_room($db, $_POST, get_user_id());

        if ($feedback['type'] == 'success'){
            /* Redirect to room GET route */
            redirect(sprintf('/DDWT18/room/?room_id='.$_POST['room_id'].'&msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/room/edit?room_id='.$_POST['room_id'].'&error_msg=%s', json_encode($feedback)));
        }

    });

    /* Upload images single room POST */
    $router->post('/image', function() use ($router, $db, $navigation_tpl, $root) {
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Upload image */
        $directory_name = "images/users/uploads";
        $target_dir = create_directory($directory_name, get_user_id(), 'rooms/'.$_POST['room_id']);

        $feedback = upload_file($db, $target_dir, $_POST['room_id']);

        if ($feedback['type'] == 'success'){
            /* Redirect to room GET route */
            redirect(sprintf('/DDWT18/room/?room_id='.$_POST['room_id'].'&msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/room/edit?room_id='.$_POST['room_id'].'&error_msg=%s', json_encode($feedback)));
        }
    });

    /* Remove images single room POST */
    $router->post('/image/remove', function() use ($router, $db, $navigation_tpl, $root) {
        if (!check_login()) {
            redirect('/DDWT18/login/');
        }

        /* Remove image */
       $feedback = remove_file($db, $_POST);

        if ($feedback['type'] == 'success'){
            /* Redirect to room GET route */
            redirect(sprintf('/DDWT18/room/?room_id='.$_POST['room_id'].'&msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/room/edit?room_id='.$_POST['room_id'].'&error_msg=%s', json_encode($feedback)));
        }

    });

    /* opt in POST */
    $router->post('/optin',function () use ($router, $db, $navigation_tpl, $root) {
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        $room_id = $_POST['room_id'];
        $message = $_POST['message'];

        /* add optin to database */
        $feedback = optin($db, $room_id, get_user_id(), $message);
        #var_dump($feedback);
        redirect(sprintf('/DDWT18/overview/?msg=%s', json_encode($feedback)));
    });

        /* delete optin #tedoen? */
    $router->post('/delete',function () use ($router, $db, $navigation_tpl, $root) {
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        $room_id = $_POST['room_id'];

        /* remove optin from database */
        $feedback = optout($db, $room_id);

        /* Redirect to overview GET route */
        redirect(sprintf('/DDWT18/overview/?msg=%s', json_encode($feedback))); #krijg wel de message maar heeft geen achtergrond kleur?
    });


});

/* Add room mount */
$router->mount('/add', function() use ($router, $db, $navigation_tpl, $root) {

    /* Add room GET */
    $router->get('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Check if user has the role 'owner' */
        $user_info = get_db_info($db, get_user_id(), 'u');
        if ($user_info['role'] != '1' ) {
            $feedback = [
                'type' => 'danger',
                'message' => "You do not have the correct role 'owner' to add a room."
            ];
            redirect(sprintf('/DDWT18/overview/?msg=%s', json_encode($feedback)));
        }
        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Get error msg from POST route to GET route */
        if ( isset($_GET['msg']) ) {
            $view_msg = get_error($_GET['msg']);
        }

        /* Get counter for usage of Postcode API */
        $postcode_count = postcode_count_card(count_postcode($db));

        /* Page  */
        $page_title = 'Add Room';
        $page_subtitle = 'Add your room';
        $page_content = 'Enter the postalcode and street.';
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
        $postcode_data = postcode($db, $_POST, get_user_id());

        if ($postcode_data['type'] == 'success'){
            json_encode($postcode_data);
        } else {
            /* Redirect to Add room GET */
            redirect(sprintf('/DDWT18/add/?msg=%s',
                json_encode($postcode_data)));
        }

        /* Get counter for usage of Postcode API */
        $postcode_count = postcode_count_card(count_postcode($db));

        /* Page info */
        $page_title = 'Add Room';

        /* Postalcode API data */
        $postalcode = $_POST['postalcode'];
        $streetnumber = $_POST['streetnumber'];
        $street = $postcode_data['array']['street'];
        $city = $postcode_data['array']['city'];


        /* Page  */
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Add room";
        $form_action = '/DDWT18/add/next';
        $stepper = True;
        include use_template('new-step2');

    });

    /* Add room POST-step2 */
    $router->post('/next', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Add serie to database */
        $feedback = add_room($db, $_POST, get_user_id());;

        /* Redirect */
        if ($feedback['type'] == 'success'){
            redirect(sprintf('/DDWT18/myaccount/?msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/add/?msg=%s', json_encode($feedback)));
        }

    });
});

/* Account mount */
$router->mount('/myaccount', function() use ($router, $db, $navigation_tpl, $root) {

    /* Account GET */
    $router->get('/', function() use ($db, $navigation_tpl, $root) {
        /* Check if logged in */
        if (!check_login()) {
            redirect('/DDWT18/login/');
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 5);

        /* Get msg from POST route */
        if (isset($_GET['msg'])) {
            $view_msg = get_error($_GET['msg']);
        }

        /* Get rooms from DB */
        $all_rooms = array();
        $rooms = get_rooms($db);

        /* Only show rooms that user owns */
        foreach ($rooms as $key => $room) {
            if (get_user_id() == $room['owner']) {
                $rooms_card = get_rooms_cards(get_image_src($db, $room, get_carousel($db, $room['id'])));
                array_push($all_rooms, $rooms_card);
            }
        }

        /* Get opt ins */
        $tenant = optin_info_tenant($db, get_user_id());

        /* Show opt ins made by tenant to tenant*/
        $optin_table = optin_tenant_table($db, $tenant);

        /* Show opt ins made by tenant to owner */
        $room_ids = room_ids_owner($db, get_user_id());
        $all_opt_info = array();
        foreach ($room_ids as $key => $value) {
            foreach ($value as $keys => $values) {
                $opt_info = get_opt_info($db, $values);
                foreach ($opt_info as $key => $value) {
                    array_push($all_opt_info, $value);

                }
            }
        }
        $optin_owner_table = optin_owner_cards($db, $all_opt_info);

        /* Avatar image */
        $avatar = check_avatar(get_user_id());

        /* User first name and last name */
        $name = get_username($db, get_user_id());

        /* Get account info from db */
        $user_info = get_db_info($db, get_user_id(), 'u');

        /* Page info */
        $page_title = 'My Account';
        $page_subtitle = 'An overview of your account';
        $page_content = 'View the rooms that you have listed below';
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
        if ( isset($_GET['msg']) ) {
            $view_msg = get_error($_GET['msg']);
        }

        /* Avatar & Name card */
        $avatar = check_avatar(get_user_id());
        $name = get_username($db, get_user_id());

        /* Change avatar */
        $form_action_avatar = '/DDWT18/myaccount/avatar';
        $submit_btn_avatar = 'Upload';

        /* Get account info from db */
        $user_info = get_db_info($db, get_user_id(), 'u');
        $user_id = get_user_id();

        /* Page info */
        $root = '/DDWT18/';
        $page_title = 'My Account';
        $page_subtitle = 'An overview of your account';
        $form_action = '/DDWT18/myaccount/edit';
        $submit_btn = 'Edit';
        include use_template('user_edit');

    });

    /* Edit user account POST */
    $router->post('/edit', function() use ($db, $navigation_tpl, $root) {

        /* Get user info from db */
        $user_id = $_POST['user_id'];
        $user_info = get_db_info($db, $user_id, 'u');

        /* Update user in database */
        $feedback = update_user($db, $_POST);

        /* Redirect */
        if ($feedback['type'] == 'success'){
            redirect(sprintf('/DDWT18/myaccount/?msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/myaccount/edit/?msg=%s', json_encode($feedback)));
        }

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

        /* Upload avatar */
        $feedback = upload_avatar(get_user_id(), $target_dir);

        /* Redirect */
        if ($feedback['type'] == 'success'){
            redirect(sprintf('/DDWT18/myaccount/?msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/myaccount/edit/?msg=%s', json_encode($feedback)));
        }

    });

    /* Delete user account POST */
    $router->post('/remove', function() use ($db, $navigation_tpl, $root) {
        $user_id = get_user_id();
        $feedback = delete_account($db, $user_id);

        /* Redirect */
        if ($feedback['type'] == 'success'){
            redirect(sprintf('/DDWT18/?msg=%s', json_encode($feedback)));
        } else {
            redirect(sprintf('/DDWT18/myaccount/delete/?msg=%s', json_encode($feedback)));
        }

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

