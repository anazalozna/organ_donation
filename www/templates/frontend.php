<!doctype>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo App::getInstance()->getParam('title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo Config::get('global')['css_dir']; ?>main.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
</head>
<body>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <h1 class="hide">Organ Donation</h1>
    <header class="header">
        <div class="socials">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
            <a href="#"><i class="fa fa-youtube"></i></a>
        </div>
        <label for="mobile-menu" class="menu_icon_h" id="menu_toggler">
            <i class="fa fa-bars"></i>
        </label>
        <input id="mobile-menu" type="checkbox" />
        <nav class="nav_h">
            <h2 class="hide">Header Navigation</h2>
            <label for="mobile-menu" id="mobile-menu-label" class="menu_icon_h">
                <i class="fa fa-times"></i>
            </label>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/page/about-donation">About Donation</a></li>
                <li><a href="/page/faq">FAQ</a></li>
                <li><a href="/#videos">Videos</a></li>
            </ul>
        </nav>
    </header>
    <?php echo $__content; ?>
    <footer class="footer_block">
        <h2 class="hide">Footer</h2>
        <div class="wrapper">
            <h2 class="title_h2">Follow Us</h2>
            <div class="socials_f wrapper_small">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-youtube"></i></a>
            </div>
            <a href="/admin">Sign-In</a>
        </div>
    </footer>
    <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>frontend/functions.js"></script>
    <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>classes.js"></script>
    <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>frontend/libs.js"></script>
    <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>frontend/common.js"></script>
</body>
</html>