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

    /* Page info */
    $page_title = 'Home';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 1);

    /* Page content */

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');


});

/* Overview GET */
$router->get('/overview', function() use ($db, $navigation_tpl, $root) {
    /* Get rooms from db */
    $rooms = get_rooms($db);

    /* Page info */
    $page_title = 'Overview';
    $page_subtitle = 'Rooms in Groningen';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 2);

    /* Page content */
    $page_content = 'An overview of available rooms in Groningen';
    $left_content = get_rooms_table($db, $rooms);
    $nbr_rooms = count_rooms($db);

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');

});

/* Single room mount */
$router->mount('/room', function() use ($router, $db, $navigation_tpl, $root) { #waarom moet ik bij elke route weer opnieuw deze variabelen aanroepen


    /* Single room GET */
    $router->get('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if user is logged in */
        check_login();

        /* Get room_id from $_GET variables */
        $room_id = $_GET['room_id'];

        /* Check whether $_GET variables are set */
        if (check_url_var($room_id)){
            redirect('/DDWT18/overview/');
        }

        /* Display buttons */
        $display_buttons = display_buttons($db, get_user_id(), $room_id);

        /* get room info from database */
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

        /* page content */
        include use_template('room');

    });

    /* Single room REMOVE */
    $router->post('/remove', function() use ($router, $db, $navigation_tpl, $root) { #kan dit ook op een delete route??
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        var_dump($_POST);
        /* Remove room from database */
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

        /* Page info */
        $page_title = 'Edit Room';
        $page_subtitle = 'Edit your room';

        /* Page content */
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Edit room";
        $form_action = '/DDWT18/room/edit';


        #deze code kan redundant worden door de functie uit account cards !
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

        /* Get error msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

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
        var_dump($target_dir);
        $feedback = upload_file(get_user_id(), $target_dir);

    });



    /* Edit single room POST */
    $router->post('/edit', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        #moet je op de post route ook checken of room_id wel gezet is in de GET variabelen met check_url_var?? Kunnen mensen bij een post route komen?

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
    /* Page info */
    $page_title = 'Login';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 3);

    /* Choose Template */
    include use_template('login');


});

/* Login POST */
$router->post('/login', function() use ($db, $navigation_tpl, $root) {
    /* Login user */
    $error_msg = login_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/login/?error_msg=%s', json_encode($error_msg)));

});

/* Logout GET */
$router->get('/logout', function() use ($db) {
    /* Logout user */
    $error_msg = logout_user();

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/?error_msg=%s',
        json_encode($error_msg)));

});

/* Register GET */
$router->get('/register', function() use ($db, $navigation_tpl, $root) {
    /* Page info */
    $page_title = 'Register';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 4);

    /* Choose Template */
    include use_template('register');

});

/* Register POST */
$router->post('/register', function() use ($db, $navigation_tpl, $root) {

    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/register/?error_msg=%s', json_encode($error_msg)));

});

/* Account GET */
$router->get('/myaccount', function() use ($db, $navigation_tpl, $root) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/login/');
    }

    /* Get rooms from db */
    $rooms = get_rooms($db);
    $rooms_cards = get_rooms_card($rooms, get_user_id());

    /* Avatar image */
    $avatar = check_avatar(get_user_id());

    /* User first name and last name */
    $name = get_username($db, get_user_id());

    /* Page info */
    $root = '/DDWT18/';
    $page_title = 'My Account';
    $page_subtitle = 'Edit your account here';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 5);

    /* Page content */
    $page_content = 'An overview of your account ';

    /* Get account info from db */
    $user_info = get_account_info($db, get_user_id()); #deze functie is PRECIES hetzelfde als get_serieinfo() en is dus redundant, maar nu voor nu voldoet het even. We kunnen later get_serieinfo() herschrijven zodat we die ook hier kunnen gebruiken.

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('account');

});

/* Account POST */
$router->post('/myaccount', function() use ($db, $navigation_tpl, $root) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/login/');
    }

});


/* Add room mount */
$router->mount('/add', function() use ($router, $db, $navigation_tpl, $root) { #waarom moet ik bij elke route weer opnieuw deze variabelen aanroepen

    /* Add room GET */
    $router->get('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Page info */
        $page_title = 'Add Room';

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Page content */
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Continue";
        $form_action = '/DDWT18/add/';

        /* Get error msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Choose Template */
        include use_template('new-step1');

    });

    /* Add room POST-step1 */
    $router->post('/', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Call postcode API */
        $postcode_data = postcode($db, $_POST);

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Page info */
        $page_title = 'Add Room';

        /* Get error msg from POST route */
        if ( isset($_GET['error_msg']) ) {
            $error_msg = get_error($_GET['error_msg']);
        }

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Page content */
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';
        $submit_btn = "Add room";
        $form_action = '/DDWT18/add/next';

        $postalcode = $_POST['postalcode'];
        $streetnumber = $_POST['streetnumber'];
        $city = $postcode_data['city'];
        $street = $postcode_data['street'];

        include use_template('new-step2');

    });

    /* Add room POST-step2 */
    $router->post('/next', function() use ($router, $db, $navigation_tpl, $root) {
        /* Check if logged in */
        if ( !check_login() ) {
            redirect('/DDWT18/login/');
        }

        /* Get counter for usage of Postcode API */
        $count = count_postcode($db);

        /* Page info */
        $page_title = 'Add Room';

        /* Navigation */
        $navigation = get_navigation($navigation_tpl, 6);

        /* Page content */
        $page_subtitle = 'Add your room';
        $page_content = 'Fill in the details of your room.';

        /* Add serie to database */
        $feedback = add_room($db, $_POST, get_user_id());;

        # hoe maak je nou dat de $feedback doormoet naar de overview pagina maar de #error message naar dezelfde add/room pagina. ????

        /* Redirect to serie GET route */
        redirect(sprintf('/DDWT18/overview/?error_msg=%s', json_encode($feedback)));

    });
});


/* Edit user account GET */
$router->get('/edit', function() use ($db, $navigation_tpl, $root) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/login/');
    }

    /* Avatar image */
    $avatar = check_avatar(get_user_id());

    /* User first name and last name */
    $name = get_username($db, get_user_id());

    /* Page info */
    $root = '/DDWT18/';
    $page_title = 'My Account';
    $page_subtitle = 'Edit your account here';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 5);

    /* Page content */
    $page_content = 'An overview of your account';

    /* Change avatar */
    $form_action = '/DDWT18/edit/';
    $submit_btn = 'Upload';

    /* Get account info from db */
    $user_info = get_account_info($db, get_user_id()); #deze functie is PRECIES hetzelfde als get_serieinfo() en is dus redundant, maar nu voor nu voldoet het even. We kunnen later get_serieinfo() herschrijven zodat we die ook hier kunnen gebruiken.

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('user_edit');

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/myaccount?error_msg=%s',
        json_encode($error_msg)));


});

/* Edit user account POST */
$router->post('/edit', function() use ($db, $navigation_tpl, $root) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/login/');
    }

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    $directory_name = "images/users/uploads";
    $target_dir = create_directory($directory_name, get_user_id(), 'avatar');

    $feedback = upload_file(get_user_id(), $target_dir);

    var_dump($feedback);

    /* Update user in database */
    $feedback = update_user($db, $_POST);
    $error_msg = get_error($feedback);

    /* Get serie info from db */
    $user_id = $_POST['user_id'];
    $user_info = get_account_info($db, $user_id);

    /* Get user account information from db */
    $navigation = get_navigation($navigation_tpl, 5);
    $name = get_username($db, get_user_id());
    $page_title = 'edit account';
    $page_subtitle = 'edit here your personal account';
    #$page_content = '';
    #$user_id = $_GET['user_id'];
    #$user_info = get_account_info($db, $user_id);
    #$user_firstname = $user_info['firstname'];
    #$user_lastname = $user_info['lastname'];
    #$user_birthdate = $user_info['birthdate']; #je kan niet veranderen van tenant of owner dus die hebben we er niet in
    #$user_biography = $user_info['biography'];
    #$user_occupation = $user_info['occupation'];
    #$user_language = $user_info['language'];
    #$user_email = $user_info['email'];
    #$user_phone = $user_info['phone'];


    /* Choose Template */
    include use_template('account');

    #we moeten deze nog doen!!!!!!!

});


$router->set404(function() {
    // will result in an error message on page 404
    header('HTTP/1.1 404 Not Found');
    http_response_code(404);
    echo 'Error: HTTP/1.1 404 Not Found';
});

/* Run the router */
$router->run();

