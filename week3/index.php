<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week3', 'ddwt18', 'ddwt18');

// Set credentials for authentication
$cred = set_cred('ddwt18', 'ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

/* Validate the credentials */
$router->before('GET|POST|PUT|DELETE', '/api/.*', function() use($cred){
    // Validate authentication
     if (check_cred($cred) == False) {
        $feedback = [
            'type' => 'danger',
            'message' => 'Your credentials (username and password) are incorrect.'
        ];
        echo json_encode($feedback);
        exit();
    }
});

// Add routes here

$router->mount('/api', function() use ($router, $db) {
    // Browser recognizes that our database arrays are json
    http_content_type('application/json');

    // will result in '/api'
    $router->get('/', function() use($db) {
        echo 'APi test';
    });

    /* GET for all series */
    $router->get('/series', function() use ($db) {
        // All series from db
        $feedback =  get_series($db);
        echo json_encode($feedback);
    });

    /* POST for adding series */
    $router->post('/series', function() use ($db) {
        // Add a serie to the db
        $feedback = add_serie($db, $_POST);
        echo json_encode($feedback);
    });


    /* GET for reading individual series */
    $router->get('/series/(\d+)', function($id) use($db) {
        // Retrieve and output information of an individual series
        $feedback = get_serieinfo($db, $id);
        echo json_encode($feedback);
    });

    /* DELETE for reading individual series */
    $router->delete('/series/(\d+)', function($id) use($db) {
        // delete series according to series_id
        $feedback = remove_series($db, $id);
        echo json_encode($feedback);
    });

    /* PUT for reading individual series */
    $router->put('/series/(\d+)', function($id) use($db) {
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);

        // $serie_info is a paramete for update_serie(), included in it $_PUT and the $id
        $serie_info = $_PUT + ["serie_id" => $id];

        // Update the information of an individual series
        $feedback = update_serie($db, $serie_info);
        echo json_encode($feedback);
    });


});

$router->set404(function() {
    // will result in an error message on page 404
    header('HTTP/1.1 404 Not Found');
    echo 'HTTP/1.1 404 Not Found';
});

/* Run the router */
$router->run();
