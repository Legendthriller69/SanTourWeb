<html>
<head>
    <!--Import Google Icon Font-->
    <link href="<?php echo ABSURL; ?>/assets/css/icon.css" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?php echo ABSURL; ?>/assets/css/materialize.min.css"
          media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo ABSURL; ?>/assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo ABSURL; ?>/assets/css/login.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
<div class="login-page">
    <div class="form">
        <form class="login-form col s12" method="POST">
            <div class="row">
                <div class="input-field col s12">
                    <input id="login" name="pseudo" type="text" class="validate">
                    <label class=active for="login"><?php __('Username') ?></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" name="password" type="password" class="validate">
                        <label class="active" for="password"><?php __('Password') ?></label>
                    </div>
                </div>
                <button type="submit" name="submit" class="waves-effect waves-light btn btn-large resa-btn">
                    <!--<i class="material-icons right">send</i>-->
                    <?php __('Enter') ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!--Import jQuery before materialize.js-->
<script src="<?php echo ABSURL; ?>/assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo ABSURL; ?>/assets/js/materialize.min.js"></script>

<?php echo \SanTourWeb\Library\Utils\Toast::displayMessages(); ?>
</body>
</html>