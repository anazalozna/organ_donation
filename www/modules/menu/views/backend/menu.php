<nav class="control_menu">
    <div class="wrapper">
        <label for="mobile_nav" class="mobile_nav_label"><i class="fa fa-bars"></i></label>
        <input type="checkbox" id="mobile_nav">
        <ul class="flex_control_menu">
            <?php foreach ($menuList as $item): ?>
                <li><a href="<?php echo $item['link'];?>"><?php echo $item['name'];?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>