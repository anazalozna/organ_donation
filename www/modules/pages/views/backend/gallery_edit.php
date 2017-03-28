<div class="wrapper edit_single_image">

    <form class="save_image" method="post" enctype="multipart/form-data">
        <label>New Title</label>
        <input type="text" value="<?php echo $title?>" name="title">
        <p>Current Image</p>
        <img src="/<?php echo $thumb?>">
        <label>New Image</label>
        <input type="file" name="img">
        <label>New Description</label>
        <textarea name="text"><?php echo $text?></textarea>
        <input type="submit">
    </form>
    <ul>
        <?php foreach ($errors as $error):?>
            <li><?php echo $error ?></li>
        <?php endforeach;?>
    </ul>
    <a class="btn_delete_img" href="/admin/gallery/delete/<?php echo $id; ?>"><i class="fa fa-minus"></i> Delete</a>
</div>

<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/editor.js"></script>
<script>
    document.querySelector('.save_image').addEventListener('submit', function (e) {
        tinyMCE.triggerSave();
        document.querySelectorAll('input[type="text"], textarea').forEach(function(element){
            if(!element.value){
                e.preventDefault();
                element.classList.add('error');
            }
        });
    })
</script>