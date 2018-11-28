<?php
/**
 * Model
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/**
 * Make a connection with the databse
 * @param string $host host name of the databse
 * @param string $db database name of the database
 * @param string $user username of the database
 * @param string $pass password of the database
 * @return ??
 *
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
 * Returns the number of series listed in the database.
 * @param PDO $pdo The database connection
 * @return string The number of series
 *
 */
function count_series($pdo){
    $stmt = $pdo->prepare('SELECT * FROM series');
    $stmt->execute();
    $number_series = $stmt->rowCount();
    return $number_series;
}

/**
 * Returns an associative array with all the series listed in the database
 * @param PDO $pdo The database connection
 * @return string The array with series
 *
 */
function get_series($pdo){
    $stmt = $pdo->prepare('SELECT * FROM series');
    $stmt->execute();
    $serie_info = $stmt->fetchAll();
    $serie_info_exp = Array();

    /* Create array with htmlspecialchars */
    foreach ($serie_info as $row => $rowcontent){
        foreach ($rowcontent as $column => $value){
            $serie_info_exp[$row][$column] = htmlspecialchars($value);
        }
    }
    return $serie_info_exp;
}

/**
 * Returns a string with the HTML code representing the table with all the series
 * @param $series_info_exp All the information for each series
 * @return string The series table
 *
 */
function get_series_table($serie_info_exp){
    $series_table = '
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Series</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>';
    foreach ($serie_info_exp as $key => $value){
        $series_table .= '
        <tr>
            <th scope="row">'.$value['name'].'</th>
            <td><a href="/DDWT18/week1/serie/?serie_id='.$value['id'].'" role="button" class="btn btn-primary">More info</a></td>
        </tr>';
    }
    $series_table .= '
        </tbody>
    </table>';
    return $series_table;
}

/**
 * Returns a string with the HTML code representing the information for that series
 * @param PDO $pdo The database connection
 * @return string The series table
 *
 */
function get_series_info($pdo, $serie_id){
    $stmt = $pdo->prepare('SELECT * FROM series WHERE id = ?');
    $stmt->execute([$serie_id]);
    $serie_info = $stmt->fetch();

    /* Create array with htmlspecialchars */
    foreach ($serie_info as $row => $rowcontent){
        $serie_info_exp[$row] = htmlspecialchars($rowcontent);
        }
    return $serie_info_exp;
}

/**
 * Add a series to the db
 * @param PDO $pdo The database connection
 * @return Array
 *
 */
function add_series($pdo, $serie_post){
    /* Check if all fields are set */
    if (
        empty($serie_post['name']) or
        empty($serie_post['creator']) or
        empty($serie_post['seasons']) or
        empty($serie_post['abstract'])
    ){
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }

    /* Check data type */
    if (!is_numeric($serie_post['seasons'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field Seasons.'
        ];
    }

    /* Check if serie already exists */
    $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
    $stmt->execute([$serie_post['name']]);
    $serie = $stmt->rowCount();
    if ($serie) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. This serie already exist.'
        ];
    }

    $stmt = $pdo->prepare('INSERT INTO series (name, creator, seasons, abstract) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $serie_post['name'],
        $serie_post['creator'],
        $serie_post['seasons'],
        $serie_post['abstract']
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted == 1) {
        return [
            'type' => 'success',
            'message' => sprintf("Series '%s' added to Series Overview", $serie_post['name'])
        ];
    }
    else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The series was not added. Try it again.'
        ];
    }
}

/**
 * Update a series from and to the db
 * @param PDO $pdo The database connection
 * @return Array
 *
 */
function update_series($pdo, $series_info, $serie_id){
    /* Check if all fields are set */
    if (
        empty($series_info['name']) or
        empty($series_info['creator']) or
        empty($series_info['seasons']) or
        empty($series_info['abstract'])
    ){
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }

    /* Check data type */
    if (!is_numeric($series_info['seasons'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field Seasons.'
        ];
    }

    /* Get current series name */
    $stmt = $pdo->prepare('SELECT * FROM series WHERE id = ?');
    $stmt->execute([$serie_id]);
    $serie = $stmt->fetch();
    $current_name = $serie['name'];

    /* Check if serie already exists */
    $stmt = $pdo->prepare('SELECT * FROM series WHERE name = ?');
    $stmt->execute([$series_info['name']]);
    $serie = $stmt->fetch();
    if ($series_info['name'] == $serie['name'] and $serie['name'] != $current_name) {
        return [
            'type' => 'danger',
            'message' => sprintf("The name of the series cannot be changed. %s already exists.",
                $series_info['name'])
        ];
    }

    /* Update Serie */
    $stmt = $pdo->prepare("UPDATE series SET name = ?, creator = ?, seasons = ?, abstract = ? WHERE id = ?");
    $stmt->execute([
        $series_info['name'],
        $series_info['creator'],
        $series_info['seasons'],
        $series_info['abstract'],
        $serie_id
    ]);
    $updated = $stmt->rowCount();
    if ($updated == 1) {
        return [
            'type' => 'success',
            'message' => sprintf("Series '%s' was edited!", $series_info['name'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'The series was not edited. No changes were detected'

        ];
    }
}

/**
 * Remove a series from the db
 * @param PDO $pdo The database connection
 * @return Array
 *
 */
function remove_serie($pdo, $serie_id){
    /* Get series info */
    $serie_info = get_series_info($pdo, $serie_id);

    /* Delete Serie */
    $stmt = $pdo->prepare("DELETE FROM series WHERE id = ?");
    $stmt->execute([$serie_id]);
    $deleted = $stmt->rowCount();
    if ($deleted == 1) {
        return [
            'type' => 'success',
            'message' => sprintf("Series '%s' was removed!", $serie_info['name'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The series was not removed.'
        ];
    }
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
 * Creates a new navigation array item using url and active status
 * @param string $url The url of the navigation item
 * @param bool $active Set the navigation item to active or inactive
 * @return array
 */
function na($url, $active){
    return [$url, $active];
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
 * Creates breadcrumb HTML code using given array
 * @param array $breadcrumbs Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the breadcrumbs
 */
function get_breadcrumbs($breadcrumbs) {
    $breadcrumbs_exp = '<nav aria-label="breadcrumb">';
    $breadcrumbs_exp .= '<ol class="breadcrumb">';
    foreach ($breadcrumbs as $name => $info) {
        if ($info[1]){
            $breadcrumbs_exp .= '<li class="breadcrumb-item active" aria-current="page">'.$name.'</li>';
        }else{
            $breadcrumbs_exp .= '<li class="breadcrumb-item"><a href="'.$info[0].'">'.$name.'</a></li>';
        }
    }
    $breadcrumbs_exp .= '</ol>';
    $breadcrumbs_exp .= '</nav>';
    return $breadcrumbs_exp;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($navigation){
    $navigation_exp = '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    $navigation_exp .= '<a class="navbar-brand">Series Overview</a>';
    $navigation_exp .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
    $navigation_exp .= '<span class="navbar-toggler-icon"></span>';
    $navigation_exp .= '</button>';
    $navigation_exp .= '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    $navigation_exp .= '<ul class="navbar-nav mr-auto">';
    foreach ($navigation as $name => $info) {
        if ($info[1]){
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="'.$info[0].'">'.$name.'</a>';
        }else{
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="'.$info[0].'">'.$name.'</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '</ul>';
    $navigation_exp .= '</div>';
    $navigation_exp .= '</nav>';
    return $navigation_exp;
}

/**
 * Pritty Print Array
 * @param $input
 */
function p_print($input){
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

/**
 * Creats HTML alert code with information about the success or failure
 * @param bool $type True if success, False if failure
 * @param string $message Error/Success message
 * @return string
 */
function get_error($feedback){
    $error_exp = '
        <div class="alert alert-'.$feedback['type'].'" role="alert">
            '.$feedback['message'].'
        </div>';
    return $error_exp;
}


