
<h2 class="hide"><?php echo $main_title; ?></h2>
<?php echo $content; ?>

<?php if ($_SERVER['DOCUMENT_ROOT'].file_exists(Config::get('global')['js_dir']."frontend/pages/$alias.js")):?>
    <script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>frontend/pages/<?php echo $alias?>.js"></script>
<?php endif;?>