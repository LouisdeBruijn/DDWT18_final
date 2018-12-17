<!doctype html>
<html lang="en">
<head>
    <title><?= $page_title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">

    <link rel="stylesheet" type="text/css" href="<?= $root ?>final/css/main.css">
    <!-- CSS -->
    <!-- Add Material font (Roboto) and Material icon as needed -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Add Material CSS, replace Bootstrap CSS -->
    <link href="<?= $root ?>css/material.min.css" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>css/main.css">
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

        <!-- Left column -->
        <div class="col-md-8">
            <!-- Error message -->
            <?php if (isset($error_msg)){echo $error_msg;} ?>

            <h1><?= $page_title ?></h1>
            <h5><?= $page_subtitle ?></h5>
            <p><?= $page_content ?></p>


            <form class="" action="<?= $form_action ?>" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <div class="<script>focus_label(inputName)</script>">
                        <label for="inputName">Room name</label>
                        <input aria-describedby="" class="form-control" id="inputName" placeholder="The room's name" value="" name="name" type="text" required>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the room's name.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <label for="inputDescription">Description</label>
                        <textarea class="form-control"  aria-describedby="" id="inputDescription" placeholder="Describe the room." name="description" type="textarea" required></textarea>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please tell us about your room.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="<script>focus_label(inputPostalcode)</script>">
                        <label for="inputPostalcode">Postal code</label>
                        <input aria-describedby="" readonly class="form-control-plaintext" id="inputPostalcode" placeholder="1234AB" value="<?php if (isset($postalcode)){echo $postalcode;} ?>" name="postalcode" type="text" maxlength="7" required>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the postal code.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="<script>focus_label(InputStreetnumber)</script>">
                        <label for="InputStreetnumber">Street number</label>
                        <input aria-describedby="" readonly class="form-control-plaintext" id="InputStreetnumber" placeholder="27" value="<?php if (isset($streetnumber)){echo $streetnumber;} ?>" name="streetnumber" type="number" required>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the street number.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="<script>focus_label(InputStreet)</script>">
                        <label for="InputStreet">Street</label>
                        <input aria-describedby="" readonly class="form-control-plaintext" id="InputStreet" placeholder="Hereweg" value="<?php if (isset($street)){echo $street;} ?>" name="street" type="text" required>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the street.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="<script>focus_label(InputCity)</script>">
                        <label for="InputCity">City</label>
                        <input aria-describedby="" readonly class="form-control-plaintext" id="InputCity" placeholder="Groningen" value="<?php if (isset($city)){echo $city;} ?>" name="city" type="text" required>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the street number.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputType">Type</label>
                    <select class="custom-select" id="inputType" name="type" required>
                        <option disabled selected value>Choose...</option>
                        <option value="1">Iets</option>
                        <option value="2">Nog iets</option>
                        <option value="3">Meer</option>
                    </select>
                </div>
                <div class="form-group">

                    <div class="<script>focus_label(InputPrice)</script>">
                        <label for="InputPrice">Price</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text text-muted">€</div>
                            </div>
                            <input aria-describedby="" class="form-control" id="InputPrice" placeholder="375" value="" name="price" type="number" required>
                            <div class="input-group-append">
                                <div class="input-group-text text-muted">.00</div>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the room's price.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="<script>focus_label(InputSize)</script>">
                        <label for="InputSize">Size</label>
                        <div class="input-group mb-3">
                            <input aria-describedby="" class="form-control" id="InputSize" placeholder="12" value="" name="size" type="number" required>
                            <div class="input-group-append">
                                <div class="input-group-text text-muted">m<sup>2</sup></div>
                            </div>
                        </div>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please enter the room's size.
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><?= $submit_btn ?></button>
            </form>
        </div>

        <!-- Right column -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">The number of calls to the Postcode API</h5>
                    <h1 class="text-right" ><?= $count ?></h1>
                </div>
            </div>
        </div>

    </div>
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