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
        <link href="/DDWT18/final/css/material.min.css" rel="stylesheet">
        <!-- Own CSS -->
        <link rel="stylesheet" type="text/css" href="/DDWT18/final/css/main.css">


        <title><?= $page_title ?></title>
    </head>
    <body>
        <!-- Menu -->
        <?= $navigation ?>

        <!-- Content -->
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="pd-15">&nbsp</div>
            <?= $breadcrumbs ?>

            <div class="row">

                <div class="col-md-12">
                    <!-- Error message: hier pas je aan waar die error message komt -->
                    <?php if (isset($error_msg)){echo $error_msg;} ?>

                    <h1><?= $page_title ?></h1>
                    <h5><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>
                </div>

            </div>

            <div class="pd-15">&nbsp;</div>

            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Welcome, <?= get_username($db, $_SESSION['user_id']) ?> <!-- get_user_id() kan ook $_SESSION['user_id'] zijn -->
                        </div>
                        <div class="card-body">
                            <p>You're logged in to Series Overview.</p>
                            <a href="/DDWT18/final/logout/" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Add series
                        </div>
                        <div class="card-body">
                            <p>Add your contribution to Series Overview.</p>
                            <a href="/DDWT18/final/add/" class="btn btn-primary">Add a series</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

        <!-- Then Material JavaScript on top of Bootstrap JavaScript -->
        <script src="/DDWT18/final/css/material.min.js"></script>
    </body>
</html>