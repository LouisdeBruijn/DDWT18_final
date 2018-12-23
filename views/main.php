<!doctype HTML>
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
    <link href="<?= $root ?>/css/material.min.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>/css/main.css">

    <title><?= $page_title ?></title>
</head>
<body>
<!-- Menu -->
<?= $navigation ?>
<!-- Content -->
<div class="container">
    <div class="pd-15">&nbsp</div>
    <!-- Full width -->
    <div class="row">
        <div class="col-md-12">
            <!-- Error message -->
            <?php if (isset($view_msg)){echo $view_msg;} ?>
        </div>
    </div>

    <div class="row">
        <!-- Left content -->
        <div class="col-md-3">
            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>
            <p><?= $page_content ?></p>

        </div>
        <!-- Right content -->
        <div class="col-md-6">
            <?php if(isset($all_rooms)){foreach($all_rooms as $key => $room){echo $room;}}?>
        </div>

        <!-- zit hier te kloten met die col-md-3
        Hierna moet ik nog die if-statements op index omschrijven zodat ie alle kamers laat zien -->
        <div class="col-md-3">
            <?php if(isset($count_card)){echo $count_card;}?>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<script type="text/javascript" src="<?= $root ?>/js/materialize.js"></script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<!-- Then Material JavaScript on top of Bootstrap JavaScript -->
<script src="<?= $root ?>/css/material.min.js"></script>
</body>
</html>