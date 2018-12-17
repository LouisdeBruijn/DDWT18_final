<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">

    <!-- CSS -->
    <!-- Add Material font (Roboto) and Material icon as needed -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Add Material CSS, replace Bootstrap CSS -->
    <link href="<?= $root ?>css/material.min.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>css/main.css">

    <title><?= $page_title ?></title>
</head>
<body>
<!-- Content -->
<div class="container">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th scope="row">Name</th>
            <td><?= $room_name ?></td>
        </tr>
        <tr>
            <th scope="row">Address</th>
            <td><?= $room_streetname." ".$room_streetnumber."</br>".$room_postalcode." ".$room_city ?></td>
        </tr>
        <tr>
            <th scope="row">Type</th>
            <td colspan="2"><?= $room_type ?></td>
        </tr>
        <tr>
            <th scope="row">Price</th>
            <td>&euro; <?= $room_price ?></td>
        </tr>
        <tr>
            <th scope="row">Size</th>
            <td><?= $room_size ?> m<sup>2</sup></td>
        </tr>
        </tbody>
    </table>
</div>

<!-- Optional JavaScript -->
<script type="text/javascript" src="<?= $root ?>js/materialize.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<!-- Then Material JavaScript on top of Bootstrap JavaScript -->
<script src="<?= $root ?>css/material.min.js"></script>
</body>
</html>