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

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title><?= $page_title ?></title>
</head>
<body>
<!-- Menu -->
<?= $navigation ?>
<!-- Content -->
<div class="container">
    <!-- Full width -->
    <div class="row">
        <div class="col-md-12">
            <!-- Error message -->
            <?php if (isset($view_msg)){echo $view_msg;} ?>
        </div>
    </div>

        <div class="row">
            <!-- Left content -->
            <div class="col-md-4">
                    <h1><?= $page_title ?></h1>
                <h5><?= $page_subtitle ?></h5>
                <div class="card text-center mb-3">
                    <div class="card-body">
                        <img class="img-fluid" id="avatar" src="<?php if(isset($avatar)){echo $avatar;} else {echo "$root/images/avatar.jpg";} ?>" alt="profile image"/>
                        <h5 class="card-title"><?= $name ?></h5>
                        <div class="text-left">
                            <label for="biography">Biography</label>
                            <p class="card-text"><?php if(isset($user_info['biography'])){echo $user_info['biography'];}?></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="role">Role</label>
                                    <p class="card-text"><?php if(isset($user_info['role'])){if ($user_info['role'] == '1'){echo 'Owner';}elseif($user_info['role'] == '2'){echo 'Tenant';}}?></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="language">Language</label>
                                    <p class="card-text"><?php if(isset($user_info['language'])){echo $user_info['language'];}?></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="occupation">Occupation</label>
                                    <p class="card-text"><?php if(isset($user_info['occupation'])){echo $user_info['occupation'];}?></p>
                                </div>
                                <div class="col-md-6">
                                    <label for="birthdate">Birth date</label>
                                    <p class="card-text"><?php if(isset($user_info['birthdate'])){echo $user_info['birthdate'];}?></p>

                                </div>
                                <div class="col-md-12">
                                    <label for="email">Email address</label>
                                    <p class="card-text"><?php if(isset($user_info['email'])){echo $user_info['email'];}?></p>

                                </div>
                                <div class="col-md-12">
                                    <label for="phone">Phone number</label>
                                    <p class="card-text"><?php if(isset($user_info['phone'])){echo $user_info['phone'];}?></p>
                                </div>
                            </div>

                        </div>
                        <a href="/DDWT18/myaccount/edit" class="btn btn-info">Edit profile</a>
                        <a href="/DDWT18/myaccount/remove" class="btn btn-danger">Delete account</a>
                    </div>
                </div>
            </div>
            <!-- Middle content -->
            <div class="col-md-6">
                <h5><?= $page_content ?></h5>
                <?php if(isset($all_rooms)){foreach($all_rooms as $key => $room){echo $room;}}?>

                <?= $optin_table ?>
                <?= $optin_owner_table ?>
            </div>

            <!-- Right content -->
            <div class="col-md-2">
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