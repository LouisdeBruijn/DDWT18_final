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
    <link href="/DDWT18/final/css/material.min.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="/DDWT18/final/css/main.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <form action="" method="POST" class="needs-validation" novalidate>
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
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<!-- Then Material JavaScript on top of Bootstrap JavaScript -->
<script src="/DDWT18/final/css/material.min.js"></script>
</body>
</html>

