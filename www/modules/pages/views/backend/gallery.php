<section class="edit_gallery_main">
    <div class="wrapper">
        <a class="btn_add_img" href="/admin/gallery/add"><i class="fa fa-plus"></i> Add new</a>
        <div class="flex_gallery">
            <?php foreach ($images as $image):?>
                <div class="flex_item">
                    <a href="/admin/gallery/edit/<?php echo $image['id']; ?>">
                        <img src="/<?php echo $image['thumb']; ?>">
                    </a>
                    <a class="btn_edit_img" href="/admin/gallery/edit/<?php echo $image['id']; ?>"><i class="fa fa-pencil"></i> Edit</a>
                    <a class="btn_delete_img" href="/admin/gallery/delete/<?php echo $image['id']; ?>"><i class="fa fa-minus"></i> Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>