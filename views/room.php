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
            <h1><?= $page_title ?></h1>

        </div>
    </div>

    <div class="row">
        <!-- Left content -->
        <div class="col-md-4">
            <div class="card" >
                <div class="card-body">
                    <h5 class="card-title"><?= $page_content ?></h5>

                    <label for="location">Location</label>
                    <p id="location" class="card-text"><i class="material-icons">map</i>&nbsp;&nbsp;<?= $room_info['street']?> <?=$room_info['streetnumber']?> <?= $room_info['postalcode']?> <?=$room_info['city']  ?></p>
                    <label for="type">Type</label>
                    <p id="type" class="card-text"><i class="material-icons">kitchen</i>&nbsp;&nbsp;<?= $room_info['type'] ?></p>
                    <label for="size">Size</label>
                    <p id ="size" class="card-text"><i class="material-icons">aspect_ratio</i>&nbsp;&nbsp;<?= $room_info['size'] ?>m<sup>2</sup></p>
                    <label for="price">Price per month</label>
                    <p id="price" class="card-text"><i class="material-icons">local_atm</i>&nbsp;&nbsp;<?= $room_info['price'] ?></p>


                </div>
            </div>


        </div>
        <!-- Middle content -->
        <div class="col-md-6">
            <!-- Images -->
            <?php if (isset($images)){echo $images;} ?>


        </div>

        <!-- Right content -->
        <div class="col-md-2">
            <?php if ($display_buttons) { ?>
                <div class="row text-right">
                    <div class="col-md-12">
                        <a href="<?= $root ?>/room/edit?room_id=<?= $room_id ?>" role="button" class="btn btn-warning">Edit</a>
                    </div>
                    <div class="col-md-12">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                            Remove
                        </button>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <p class="text-black-secondary typography-subheading">Discard room?</p>
                                <form action="<?= $root ?>/room/remove/" method="POST">
                                    <input type="hidden" value="<?= $room_id ?>" name="room_id">
                                        <button class="btn btn-outline-info" data-dismiss="modal" type="button">Cancel</button>
                                        <button type="submit" class="btn btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php if ($display_optin and !$display_buttons){ ?>
            <div class="row">
                <div class="col-auto">
                    <form action="<?= $root ?>/room/optin" method="POST">
                        <input type="hidden" value="<?= $room_id ?>" name="room_id">
                        <textarea class="form-control" aria-describedby="" id="message" placeholder="Write a message for the owner of the room" name="message" type="textarea" required></textarea><br>
                        <button type="submit" class="btn btn-info">Opt in</button>
                    </form>
                </div>
            </div>
            <?php } ?>
            <?php if (!$display_optin){ ?>
                <div class="row">
                    <div class="col-auto">
                        <form action="<?= $root ?>/room/delete" method="POST">
                            <input type="hidden" value="<?= $room_id ?>" name="room_id">
                            <button type="submit" class="btn btn-danger">Opt out</button>
                        </form>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <!-- Middle content -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5><?= $page_subtitle ?></h5>
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
