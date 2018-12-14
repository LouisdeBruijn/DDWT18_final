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
        'url' => '/DDWT18/final/' ),
    2 => Array(
        'name' => 'Overview',
        'url' => '/DDWT18/final/overview/' ),
    3 => Array(
        'name' => 'Login',
        'url' => '/DDWT18/final/login/' ),
    4 => Array(
        'name' => 'Register',
        'url' => '/DDWT18/final/register/'),
    5 => Array(
        'name' => 'My Account',
        'url' => '/DDWT18/final/myaccount/'),
    6 => Array(
        'name' => 'Add room',
        'url' => '/DDWT18/final/add/',
    ));

/* Home GET */
$router->get('/home', function() use($db, $navigation_tpl) {

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
$router->get('/overview', function() use ($db) {
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

    /* Choose Template */
    include use_template('main');

});

/* Single room GET */
$router->get('/room', function() use ($db) {
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

/* Login GET */
$router->get('/login', function() use ($db) {
    /* Page info */
    $page_title = 'Login';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 3);

    /* Choose Template */
    include use_template('login');


});

/* Login POST */
$router->post('/login', function() use ($db) {
    /* Login user */
    $error_msg = login_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/login/?error_msg=%s', json_encode($error_msg)));

});

/* Logout GET */
$router->get('/logout', function() use ($db) {
    /* Logout user */
    $error_msg = logout_user();

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/?error_msg=%s',
        json_encode($error_msg)));

});

/* Register GET */
$router->get('/register', function() use ($db) {
    /* Page info */
    $page_title = 'Register';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 4);

    /* Choose Template */
    include use_template('register');


});

/* Register POST */
$router->post('/register', function() use ($db) {
    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/register/?error_msg=%s', json_encode($error_msg)));

});

/* Account GET */
$router->get('/myaccount', function() use ($db) {
    /* Check login */
    check_login();

    /* User first name and last name */
    $name = get_username($db, get_user_id());
    # Hier nog met een if statement kijken of er get_username() uitkomt en anders user_name uit de db tonen

    /* Page info */
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
$router->post('/myaccount', function() use ($db) {

});

/* Add serie GET */
$router->get('/add', function() use ($db) {
    /* Get counter for usage of Postcode API */
    $count = counter($db);

    /* Page info */
    $page_title = 'Add Room';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 6);

    /* Page content */
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week2/add/';


    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('new-step1');

});

/* Add serie POST */
$router->post('/add', function() use ($db) {

    if(isset($_POST['postalcode']) and isset($_POST['streetnumber'])
        and isset($_POST['street']) and isset($_POST['city'])){
        // Process step 2
        echo 'waarom doet ie het niet';
    }
    else if(isset($_POST['postalcode']) and isset($_POST['streetnumber'])){
        $postcode_data = postcode($db, $_POST);
        if(isset($postcode_data['postalcode']) and isset($postcode_data['streetnumber'])){
            /* Get counter for usage of Postcode API */
            $count = counter($db);

            /* Page info */
            $page_title = 'Add Room';

            /* Navigation */
            $navigation = get_navigation($navigation_tpl, 6);

            /* Page content */
            $page_subtitle = 'Add your favorite series';
            $page_content = 'Fill in the details of you favorite series.';
            $submit_btn = "Add Series";
            $form_action = '/DDWT18/week2/add/';

            $postalcode = $_POST['postalcode'];
            $streetnumber = $_POST['streetnumber'];
            $city = $_POST['city'];
            $street = $_POST['street'];

            include use_template('new-step2');
        }
        else {
            /* Redirect to serie GET route with error_msg */
            redirect(sprintf('/DDWT18/final/add/?error_msg=%s', json_encode($postcode_data)));
        }
    }
    else {
        /* Redirect to serie GET route with error_msg */
        $error_msg = []; #hier moet nog wat gebeuren
        redirect(sprintf('/DDWT18/final/add/?error_msg=%s', json_encode($error_msg)));
    }

});

/* Edit user account GET */
$router->get('/edit', function() use ($db) {
    /* Get user account information from db */
    check_login();
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
    include use_template('account');

});

/* Edit user account GET */
$router->post('/edit', function() use ($db) {
    #we moeten deze nog doen!!!!!!!

});


    /* Add routes here */
$router->mount('add', function() use ($router, $db) {



});

$router->set404(function() {
    // will result in an error message on page 404
    header('HTTP/1.1 404 Not Found');
    http_response_code(404);
    echo 'Error: HTTP/1.1 404 Not Found';
});

/* Run the router */
$router->run();

