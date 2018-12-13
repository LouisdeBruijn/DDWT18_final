<?php
/**
 * Controller
 * User: louis_de_bruijn
 * Date: 05-12-18
 * Time: 17:45
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_final', 'ddwt18','ddwt18');

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


/* Landing page */
if (new_route('/DDWT18/final/', 'get')) {

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

}

/* Overview page */
elseif (new_route('/DDWT18/final/overview/', 'get')) {
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
}

/* single room info */
elseif (new_route('/DDWT18/final/room/', 'get')) {
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
}

/*  Login GET route */
elseif (new_route('/DDWT18/final/login/', 'get')) {

    /* Page info */
    $page_title = 'Login';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 3);

    /* Choose Template */
    include use_template('login');

}

/*  Login POST route */
elseif (new_route('/DDWT18/final/login/', 'post')) {
    /* Login user */
    $error_msg = login_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/login/?error_msg=%s', json_encode($error_msg)));
}

/*  Register GET route */
elseif (new_route('/DDWT18/final/register/', 'get')) {

    /* Page info */
    $page_title = 'Register';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 4);

    /* Choose Template */
    include use_template('register');

}

/*  Register POST route */
elseif (new_route('/DDWT18/final/register/', 'post')) {
    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/register/?error_msg=%s', json_encode($error_msg)));
}

/*  Logout GET route */
elseif (new_route('/DDWT18/final/logout/', 'get')){
    /* Logout user */
    $error_msg = logout_user();

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/final/?error_msg=%s',
        json_encode($error_msg)));
}

/* Account GET route  */
elseif (new_route('/DDWT18/final/myaccount/', 'get')) {
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
}

/* Add serie GET */
elseif (new_route('/DDWT18/final/add/', 'get')) {
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
}

/* Add serie POST */
elseif (new_route('/DDWT18/final/add/', 'post')) {

    if(isset($output['postalcode']) and isset($output['streetnumber'])
        and isset($output['street']) and isset($output['city'])){
        // Process step 2
        echo 'waarom doet ie het niet';
    }
    else if(isset($output['postalcode']) and isset($output['streetnumber'])){
        $output = postcode($db, $_POST);
        if(isset($output['postalcode']) and isset($output['streetnumber'])){
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
            redirect(sprintf('/DDWT18/final/add/?error_msg=%s', json_encode($output)));
        }
    }
    else {
        /* Redirect to serie GET route with error_msg */
        $error_msg = []; #hier moet nog wat gebeuren
        redirect(sprintf('/DDWT18/final/add/?error_msg=%s', json_encode($error_msg)));
    }

}

else {
    http_response_code(404);
}


