<?php
require "incl/cms_init.php";
?>
<?php if ($auth->auth_role == 'admin') : ?>
<?php
$product = new products();
$category = new categories();
$ingredient = new ingredients();
$categories = $category->getCategories();
$products = $product->getProducts();

$mode = isset($_REQUEST["mode"]) && !empty($_REQUEST["mode"]) ? $_REQUEST["mode"] : "";

switch(strtoupper($mode)) {

    // LIST OF PRODUCTS
    default:
    case "LIST":
    require DOCROOT . "/cms/incl/header.php";
?>
    <div class="container card"style="padding-left:16px">
    <div class="table__header">
      <ul class="header__list--left">
        <li><h2 class="header__title">Products</h2></li>
      </ul>
      <ul class="header__list--right">
        <li><a href="?mode=edit&id=-1" class="button__icon"><i class="material-icons">add</i></a></li>
      </ul>
      <div class="header__contextual" id="contextual">
        <ul class="header__list--left">
          <p></p>
        </ul>
      </div>
    </div>
        <table class="table--embedded">
            <thead>
                <!-- <th class="row__select"><div class="checkbox__group"><input type="checkbox" class="checkbox checkbox-master" data-contextual="contextual" /></div></th> -->
                <th scope="col">ID</th>
                <th scope="col">Navn</th>
                <th scope="col">Kategori</th>
                <th scope="col">Oprettet</th>
                <th scope="col"></th>
            </thead>
            <?php foreach ($products as $product) : ?>
                <tbody>
                    <tr scope="row">
                        <!-- <td class="row__select"><div class="checkbox__group"><input type="checkbox" class="checkbox" data-contextual="contextual" /></div></td> -->
                        <td><?=$product['id']?></td>
                        <td><?=$product['name']?></td>
                        <td><?=$product['category_name']?></td>
                        <td><?=date("d. M h:m", strtotime($product['created_at']))?></td>
                        <td><a href="?mode=edit&id=<?=$product['id']?>"><i class="material-icons">edit_mode</i></a>
                        <a href="?mode=delete&id=<?=$product['id']?>"><span class="product-delete" id="<?=$product['name']?>"><i class="material-icons">delete</i></span></a></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </>
<script>
    $(document).ready(function() {
        $(".product-delete").click(function() {
            return confirm("Vil du slette " + this.id + "?");
        });
    });
</script>
<?php
break;

    //EDIT OR CREATE PRODUCT
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
          <input type="hidden" name="id" value="<?=$product->id?>">
          <div class="form-group">
              <label for="name">Navn</label>
              <input class="form-control" type="text" name="name" value="<?=$product->name?>">
          </div>
          <div class="form-group">
              <label for="description">Beskrivelse</label><br>
              <textarea class="form-control" name="description" rows="5" cols="40"><?=$product->description?></textarea>
          </div>
            <div class="form-group">
                <label for="catergory">Kategori</label>
                <select class="form-control" name="category">
                    <?php foreach ($categories as $category) : ?>
                        <?php if ($category['id'] == $product->category_id) : ?>
                            <option selected value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php else : ?>
                            <option value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
          <div class="form-group">
              <input class="form-control" type="file" name="file" accept="image/*">
          </div>
          <input type="submit" name="submit" value="<?=isset($_GET['id']) && $_GET['id'] < 1 ? "Opret Produkt" : "Opdatér Produkt" ?>">
      </form>
        <?php if ($_GET['id'] > 0) : ?>
            <form action="?mode=saveingr" method="post">
            <input type="hidden" name="id" value="<?=$product->id?>">
                    <div class="form-group">
                        <label for="amount">Mængde</label>
                        <input class="form-control" type="number" name="amount">
                    </div>
                    <div class="form-group">
                        <label for="measure">Enhed</label>
                        <select class="form-control" name="measure">
                            <?php foreach ($measures as $measure) : ?>
                                <option value="<?=$measure['id']?>"><?=$measure['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ingredient">Ingrediens</label>
                        <select class="form-control" name="ingredient">
                            <?php foreach ($ingredients as $ingredient) : ?>
                                <option value="<?=$ingredient['id']?>"><?=$ingredient['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="submit" name="submit" value="Tilføj Ingrediens">
            </form>
            <table class="table--embedded">
                <thead>
                    <!-- <th class="row__select"><div class="checkbox__group"><input type="checkbox" class="checkbox checkbox-master" data-contextual="contextual" /></div></th> -->
                    <th scope="col">Mængde</th>
                    <th scope="col">Enhed</th>
                    <th scope="col">Ingrediens</th>
                    <th scope="col"></th>
                </thead>
                <?php foreach ($productIngredientsList as $productIngredient) : ?>
                    <tbody>
                        <tr scope="row">
                            <!-- <td class="row__select"><div class="checkbox__group"><input type="checkbox" class="checkbox" data-contextual="contextual" /></div></td> -->
                            <td><?=$productIngredient['amount']?></td>
                            <td><?=$productIngredient['measure_name']?></td>
                            <td><?=$productIngredient['name']?></td>
                            <td><a href="?mode=deleteingr&productId=<?=$product->id?>&id=<?=$productIngredient['id']?>"><span class="product-delete" id="<?=$productIngredient['name']?>"><i class="material-icons">delete</i></span></a></td>
                        </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
  <!-- Form (end) -->

<?php
break;

    //  DELETE INGREDIENT
    case "DELETEINGR":

    if (isset($_GET['id'])) {
        $product->deleteingr($_GET['id']);
        header("Location: ?mode=edit&id=". $_GET['productId'] ."");
    }
break;

    //  SAVE/UPDATE INGREDIENT
    case "SAVEINGR":

    $product->id = $_POST['id'];
    $product->ingrAmount = $_POST['amount'];
    $product->ingrId = $_POST['ingredient'];
    $product->measureId = $_POST['measure'];

    if (!empty($_POST['id'])) {
        $product->saveingr($product->id);
    } else {
        $product->saveingr(0);
    }

    header("Location: products.php?mode=edit&id=". $product->id ."");
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

    $product->id = $_POST['id'];
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category'];

    if (!empty($_POST['id'])) {
        $product->save($product->id, 'assets/images/products/');
    } else {
        $product->save(0, 'assets/images/products/');
    }

    header("Location: products.php");
}
?>

<?php else :
    header("Location: index.php");
?>
<?php endif; ?>

	<script src="https://cdn.rawgit.com/SanderSalamander/md-admin/master/scripts/mdjs.js"></script>
