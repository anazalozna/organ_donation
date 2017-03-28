<?php if ($showSuccess): ?>
    <div class="wrapper_small">
        <h3>Changes were saved</h3>
    </div>
<?php endif; ?>
<section class="changes_main">
    <h2 class="hide">Changes page</h2>
    <div class="wrapper_small">
        <h2 class="title_h2">Change Your Data</h2>
        <div class="form_main">
            <form id="change" method="post" class="form_cont">
                <label for="new_email">New Email</label>
                <input name="email" type="email" id="new_email" maxlength="90" value="<?php echo $email; ?>">
                <label for="new_pass">New Password</label>
                <input name="password" type="password" id="new_pass">
                <input type="submit" value="Save">
            </form>
        </div>
        <ul class="errors_style">
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>