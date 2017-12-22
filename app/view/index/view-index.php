<html>
<head>
    <!--Import Google Icon Font-->
    <link href="<?php echo ABSURL; ?>/assets/css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?php echo ABSURL; ?>/assets/css/materialize.min.css" media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo ABSURL; ?>/assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ABSURL; ?>/assets/css/login.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<div class="login-page">
    <div class="form">
        <div class="row">
            <div class="col s12">
                <img id="san-login-logo" src="<?php echo ABSURL; ?>/assets/img/logo_text.PNG" />
            </div>
        </div>
        <form class="login-form col s12 san-form" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" name="email" type="text" class="validate" required>
                    <label class="active" for="email"><?php __('Email') ?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate" required>
                    <label class="active" for="password"><?php __('Password') ?></label>
                </div>
            </div>
            <button type="submit" name="submit" class="waves-effect waves-light btn btn-large san-btn">
                <?php __('Enter') ?>
            </button>
        </form>
        <div class="row">
            <div class="col s12 right-align">
                <?php
                if ($_SESSION['lang'] == 'de')
                    echo '<span class="san-lang-disabled">DE</span> | ';
                else
                    echo '<span class="san-lang-text"><a class="black-text" href="' . ABSURL . '/language?lang=de">DE</a></span> | ';
                if ($_SESSION['lang'] == 'en')
                    echo '<span class="san-lang-disabled">EN</span> | ';
                else
                    echo '<span class="san-lang-text"><a class="black-text" href="' . ABSURL . '/language?lang=en">EN</a></span> | ';
                if ($_SESSION['lang'] == 'fr')
                    echo '<span class="san-lang-disabled">FR</span>';
                else
                    echo '<span class="san-lang-text"><a class="black-text" href="' . ABSURL . '/language?lang=fr">FR</a></span>';
                ?>
            </div>
        </div>
    </div>
</div>

<!--Import jQuery before materialize.js-->
<script src="<?php echo ABSURL; ?>/assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo ABSURL; ?>/assets/js/materialize.min.js"></script>
<?php
echo \SanTourWeb\Library\Utils\Toast::displayMessages();
?>
</body>
</html>