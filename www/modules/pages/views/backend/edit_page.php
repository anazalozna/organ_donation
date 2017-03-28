<div class="wrapper edit_single_page">

    <form class="user_edit" method="post">
        <label>New Title</label>
        <input name="title" value="<?php echo $title ?>" type="text">
        <label>New URL</label>
        <input name="alias" value="<?php echo $alias ?>" type="text">
        <textarea name="content"><?php echo $content ?></textarea>
        <input type="submit">
    </form>

    <ul class="errors_style">
		<?php foreach ($errors as $error):?>
            <li><?php echo $error ?></li>
		<?php endforeach;?>
    </ul>
</div>

<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/editor.js"></script>
<script>
	document.querySelector('.user_edit').addEventListener('submit', function (e) {
        document.querySelectorAll('input[type="text"], textarea').forEach(function(element){
            if(!element.value){
                e.preventDefault();
                element.classList.add('error');
            }
        });
    });
</script>