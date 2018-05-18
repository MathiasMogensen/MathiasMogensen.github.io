<?php
$pageTitle = "Registrer";
include("../assets/incl/header.php");
?>

<?php if (!$auth->auth_user_id) : ?>
<section class="login">
    <div class="login-header">
        <h1>Registrer</h1>
    </div>
        <form id="formRegister" class="login-form" method="post">
            <div class="form-group">
                <label for="firstname">Fornavn</label>
                <input id="firstname" class="form-control" type="text" name="firstname" value="<?=$auth->auth_register_firstname?>"> 
            </div>
            <div class="form-group">
                <label for="lastname">Efternavn</label>
                <input id="lastname" class="form-control" type="text" name="lastname" value="<?=$auth->auth_register_lastname?>">
            </div>
            <div class="form-group">
                <label for="register_user_name">Email</label>
                <input id="email" class="form-control" type="text" name="register_user_name" value="<?=$auth->auth_register_user_name?>" style="<?=$auth->errorMsg == "Bruger eksisterer allerede" ? "border: 1px solid red" : "" ?>">
                <span style="color:red"><?=$auth->errorMsg?></span>
            </div>
            <div class="form-group">
                <label for="register_password">Kodeord</label>
                <input id="password" class="form-control" type="password" name="register_password">
            </div>
            <div class="form-group">
                <label for="confirm_register_password">Godkend Kodeord</label>
                <input id="confirm_password" class="form-control" type="password" name="confirm_register_password">
            </div>
            <div class="login-control">
                <button id="submitRegister" type="submit">Opret</button>
                <p>Allerede medlem? <a href="" data-toggle="modal" data-target="#loginModal">Login</a></p>
            </div>
        </form>
</section>
<?php else : ?>
    <?=header("Location: ../index.php")?>
<?php endif; ?>
<script>
    form = "#formRegister";
    
    $(form).on('submit', function(e) {
        
        e.preventDefault(); // Cancel the submit
        
        if (
            validateInput("#firstname", "Udfyld fornavn", "letters") &&
            validateInput("#lastname", "Udfyld efternavn", "letters") &&
            validateInput("#email", "Udfyld e-mail", "email") &&
            validatePasswords("#password", "#confirm_password", "Udfyld kodeord", "Kodeordene er ikke ens")
        ) 
        { $(form)[0].submit(); }
    });
</script>
<?php
include("../assets/incl/footer.php");
?>