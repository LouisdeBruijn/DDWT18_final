<!DOCTYPE html>
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
        </div>
        <!-- Right content -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Register</h5>
                    <form action="<?= $root ?>/register" method="POST" class="needs-validation" novalidate>
                        <div class="form-group">
                            <div class="floating-label">
                                <label for="inputUsername">Username</label>
                                <input aria-describedby="" class="form-control" id="inputUsername" placeholder="Enter a username" name="username" type="text" required>
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
                                <input aria-describedby="" class="form-control" id="inputPassword" placeholder="******" name="password" type="password" required>
                                <div class="valid-feedback">
                                    Looks good.
                                </div>
                                <div class="invalid-feedback">
                                    Please enter a password.
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputFirstName">First name</label>
                                    <input aria-describedby="" class="form-control" id="inputFirstName" placeholder="Your first name" name="firstname" type="text" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your first name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputLastName">Last name</label>
                                    <input aria-describedby="" class="form-control" id="inputLastName" placeholder="Your last name" name="lastname" type="text" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your last name.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputOccupation">Occupation</label>
                                    <input aria-describedby="" class="form-control" id="inputOccupation" placeholder="Your studies or profession" name="occupation" type="text" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your occupation.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputBirthDate">Birth date</label>
                                    <input aria-describedby="" class="form-control" id="inputBirthDate" placeholder="Your birth date" name="birthdate" type="date" pattern="\d{4}(\/|\-)\d{2}(\/|\-)\d{2}" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please insert a valid date format: 1999/01/01
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputBio">Biography</label>
                            <textarea class="form-control"  aria-describedby="" id="inputBio" placeholder="Tell us about you" name="biography" type="textarea" required></textarea>
                            <div class="valid-feedback">
                                Looks good.
                            </div>
                            <div class="invalid-feedback">
                                Please tell us something about yourself.
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="inputRole">Role</label>
                                <select class="custom-select" id="inputRole" name="role" required>
                                    <option disabled selected value>Choose...</option>
                                    <option value="1">Owner</option>
                                    <option value="2">Tenant</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputLanguage">Language</label>
                                <select class="custom-select" id="inputLanguage" name="language" required>
                                    <option disabled selected value>Choose a language...</option>
                                    <option value="AF">Afrikanns</option>
                                    <option value="SQ">Albanian</option>
                                    <option value="AR">Arabic</option>
                                    <option value="HY">Armenian</option>
                                    <option value="EU">Basque</option>
                                    <option value="BN">Bengali</option>
                                    <option value="BG">Bulgarian</option>
                                    <option value="CA">Catalan</option>
                                    <option value="KM">Cambodian</option>
                                    <option value="ZH">Chinese (Mandarin)</option>
                                    <option value="HR">Croation</option>
                                    <option value="CS">Czech</option>
                                    <option value="DA">Danish</option>
                                    <option value="NL">Dutch</option>
                                    <option value="EN">English</option>
                                    <option value="ET">Estonian</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finnish</option>
                                    <option value="FR">French</option>
                                    <option value="KA">Georgian</option>
                                    <option value="DE">German</option>
                                    <option value="EL">Greek</option>
                                    <option value="GU">Gujarati</option>
                                    <option value="HE">Hebrew</option>
                                    <option value="HI">Hindi</option>
                                    <option value="HU">Hungarian</option>
                                    <option value="IS">Icelandic</option>
                                    <option value="ID">Indonesian</option>
                                    <option value="GA">Irish</option>
                                    <option value="IT">Italian</option>
                                    <option value="JA">Japanese</option>
                                    <option value="JW">Javanese</option>
                                    <option value="KO">Korean</option>
                                    <option value="LA">Latin</option>
                                    <option value="LV">Latvian</option>
                                    <option value="LT">Lithuanian</option>
                                    <option value="MK">Macedonian</option>
                                    <option value="MS">Malay</option>
                                    <option value="ML">Malayalam</option>
                                    <option value="MT">Maltese</option>
                                    <option value="MI">Maori</option>
                                    <option value="MR">Marathi</option>
                                    <option value="MN">Mongolian</option>
                                    <option value="NE">Nepali</option>
                                    <option value="NO">Norwegian</option>
                                    <option value="FA">Persian</option>
                                    <option value="PL">Polish</option>
                                    <option value="PT">Portuguese</option>
                                    <option value="PA">Punjabi</option>
                                    <option value="QU">Quechua</option>
                                    <option value="RO">Romanian</option>
                                    <option value="RU">Russian</option>
                                    <option value="SM">Samoan</option>
                                    <option value="SR">Serbian</option>
                                    <option value="SK">Slovak</option>
                                    <option value="SL">Slovenian</option>
                                    <option value="ES">Spanish</option>
                                    <option value="SW">Swahili</option>
                                    <option value="SV">Swedish </option>
                                    <option value="TA">Tamil</option>
                                    <option value="TT">Tatar</option>
                                    <option value="TE">Telugu</option>
                                    <option value="TH">Thai</option>
                                    <option value="BO">Tibetan</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TR">Turkish</option>
                                    <option value="UK">Ukranian</option>
                                    <option value="UR">Urdu</option>
                                    <option value="UZ">Uzbek</option>
                                    <option value="VI">Vietnamese</option>
                                    <option value="CY">Welsh</option>
                                    <option value="XH">Xhosa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputEmail">Email address</label>
                                    <input aria-describedby="" class="form-control" id="inputEmail" placeholder="Your email address" name="email" type="email" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your email address.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="floating-label">
                                    <label for="inputPhone">Phone number</label>
                                    <input aria-describedby="" class="form-control" id="inputPhone" placeholder="Your phone number" name="phone" type="tel" pattern="^(\+|\d)(\d){5,15}" required>
                                    <div class="valid-feedback">
                                        Looks good.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter your phone number a a valid format: +31612345678
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info">Register</button>
                    </form>
                </div>
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