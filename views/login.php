<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $page_title ?></title>
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
</head>
<body>
<!-- Menu -->
<?= $navigation ?>

<div class="container">
    <div class="row justify-content-center">
        <form action="<?= $root ?>/login/" method="POST" class="needs-validation" novalidate>
            <div class="form-group">
                <div class="floating-label">
                    <label for="inputUsername">Username</label>
                    <input aria-describedby="" class="form-control" id="inputUsername" placeholder="Enter username" name="username" type="text" required>
                    <div class="valid-feedback">
                        Looks good.
                    </div>
                    <div class="invalid-feedback">
                        Please enter a username.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="floating-label">
                    <label for="inputPassword">Password</label>
                    <input aria-describedby="" class="form-control" id="inputPassword" placeholder="Enter password" name="password" type="password" required>
                    <div class="valid-feedback">
                        Looks good.
                    </div>
                    <div class="invalid-feedback">
                        Please enter a password.
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
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

