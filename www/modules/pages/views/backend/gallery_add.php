<section class="edit_single_image">
    <div class="wrapper">
        <form class="add_image" method="post" enctype="multipart/form-data">
            <label>New Title</label>
            <input type="text" name="title">
            <label>Add Image</label>
            <input type="file" name="img">
            <label>Description</label>
            <textarea name="text"></textarea>
            <input type="submit">
        </form>
        <ul>
		    <?php foreach ($errors as $error):?>
                <li><?php echo $error ?></li>
		    <?php endforeach;?>
        </ul>
    </div>
</section>


<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/editor.js"></script>
<script>
    document.querySelector('.add_image').addEventListener('submit', function (e) {
        tinyMCE.triggerSave();
        document.querySelectorAll('input:not([type="submit"]), textarea').forEach(function(element){
            if(!element.value){
                e.preventDefault();
                element.classList.add('error');
            }
        });
    })
</script>