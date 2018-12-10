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
        'url' => '/DDWT18/final/register/'
    ));

/* Landing page */
if (new_route('/DDWT18/final/', 'get')) {

    /* Page info */
    $page_title = 'Home';

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 1);

    /* Page content */

    /* Choose Template */
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
    $left_content = get_rooms_table($rooms);

    /* Choose Template */
    include use_template('main');
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



else {
    http_response_code(404);
}

