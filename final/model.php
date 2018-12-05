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
 * Register the user
 * @param object $pdo database object $form_data filled in user-data
 */
function register_user($pdo, $form_data){
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password']) or
        empty($form_data['firstname']) or
        empty($form_data['lastname'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username, password, first- and last name.'
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
        $stmt = $pdo->prepare('INSERT INTO users (username, password, firstname, lastname) VALUES (?, ?, ?, ?)');
        $stmt->execute([$form_data['username'], $password, $form_data['firstname'], $form_data['lastname']]);
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
    redirect(sprintf('/DDWT18/week2/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/**
 * Log the user in
 * @param object $pdo database object $form_data filled in user-data
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
        redirect(sprintf('/DDWT18/week2/myaccount/?error_msg=%s',
            json_encode($feedback)));
    }
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
 * Logs the user out of their session
 * @return Array
 */
function logout_user(){
    session_start();
    if( session_destroy()){
        return [
            'type' => 'success',
            'message' => 'You were logged out successfully!'
        ];
    }
    else{
        return [
            'type' => 'danger',
            'message' => 'You were not logged out successfully!'

        ];
    }
}
