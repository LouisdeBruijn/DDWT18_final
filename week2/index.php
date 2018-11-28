<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week2', 'ddwt18','ddwt18');

/* Redundant code */
    /* Get Number of Series */
    $nbr_series = count_series($db);
    /* Page Content */
    $right_column = use_template('cards');
    /* Count the number of active Users */
    $nbr_users = count_users($db);


/* Navigation */
$navigation_tpl = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT18/week2/' ),
    2 => Array(
        'name' => 'Overview',
        'url' => '/DDWT18/week2/overview/'),
    5 => Array(
        'name' => 'Add',
        'url' => '/DDWT18/week2/add/'),
    3 => Array(
        'name' => 'My Account',
        'url' => '/DDWT18/week2/myaccount/' ),
    4 => Array(
        'name' => 'Register',
        'url' => '/DDWT18/week2/register/'),
    6 => Array(
    'name' => 'Login',
    'url' => '/DDWT18/week2/login/'
    ));

/* Landing page */
if (new_route('/DDWT18/week2/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Home' => na('/DDWT18/week2/', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 1);

    /* Page content */
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week2/overview/', 'get')) {

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 2);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table($db, get_series($db));

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week2/serie/', 'get')) {

    /* Get series from db */
    $serie_id = $_GET['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);
    $added_by = get_username($db, $serie_info['user']);
    if ($serie_info['user'] == get_user_id() ) {
        $display_buttons;
    }

    /* Page info */
    $page_title = $serie_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview/', False),
        $serie_info['name'] => na('/DDWT18/week2/serie/?serie_id='.$serie_id, True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 6);

    /* Page content */
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week2/add/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Add Series' => na('/DDWT18/week2/new/', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 5);

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
    include use_template('new');
}

/* Add serie POST */
elseif (new_route('/DDWT18/week2/add/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    /* Add serie to database */
    $feedback = add_serie($db, $_POST, get_user_id());

    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18/week2/add/?error_msg=%s', json_encode($feedback)));
}

/* Edit serie GET */
elseif (new_route('/DDWT18/week2/edit/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    /* Get serie info from db */
    $serie_id = $_GET['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        sprintf("Edit Series %s", $serie_info['name']) => na('/DDWT18/week2/new/', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 5);

    /* Page content */
    $page_subtitle = sprintf("Edit %s", $serie_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week2/edit/';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week2/edit/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    /* Edit serie to database */
    $feedback = update_serie($db, $_POST, get_user_id());

    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18/week2/serie/?error_msg=%s', json_encode($feedback)));
}

/* Remove serie GET */
elseif (new_route('/DDWT18/week2/remove/', 'get')) {

    /* Get serie info from db */
    $serie_id = $_GET['serie_id'];
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        sprintf("Edit Series %s", $serie_info['name']) => na('/DDWT18/week2/new/', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 2);

    /* Page content */
    $page_subtitle = sprintf("Edit %s", $serie_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week2/edit/';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('new');
}

/* Remove serie POST */
elseif (new_route('/DDWT18/week2/remove/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    /* Remove serie to database */
    $feedback = remove_serie($db, $_POST, get_user_id());

    /* Redirect to serie GET route */
    redirect(sprintf('/DDWT18/week2/overview/?error_msg=%s', json_encode($feedback)));

    /* Remove serie in database */
    $feedback = remove_serie($db, $serie_id);
    $error_msg = get_error($feedback);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 2);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table($db, get_series($db));

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');
}

/*  My account GET route */
elseif (new_route('/DDWT18/week2/myaccount/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/week2/login/');
    }

    $page_title = 'My account';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'My account' => na('/DDWT18/week2/myaccount', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 3);

    /* Page content */
    $page_subtitle = 'Your personal account';
    $page_content = 'Here you can find all your personal information.';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('account');
}

/*  Register GET route */
elseif (new_route('/DDWT18/week2/register/', 'get')) {
    $page_title = 'Registration';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Register' => na('/DDWT18/week2/register', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 4);

    /* Page content */
    $page_subtitle = 'Register here!';
    $page_content = 'Here you can join our community.';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('register');
}

/*  Register POST route */
elseif (new_route('/DDWT18/week2/register/', 'post')) {
    /* Register user */
    $error_msg = register_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/week2/register/?error_msg=%s', json_encode($error_msg)));
}

/*  Login GET route */
elseif (new_route('/DDWT18/week2/login/', 'get')) {
    /* Check if logged in */
    if ( check_login() ) {
        redirect('/DDWT18/week2/myaccount/');
    }
    $page_title = 'Login';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Login' => na('/DDWT18/week2/login', True)
    ]);

    /* Navigation */
    $navigation = get_navigation($navigation_tpl, 6);

    /* Page content */
    $page_subtitle = 'Use your username and password to login';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('login');

}

/*  Login POST route */
elseif (new_route('/DDWT18/week2/login/', 'post')){
    /* Login user */
    $feedback = login_user($db, $_POST);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/week2/login/?error_msg=%s',
        json_encode($feedback)));
}

/*  Logout GET route */
elseif (new_route('/DDWT18/week2/logout/', 'get')){
    /* Logout user */
    $feedback = logout_user();

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/week2/?error_msg=%s',
        json_encode($feedback)));
}


else {
    http_response_code(404);
}