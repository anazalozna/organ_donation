<!doctype>
<html>
    <head>
        <title><?php echo App::getInstance()->getParam('title'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="<?php echo Config::get('global')['css_dir']; ?>admin.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="hide">My Control Panel</h1>
        <?php echo App::getInstance()->loadController('menu/backend/menu') ?>
        <?php echo $__content; ?>

        <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/functions.js"></script>
        <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>classes.js"></script>
        <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/common.js"></script>
    </body>
</html>