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

            <div class="row">

                <div class="col-md-12">
                    <!-- Error message: hier pas je aan waar die error message komt -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <img class="img-fluid" id="avatar" src="<?php if(isset($avatar)){echo $avatar;} else {echo "$root/images/avatar.jpg";} ?>" alt="profile image"/>
                            <h5 class="card-title"><?= $name ?></h5>
                            <a href="/DDWT18/myaccount/edit" class="btn btn-secondary">Edit profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php if(isset($rooms_cards)){foreach($rooms_cards as $key => $room){echo $room;}} ?>
                </div>
            </div>
            <br>
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