<?php
$pageTitle = "Produkter";
include("../assets/incl/header.php");
$products = new products();
if (isset($_GET['s'])) {
    if (isset($_GET['c'])) {
        $productsList = $products->searchProductsByCategory($_GET['c'], $_GET['s']);
    } else {
        $productsList = $products->searchProducts($_GET['s']);
    }
} else if (isset($_GET['c'])) {
    $productsList = $products->getProductsByCategory($_GET['c']);
} else {
    $productsList = $products->getProducts();
}
$category = new categories();
$categories = $category->getCategories();
$comments = new comments();
?>
<!-- If search query set -->
<?php if (isset($_GET['s'])) : ?>
<section class="products_list">
    <div class="products_list_header">
        <h2>Vores elskede bagværk</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus ipsam repellendus pariatur voluptatibus magni voluptatem, molestiae eveniet! Porro voluptatem recusandae error, unde, corrupti minus rerum, iusto quas cum necessitatibus tempore.</p>
    </div>
    <div class="products_list_grid_wrapper">
        <?php if ($productsList) : ?>
            <ul class="products_list_menu">
                <?php foreach($categories as $category) : ?>
                    <li>
                        <a class="
                            <?=isset($_GET['c']) && $_GET['c'] == $category['id'] ? "active" : ""?>
                            "href="<?=isset($_GET['s']) ? "?s=".$_GET['s']."&c=".$category['id']."" : "?c=".$category['id'].""?>">
                            <?=$category['name']?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="products-grid products_list_grid">
                    <?php foreach($productsList as $product) : ?>
                    <?php $commentCount = $comments->commentCount($product['id']) ?>
                        <div class="products-grid-item">
                            <div class="products-grid-item-image">
                                <img src="/assets/images/products/<?=$product['image']?>">
                            </div>
                            <div class="products-grid-item-text">
                                <small><?=$commentCount?> <i class="far fa-comments"></i></small>
                                <h6><?=$product['name']?></h6>
                                <p><?=$product['description']?></p>
                                <a href="/product/details.php?p=<?=$product['id']?>">se mere</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p style="font-size:2rem">Din søgning gav ingen resultat</p>
            <?php endif; ?>
        </div>
</section>

<!-- If search query is NOT set -->
<?php else : ?> 
<section class="products_list">
    <div class="products_list_header">
        <h2>Vores elskede bagværk</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus ipsam repellendus pariatur voluptatibus magni voluptatem, molestiae eveniet! Porro voluptatem recusandae error, unde, corrupti minus rerum, iusto quas cum necessitatibus tempore.</p>
    </div>
    <div class="products_list_grid_wrapper">
        <ul class="products_list_menu">
            <?php foreach($categories as $category) : ?>
                <li>
                    <a class="
                    <?=isset($_GET['c']) && $_GET['c'] == $category['id'] ? "active" : ""?>
                    " href="?c=<?=$category['id']?>"><?=$category['name']?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="products-grid products_list_grid">
            <?php foreach($productsList as $product) : ?>
            <?php $commentCount = $comments->commentCount($product['id']) ?>
                <div class="products-grid-item">
                    <div class="products-grid-item-image">
                        <img src="/assets/images/products/<?=$product['image']?>">
                    </div>
                    <div class="products-grid-item-text">
                        <small><?=$commentCount?> <i class="far fa-comments"></i></small>
                        <h6><?=$product['name']?></h6>
                        <p><?=$product['description']?></p>
                        <a href="/product/details.php?p=<?=$product['id']?>">se mere</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php 
include("../assets/incl/footer.php");