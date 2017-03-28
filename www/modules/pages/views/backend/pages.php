<section class="edit_page_main">
    <div class="wrapper">
        <ul>
            <li>
                <strong>Pages List</strong>
                <strong>Options List</strong>
            </li>
            <?php foreach ($pages as $page): ?>
                <li>
                    <a target="_blank" href="/page/<?php echo $page['alias']?>"><?php echo $page['main_title']?></a>
                    <a href="/admin/page/edit/<?php echo $page['id']?>">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>