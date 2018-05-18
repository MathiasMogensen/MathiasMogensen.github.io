<?php
require "incl/cms_init.php";
?>
<?php if ($auth->auth_role == 'admin' || $auth->auth_role == 'user') : ?>
<?php
$user = new user();
$user->getuser($auth->auth_user_id);

$mode = isset($_REQUEST["mode"]) && !empty($_REQUEST["mode"]) ? $_REQUEST["mode"] : "";

switch(strtoupper($mode)) {

    default:
    case "EDIT":

    require DOCROOT . "/cms/incl/header.php";
?>
<!-- Form (start) -->
<?php
    if (isset($_GET['id'])) {
        $product->getProduct($_GET['id']);
        $productIngredientsList = $ingredient->getIngredients($_GET['id']);
        $ingredients = $ingredient->getAllIngredients();
        $measures = $product->getAllMeasures();
    }
?>
    <div class="container card">
      <form action="?mode=save" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?=$user->id?>">
          <div class="form-group">
              <label for="firstname">Fornavn</label>
              <input class="form-control" type="text" name="firstname" value="<?=$user->firstname?>">
          </div>
          <div class="form-group">
              <label for="lastname">Efternavn</label>
              <input class="form-control" type="text" name="lastname" value="<?=$user->lastname?>">
          </div>
          <div class="form-group">
              <label for="file">Avatar</label>
              <input class="form-control" type="file" name="file" accept="image/*">
          </div>
          <input type="submit" name="submit" value="Opdatér Profil">
      </form>
    </div>
  <!-- Form (end) -->

<?php
break;

    //  DELETE PRODUCT
    case "DELETE":

    if (isset($_GET['id'])) {
        $product->delete($_GET['id']);
        header("Location: ?mode=list");
    }
break;


    //  SAVE/UPDATE PRODUCT
    case "SAVE":

    $user->id = $_POST['id'];
    $user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];

    if (!empty($_POST['id'])) {
        $user->save($_POST['id'], 'assets/images/avatars/');
    } else {
        $user->save(0, 'assets/images/avatars/');
    }

    header("Location: profile.php");
}
?>

<?php else :
    header("Location: index.php");
?>
<?php endif; ?>

	<script src="https://cdn.rawgit.com/SanderSalamander/md-admin/master/scripts/mdjs.js"></script>
