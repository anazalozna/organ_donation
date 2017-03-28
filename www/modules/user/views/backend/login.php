<section class="login_main">
    <h2 class="hide">Login page</h2>
    <div class="wrapper_small">
        <?php if($showForm): ?>
            <h2 class="title_h2">Admin Control Panel</h2>
            <div class="form_main">
                <form method="post" action="" class="form_cont">
                    <label for="login_label">Your Login</label>
                    <input type="text" name="login" id="login">

                    <label for="pass_label">Your Password</label>
                    <input type="password" name="password" id="pass">

                    <input type="submit">
                </form>
            </div>
        <?php endif; ?>
        <ul class="errors_style">
		    <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
		    <?php endforeach; ?>
        </ul>
    </div>
</section>
