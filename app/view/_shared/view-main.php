<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo ABSURL; ?>/assets/css/materialize.css" rel="stylesheet" media="screen,projection"/>
    <link href="<?php echo ABSURL; ?>/assets/css/styles.css" rel="stylesheet" media="screen,projection"/>

    <!--  Scripts-->
    <script src="<?php echo ABSURL; ?>/assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo ABSURL; ?>/assets/js/materialize.js"></script>
    <script>
        var ABSURL = '<?php echo ABSURL ?>';
    </script>
    <script type="text/javascript" src="<?php echo ABSURL; ?>/library/utils/traduction.php"></script>
    <script src="<?php echo ABSURL; ?>/assets/js/sanTourWeb.js"></script>
</head>
<body>
<header>
    <div class="navbar-fixed">
        <nav class="teal lighten-2">
            <div class="nav-wrapper container">
                <span class="brand-logo">SanTour</span>
                <?php
                if (isset($_SESSION['connected']) && $_SESSION['connected'])
                    echo '<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>';
                ?>
                <ul class="right hide-on-med-and-down">
                    <?php
                    $ctr = $this->currentController;

                    if (isset($_SESSION['connected']) && $_SESSION['connected']) {
                        echo '<li ';
                        if ($ctr == 'tracks') {
                            echo 'class="active"';
                        }
                        echo '><a href="' . ABSURL . DS . 'tracks">' . __("Tracks", true) . '</a></li>';
                        echo '<li ';
                        if ($ctr == 'categories') {
                            echo 'class="active"';
                        }
                        echo '><a href="' . ABSURL . DS . 'categories">' . __("Categories", true) . '</a></li>';
                        echo '<li ';
                        if ($ctr == 'users') {
                            echo 'class="active"';
                        }
                        echo '><a href="' . ABSURL . DS . 'users">' . __("Users", true) . '</a></li>';
                        echo '<li><a href="' . ABSURL . DS . 'index' . DS . 'logout">' . __("Logout", true) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </div>
    <ul class="side-nav san-side-nav show-on-medium-and-down" id="mobile-demo">
        <?php
        if (isset($_SESSION['connected']) && $_SESSION['connected']) {
            echo '<li ';
            if ($ctr == 'tracks') {
                echo 'class="active"';
            }
            echo '><a href="' . ABSURL . DS . 'tracks">' . __("Tracks", true) . '</a></li>';
            echo '<li ';
            if ($ctr == 'categories') {
                echo 'class="active"';
            }
            echo '><a href="' . ABSURL . DS . 'categories">' . __("Categories", true) . '</a></li>';
            echo '<li ';
            if ($ctr == 'users') {
                echo 'class="active"';
            }
            echo '><a href="' . ABSURL . DS . 'users">' . __("Users", true) . '</a></li>';
            echo '<li><a href="' . ABSURL . DS . 'index' . DS . 'logout">' . __("Logout", true) . '</a></li>';
        }
        ?>
    </ul>
</header>
<main>
    <?php echo $html; ?>
</main>
<footer class="page-footer teal lighten-6">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text"><?php __('Who are we ?') ?></h5>
                <p class="grey-text text-lighten-4">
                    <?php __('We are five students from the HES-SO in Sierre. As part of our project course, we are asked to make a mobile application for SanTour, a company that harvests course data made by its trackers. The administration part of the application is managed from this web platform.') ?>
                </p>
            </div>
            <?php
            if (isset($_SESSION['connected']) && $_SESSION['connected'])
                echo '<div class="col l3 s12">';
            else
                echo '<div class="col l3 offset-l3 s12">';
            ?>
            <h5 class="white-text"><?php __("Languages"); ?></h5>
            <ul>
                <?php
                if ($_SESSION['lang'] == 'de')
                    echo '<li class="san-disabled">' . __("German", true) . '</li>';
                else
                    echo '<li><a class="white-text" href="' . ABSURL . '/language?lang=de">' . __("German", true) . '</a></li>';
                if ($_SESSION['lang'] == 'en')
                    echo '<li class="san-disabled">' . __("English", true) . '</li>';
                else
                    echo '<li><a class="white-text" href="' . ABSURL . '/language?lang=en">' . __("English", true) . '</a></li>';
                if ($_SESSION['lang'] == 'fr')
                    echo '<li class="san-disabled">' . __("French", true) . '</li>';
                else
                    echo '<li><a class="white-text" href="' . ABSURL . '/language?lang=fr">' . __("French", true) . '</a></li>';
                ?>
            </ul>
        </div>
        <?php
        if (isset($_SESSION['connected']) && $_SESSION['connected']) {
            echo '
                            <div class="col l3 s12">
                                <h5 class="white-text">' . __("Navigation", true) . '</h5>
                                <ul>';
            if ($ctr == 'tracks')
                echo '<li class="san-disabled">' . __("Tracks", true) . '</li>';
            else
                echo '<li><a class="white-text" href="' . ABSURL . DS . 'tracks">' . __("Tracks", true) . '</a></li>';

            if ($ctr == 'categories')
                echo '<li class="san-disabled">' . __("Categories", true) . '</li>';
            else
                echo '<li><a class="white-text" href="' . ABSURL . DS . 'categories">' . __("Categories", true) . '</a></li>';

            if ($ctr == 'users')
                echo '<li class="san-disabled">' . __("Users", true) . '</li>';
            else
                echo '<li><a class="white-text" href="' . ABSURL . DS . 'users">' . __("Users", true) . '</a></li>';
            echo '<li><a class="white-text" href="' . ABSURL . DS . 'login' . DS . 'logout">' . __("Logout", true) . '</a></li>
                </ul>
            </div>';
        }
        ?>
    </div>
    </div>
</footer>

<?php
echo \SanTourWeb\Library\Utils\Toast::displayMessages();
?>
</body>
</html>
