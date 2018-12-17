<?php

/**
 * Model
 * User: louis_de_bruijn
 * Date: 05-12-18
 * Time: 17:45
 */

/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Connects to the database using PDO
 * @param string $host database host
 * @param string $db database name
 * @param string $user database user
 * @param string $pass database password
 * @return pdo object
 */
function connect_db($host, $db, $user, $pass){
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo sprintf("Failed to connect. %s",$e->getMessage());
    }
    return $pdo;
}

/**
 * Check if the route exist
 * @param string $route_uri URI to be matched
 * @param string $request_type request method
 * @return bool
 *
 */
function new_route($route_uri, $request_type){
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/',parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    }
}

/**
 * Creates filename to the template
 * @param string $template filename of the template without extension
 * @return string
 */
function use_template($template){
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($template, $active_id){
    $navigation_exp = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">Rooms Overview</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $id => $info) {
        if ($id == $active_id) {
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="' . $info['url'] . '">' . $info['name'] . '</a>';
        } else {
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="' . $info['url'] . '">' . $info['name'] . '</a>';
        }

        $navigation_exp .= '</li>';

    }
    $navigation_exp .= '
    </ul>
    <a href="/DDWT18/logout/" class="btn btn-primary">Logout</a>
    </div>
    </nav>';
    return $navigation_exp;
}


/**
 * Changes the HTTP Header to a given location
 * @param string $location location to be redirected to
 */
function redirect($location){
    header(sprintf('Location: %s', $location));
    die();
}

/**
 * Function to check whether the required params is exists in the array or not.
 * @param string $requiredFields required form fields
 * @param string $form_data fields from form to be submitted
 */
function check_required_fields($required_fields, $form_data) {
    $missing_fields = [];
    // Loop over the required fields and check whether the value is exist or not in the request params.
    foreach ($required_fields as $field) {
        if (empty($form_data[$field])) {
            array_push($missing_fields, $field);
        }
    }
    $missing_fields = implode(', ', $missing_fields);
    return $missing_fields;
}


/**
 * Register the user
 * @param object $pdo database object
 * @param object $form_data filled in user-data
 */
function register_user($pdo, $form_data){

    /* Form validation */
    $required_fields = ['username', 'password', 'firstname', 'lastname', 'role', 'birthdate', 'biography', 'occupation', 'language', 'email', 'phone'];
    $missing_fields = check_required_fields($required_fields, $form_data);

    if ($missing_fields) {
        return [
            'type' => 'danger',
            'message' => 'The following fields are mandatory: ', $missing_fields
        ];
    }

    /* Check if user already exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_exists = $stmt->rowCount();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }

    /* Return error message for existing username */
    if ( !empty($user_exists) ) {
        return [
            'type' => 'danger',
            'message' => 'The username you entered does already exists!'
        ];
    }

    /* Hash password */
    $password = password_hash($form_data['password'], PASSWORD_DEFAULT);

    /* Save user to the database */
    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, password, firstname, lastname, role, birthdate, biography, occupation, language, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$form_data['username'], $password, $form_data['firstname'], $form_data['lastname'], $form_data['role'], $form_data['birthdate'], $form_data['biography'], $form_data['occupation'], $form_data['language'], $form_data['email'], $form_data['phone']]);
        $user_id = $pdo->lastInsertId();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }

    /* Login user and redirect */
    session_start();
    $_SESSION['user_id'] = $user_id;
    $feedback = [
        'type' => 'success',
        'message' => sprintf('%s, your account was successfully created!', get_username($pdo, $_SESSION['user_id']))
    ];
    redirect(sprintf('/DDWT18/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/**
 * Log the user in
 * @param object $pdo database
 * @param object $form_data filled in user-data
 */
function login_user($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username and password.'
        ];
    }

    /* Check if user exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_info = $stmt->fetch();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }

    /* Return error message for wrong username */
    if (empty($user_info)) {
        return [
            'type' => 'danger',
            'message' => 'The username you entered does not exist!'
        ];
    }
    /* Check password */
    if ( !password_verify($form_data['password'], $user_info['password']) ){
        return [
            'type' => 'danger',
            'message' => 'The password you entered is incorrect!'
        ];
    } else {
        session_start();
        $_SESSION['user_id'] = $user_info['id'];
        $feedback = [
            'type' => 'success',
            'message' => sprintf('%s, you were logged in successfully!',
                get_username($pdo, $_SESSION['user_id']))
        ];
        redirect(sprintf('/DDWT18/myaccount/?error_msg=%s',
            json_encode($feedback)));
    }
}

/**
 * Get current user id
 * @return bool current user id or False if not logged in
 */
function get_user_id(){
    if (isset($_SESSION['user_id'])){
        return $_SESSION['user_id'];
    } else {
        return False;
    }
}

/**
 * Get the name of the user based on a specific user_id
 * @param object $pdo database object, object $user_id user_id
 * @return Array with first name and last name of user_id
 */
function get_username($pdo, $user_id){
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user_info = $stmt->fetch();

    return $user_info['firstname'].' '.$user_info['lastname'];
}

/**
 * Check whether the user is logged in
 * @return boolean
 */
function check_login(){
    session_start();
    if (isset($_SESSION['user_id'])){
        return True;
    } else {
        return False;
    }
}

/**
 * Generates an array with account information
 * @param object $pdo db object
 * @param int $user_id id of the user
 * @return mixed
 */
function get_account_info($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user_info = $stmt->fetch();
    $user_info_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($user_info as $key => $value){
        $user_info_exp[$key] = htmlspecialchars($value);
    }
    return $user_info_exp;
}


/**
 * Logs the user out of their session
 * @return array
 */
function logout_user(){
    session_start();
    if (session_destroy()) {
        return [
            'type' => 'success',
            'message' => 'You were logged out successfully!'
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'You were not logged out successfully!'

        ];
    }
}

/**
 * Creats HTML alert code with information about the success or failure
 * @param bool $type True if success, False if failure
 * @param string $message Error/Success message
 * @return string
 */
function get_error($feedback){
    $feedback = json_decode($feedback, True);
    $error_exp = '
        <div class="alert alert-'.$feedback['type'].'" role="alert">
            '.$feedback['message'].'
        </div>';
    return $error_exp;
}


/**
 * returns an array with all the rooms in de database
 * @param $pdo
 * @return array
 */

function get_rooms($pdo){
    $stmt = $pdo->prepare('SELECT * FROM rooms');
    $stmt->execute();
    $rooms = $stmt->fetchAll();
    $rooms_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input){
            $rooms_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $rooms_exp;
}

/**
 * returns a table of all the rooms. Their names (description) and their owner names are showed.
 * Returns a string with the HTML code representing the table with all the series
 * @param $series_info_exp All the information for each series
 * @return string The series table
 *
 */
function get_rooms_table($pdo, $rooms){
    $rooms_table = '
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Rooms</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';
    foreach ($rooms as $key => $value){
        $rooms_table .= '
        <tr>
            <th scope="row">'.$value['name'].'</th>
            <th scope="row">'.get_owner_name($pdo, $value['owner']).'</th>
            <td><a href="/DDWT18/room/?room_id='.$value['id'].'" role="button" class="btn btn-primary">More info</a></td>
        </tr>';
    }
    $rooms_table .= '
        </tbody>
    </table>';
    return $rooms_table;
}

function get_rooms_card($rooms, $user_id) {

        var_dump($rooms);
    if ($user_id == $rooms[0]['owner'] ) {
        foreach ($rooms as $key => $value) {
            $rooms_card = '
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">' . $value['name'] . '</h5>
                        <p class="card-text">' . $value['description'] . '</p>
                        <a href="/DDWT18/room/?room_id=' . $value['id'] . '" role="button" class="btn btn-primary">More info</a>
                    </div>
                </div>';

            return $rooms_card;
        }
    }
}

/**
 * Returns a string with the HTML code representing the information for that series
 * @param PDO $pdo The database connection
 * @return string The series table
 *
 */
function get_room_info($pdo, $room_id){
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
    $stmt->execute([$room_id]);
    $room_info = $stmt->fetch();

    /* Create array with htmlspecialchars */
    foreach ($room_info as $row => $rowcontent){
        $room_info_exp[$row] = htmlspecialchars($rowcontent);
    }
    return $room_info_exp;
}


function get_owner_name($pdo, $owner_id){ #deze functie is ook hetzelfde als get_user_name en kan dus samengevoegd worden (enige verschil is de select query welke DB)?
    $stmt = $pdo->prepare('SELECT firstname,lastname FROM users WHERE id = ?');
    $stmt->execute([$owner_id]);
    $owner_info = $stmt->fetch();
    $owner_info_exp = Array();

    foreach ($owner_info as $key => $value){
        $owner_info_exp[$key] = htmlspecialchars($value);
    }
    return $owner_info['firstname'].' '.$owner_info['lastname'];
}


/**
 * Makes use of the Postcode API to fill in the city and street address
 */
function postcode($pdo, $form_data){
    // Validate form submission
    if (
        empty($form_data['postalcode']) or
        empty($form_data['streetnumber'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a postal code and a streetnumber.'
        ];
    }

    // Fetch count from postcode db
    $count = count_postcode($pdo);


    if ( $count < 100 ){

        // Form variables and date
        $postalcode = $form_data['postalcode'];
        $streetnumber = $form_data['streetnumber'];
        date_default_timezone_set("Europe/Amsterdam");
        $date = date("Y-m-d");

        // De headers worden altijd meegestuurd als array
        $headers = array();
        $headers[] = 'X-Api-Key: WmTqvoFo9P6UbjqGGVwBvqrVPsbM6b9aShiwhMji';

        // De URL naar de API call
        $url = 'https://api.postcodeapi.nu/v2/addresses/?postcode='.$postalcode.'&number='.$streetnumber;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        // De ruwe JSON response
        $response = curl_exec($curl);

        // Gebruik json_decode() om de response naar een PHP array te converteren
        $data = json_decode($response, true);
        curl_close($curl);

        var_dump($data); #hoe roep je deze key aan en zorg je dat ie dan stopt.

        if (array_key_exists("error", $data)) {
            return [
                'type' => 'danger',
                'message' => 'There was an error.'
            ];
        } else {
            // Fetch city and street from API data
            $city = $data['_embedded']['addresses'][0]['city']['label'];
            $street = $data['_embedded']['addresses'][0]['street'];

            // Associative Array
            $arr = array('postalcode' => $postalcode, 'streetnumber' => $streetnumber, 'city' => $city, 'street' => $street);
            return $arr;
        }


        // Add Postcode API record to DB
        $stmt = $pdo->prepare('INSERT INTO postcode (postalcode, streetnumber, city, street, date) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$postalcode, $streetnumber, $city, $street, $date]);

    } else {
        return [
            'type' => 'danger',
            'message' => 'You have reached the maximum number of API calls.'
        ];
    }
}

/**
 * Add serie to the database
 * @param object $pdo db object
 * @param array $serie_info post array
 * @return array with message feedback
 */
function add_room($pdo, $room_info, $user_id){
    /* Check if all fields are set */
    $required_fields = ['postalcode', 'streetnumber', 'city', 'street', 'name', 'type', 'price', 'size', 'description'];
    $missing_fields = check_required_fields($required_fields, $room_info);

    if ($missing_fields) {
        return [
            'type' => 'danger',
            'message' => 'The following fields are mandatory: ', $missing_fields
        ];
    }

    /* Check data type */
    if (!is_numeric($room_info['streetnumber'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number as streetnumber.'
        ];
    }

    /* Check if room already exists */
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE postalcode = ? AND streetnumber = ? AND city = ? AND street = ?');
    $stmt->execute([$room_info['postalcode'], $room_info['streetnumber'], $room_info['city'], $room_info['street']]);
    $room = $stmt->rowCount();
    if ($room){
        return [
            'type' => 'danger',
            'message' => 'This room was already added.'
        ];
    }

    /* Add room */
    $stmt = $pdo->prepare("INSERT INTO rooms (owner, name, description, street, streetnumber, postalcode, city, type, price, size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $room_info['name'],
        $room_info['description'],
        $room_info['street'],
        $room_info['streetnumber'],
        $room_info['postalcode'],
        $room_info['city'],
        $room_info['type'],
        $room_info['price'],
        $room_info['size'],
    ]);

    var_dump($room_info);
    $inserted = $stmt->rowCount();
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room '%s' added to Rooms Overview.", $room_info['name'])
        ];
    }
    else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }
}

/**
 * Count the number of Postcode API calls per day
 * @param object $pdo database object
 * @return mixed
 */
function count_postcode($pdo){
    /* Count the number of Postcode API calls per day*/
    date_default_timezone_set("Europe/Amsterdam");
    $date = date("Y-m-d");
    $stmt = $pdo->prepare('SELECT * FROM postcode WHERE date = ?');
    $stmt->execute([$date]);
    $count = $stmt->rowCount();
    return $count;
}


/**
 * Count the number of rooms listed on rooms Overview
 * @param object $pdo database object
 * @return mixed
 */
function count_rooms($pdo){
    /* Get rooms */
    $stmt = $pdo->prepare('SELECT * FROM rooms');
    $stmt->execute();
    $rooms = $stmt->rowCount();
    return $rooms;
}

/**
 * @param $pdo
 * @param $user_info
 * @param $user_id
 * @return array
 */
function update_user($pdo, $user_info, $user_id){
    /* Check if all fields are set */
    if (
        empty($user_info['firstname']) or
        empty($user_info['lastname']) or
        empty($user_info['birthdate']) or
        empty($user_info['biography']) or
        empty($user_info['occupation']) or
        empty($user_info['language']) or
        empty($user_info['email']) or
        empty($user_info['phone'])
    ){
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }
    /* Get current email */
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    $current_email = $user['email'];
    /* Check if email already exists */
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$user_info['email']]);
    $user = $stmt->fetch();
    if ($user_info['email'] == $user['email'] and $user['email'] != $current_email) {
        return [
            'type' => 'danger',
            'message' => 'This email is already used for an account.'
        ];
    }
    /* Update user */
    $stmt = $pdo->prepare('UPDATE users SET firstname = ?, lastname  = ?, birthdate = ?, biography = ?, occupation = ?, language = ?, email = ?, phone = ?');
    $stmt->execute([
        $user_info['firstname'],
        $user_info['lastname'],
        $user_info['birthdate'],
        $user_info['biography'],
        $user_info['occupation'],
        $user_info['language'],
        $user_info['email'],
        $user_info['phone'],
        $user_id
    ]);
    $updated = $stmt->rowCount();
    if ($updated == 1) {
        return [
            'type' => 'success',
            'message' => 'Your useraccount was updated.'
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'Your useraccount was not updated, no changes were detected.'
        ];
    }
}



