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
            <?php if(isset($postcode_count)){echo $postcode_count;} ?>
        </div>
        <!-- Middle content -->
        <div class="col-md-6">
            <div class="stepper-horiz">
                <div class="stepper active">
                    <div class="stepper-icon">
                        <span>1</span>
                    </div>
                    <span class="stepper-text">Address</span>
                </div>
                <div class="stepper">
                    <div class="stepper-icon">
                        <span>2</span>
                    </div>
                    <span class="stepper-text">Room details</span>
                </div>
            </div>

            <div class="card">

                <div class="card-body">
                    <h5 class="card-title"><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>
                    <form action="<?= $form_action ?>" method="POST" class="needs-validation" novalidate>
                        <div class="form-group">
                            <div class="<script>focus_label(inputPostalcode)</script>">
                                <label for="inputPostalcode">Postal code</label>
                                <input aria-describedby="" class="form-control" id="inputPostalcode" placeholder="1234AB" value="" name="postalcode" type="text" pattern="\d{4}[a-zA-Z]{2}" maxlength="6" autocapitalize="characters" required>
                                <div class="valid-feedback">
                                    Looks good.
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the postal code in format: 1234AB.
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="<script>focus_label(InputStreetnumber)</script>">
                                <label for="InputStreetnumber">Street number</label>
                                <input aria-describedby="" class="form-control" id="InputStreetnumber" placeholder="27" value="" name="streetnumber" type="number" required>
                                <div class="valid-feedback">
                                    Looks good.
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the street number.
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info"><?= $submit_btn ?></button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right content -->
        <div class="col-md-2">
        </div>
    </div>

    <!-- Middle content -->
    <div class="row">
        <div class="col-md-12">
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
