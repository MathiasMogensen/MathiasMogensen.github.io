<?php
$pageTitle = "Login";
include("../assets/incl/header.php");
?>

<?php if (!$auth->auth_user_id) : ?>
<section class="login">
    <div class="login-header">
        <h1>Login</h1>
    </div>
        <form id="formLogin" class="login-form" method="post">
            <div class="form-group">
                <input class="form-control" id="email" type="text" name="login_user_name" placeholder="Din email..">
            </div>
            <div class="form-group">
                <input class="form-control" id="password" type="password" name="login_password" placeholder="Din kode..">
            </div>
            <div class="login-control">
                <button type="submit">Login</button>
                <p>Ikke medlem? <a href="/user/register.php">Opret Bruger</a></p>
            </div>
        </form>
        <span style="color:red"><?=$auth->errorMsg?></span>
</section>
<?php else : ?>
    <?=header("Location: ../index.php")?>
<?php endif; ?>
<?php
include("../assets/incl/footer.php");
?>