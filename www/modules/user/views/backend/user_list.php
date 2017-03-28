<section id="users" >
    <h2 class="hide">Users List</h2>
    <div class="wrapper">
        <h2 class="title_h2">Users List</h2>
        <ul id="errors" class="errors_style"></ul>
        <p id="success">User has been added</p>
        <p id="loading">Loading</p>
        <form class="users_form" method="post" action="user/add">
            <table class="users_table">
                <thead>
                <tr>
                    <th>login</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($userList  as $user): ?>
                    <tr>
                        <td><?php echo $user['login']?></td>
                        <td><?php echo $user['mail']?></td>
                        <td><?php echo $user['role']?></td>
                        <td><a href="/admin/user/delete/<?php echo $user['id']?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><input type="text" name="login[]" maxlength="30"></td>
                    <td><input type="email" name="email[]" maxlength="90"></td>
                    <td>
                        <select name="role[]">
                            <option></option>
                            <?php foreach ($roles  as $role): ?>
                                <option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><a class="new_user add" href="#" onclick="addNewRow()">+</a></td>
                </tr>
                </tbody>
            </table>
            <div>
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
</section>
<script type="text/javascript" src="<?php echo Config::get('global')['js_dir']?>backend/new_user.js"></script>