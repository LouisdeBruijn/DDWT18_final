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
            <?php if(isset($postcode_count)){echo $postcode_count;} ?>
            <?php if(isset($add_pictures)){echo $add_pictures;} ?>
            <?php if(isset($remove_images)){echo $remove_images;} ?>

        </div>
        <!-- Middle content -->
        <div class="col-md-6">
        <?php if (isset($stepper)){ echo '
            <div class="stepper-horiz">
                <div class="stepper done">
                    <div class="stepper-icon">
                        <span>1</span>
                    </div>
                    <span class="stepper-text">Address</span>
                </div>
                <div class="stepper active">
                    <div class="stepper-icon">
                        <span>2</span>
                    </div>
                    <span class="stepper-text">Room details</span>
                </div>
            </div>

        ';} ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $page_subtitle ?></h5>
                    <p><?= $page_content ?></p>

                    <form action="<?= $form_action ?>" method="POST" class="needs-validation" novalidate>
                <div class="form-group">
                    <div class="<script>focus_label(inputName)</script>">
                        <label for="inputName">Room name</label>
                        <input aria-describedby="" class="form-control" id="inputName" placeholder="The room's name" value="<?php if (isset($room_info['name'])){echo $room_info['name'];} ?>" name="name" type="text" required>
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
                        <textarea class="form-control"  aria-describedby="" id="inputDescription" placeholder="Describe the room." name="description" type="textarea" rows="8" required><?php if (isset($room_info['description'])){echo $room_info['description'];} ?></textarea>
                        <div class="valid-feedback">
                            Looks good.
                        </div>
                        <div class="invalid-feedback">
                            Please describe your room.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="<script>focus_label(inputPostalcode)</script>">
                            <label for="inputPostalcode">Postal code</label>
                            <input aria-describedby="" class="form-control" id="inputPostalcode" placeholder="1234AB" value="<?php if (isset($postalcode)){echo $postalcode;}elseif(isset($room_info['postalcode'])){echo $room_info['postalcode'];} ?>" name="postalcode" type="text" maxlength="7" required>
                            <div class="valid-feedback">
                                Looks good.
                            </div>
                            <div class="invalid-feedback">
                                Please enter the postal code.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="<script>focus_label(InputStreetnumber)</script>">
                            <label for="InputStreetnumber">Street number</label>
                            <input aria-describedby="" class="form-control" id="InputStreetnumber" placeholder="27" value="<?php if (isset($streetnumber)){echo $streetnumber;}elseif(isset($room_info['streetnumber'])){echo $room_info['streetnumber'];} ?>" name="streetnumber" type="number" required>
                            <div class="valid-feedback">
                                Looks good.
                            </div>
                            <div class="invalid-feedback">
                                Please enter the street number.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="<script>focus_label(InputStreet)</script>">
                            <label for="InputStreet">Street</label>
                            <input aria-describedby="" class="form-control" id="InputStreet" placeholder="Hereweg" value="<?php if (isset($street)){echo $street;}elseif(isset($room_info['street'])){echo $room_info['street'];} ?>" name="street" type="text" required>
                            <div class="valid-feedback">
                                Looks good.
                            </div>
                            <div class="invalid-feedback">
                                Please enter the street.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="<script>focus_label(InputCity)</script>">
                            <label for="InputCity">City</label>
                            <input aria-describedby="" class="form-control" id="InputCity" placeholder="Groningen" value="<?php if (isset($city)){echo $city;}elseif(isset($room_info['city'])){echo $room_info['city'];} ?>" name="city" type="text" required>
                            <div class="valid-feedback">
                                Looks good.
                            </div>
                            <div class="invalid-feedback">
                                Please enter the street number.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="inputType">Type</label>
                        <select class="custom-select" id="inputType" name="type" required>
                            <?php if (isset($room_info['type'])){echo '
                        <option selected value="'.$room_info['type'].'">'.$room_info['type'].'</option>
                        <option value="Student\'s house">Student\'s house</option>
                        <option value="Owner\'s house">Owner\'s house</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Studio">Studio</option>
                        ';} else { echo '
                        <option disabled selected value>Choose...</option>
                        <option value="Student\'s house">Student\'s house</option>
                        <option value="Owner\'s house">Owner\'s house</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Studio">Studio</option>
                        ';} ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="<script>focus_label(InputSize)</script>">
                            <label for="InputSize">Size</label>
                            <div class="input-group mb-3">
                                <input aria-describedby="" class="form-control" id="InputSize" placeholder="12" value="<?php if (isset($room_info['size'])){echo $room_info['size'];} ?>" name="size" type="number" required>
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
                    <div class="col-md-4 mb-3">
                        <div class="<script>focus_label(InputPrice)</script>">
                            <label for="InputPrice">Price</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text text-muted">€</div>
                                </div>
                                <input aria-describedby="" class="form-control" id="InputPrice" placeholder="375" value="<?php if (isset($room_info['price'])){echo $room_info['price'];} ?>" name="price" type="number" required>
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
                </div>
                <?php if(isset($room_id)){ ?><input type="hidden" name="room_id" value="<?php echo $room_id ?>"><?php } ?>
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