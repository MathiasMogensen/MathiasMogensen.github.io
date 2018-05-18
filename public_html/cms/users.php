<?php
require "incl/cms_init.php";
$user = new user();
$roles = $user->getRoles();
$users = $user->getUsers();
/* - Head, Header & Body (start) - */
require DOCROOT . "cms/incl/header.php";
?>
Create user
<form method="post">
    <input name="username" type="text" placeholder="Username">
    <input name="password" type="password" placeholder="Password">
    <select name="role">
        <?php foreach ($roles as $role) : ?>
            <option value="<?=$role['id']?>"><?=$role['name']?></option>
        <?php endforeach; ?>
    </select>
    <button name="submit" type="submit">Create</button>
</form>

<div class="container">
    <table class="table">
        <thead>
            <th>Username</th>
            <th>Role</th>
        </thead>
        <tbody>
            <?php foreach ($users as $arrvalue) : ?>
                <tr>
                    <td><?=$arrvalue['name']?></td>
                    <td><?=$arrvalue['role']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
if (isset($_POST['submit'])) {
    $user->saveUser();
}