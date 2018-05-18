<?php
$pageTitle = "Produkter";
include("../assets/incl/header.php");
if (isset($_GET['p']) && $_GET['p'] > 0) {
    $product = $productsClass;
    $product->getProduct($_GET['p']);
    $commentCount = $commentsClass->commentCount($product->id);
    $ingrList = $ingredientsClass->getIngredients($_GET['p']);
    $comments = $commentsClass->getComments($_GET['p']);
    $pagination = $paginationClass->paginationTable(3, "comment", $product->id);
} else {
    header("Location: list.php");
}
if (isset($_POST['savecomment'])) {
    $commentsClass->user_id = $auth->auth_user_id;
    $commentsClass->product_id = $product->id;
    $commentsClass->content = $_POST['content'];
    $commentsClass->save();
    header("Location: details.php?p=$product->id&page=1");

}
if (isset($_POST['deletecomment'])) {
    $commentsClass->id = $_POST['commentid'];
    $commentsClass->delete($commentsClass->id);
    header("Location: details.php?p=$product->id&page=1");
}
?>
<article class="product">
    <div class="product_nav">
        <a class="product_nav_previous" href="/product/list.php">Produkter</a> <span class="product_nav_arrow"> > </span> <a class="product_nav_current" href="/product/details.php?p=<?=$product->id?>"><?=$product->name?></a>
    </div>
    <div class="product_header">
        <div class="product_header_text">
            <h1><?=$product->name?></h1>
            <h4><?=$product->category_name?></h4>
        </div>
        <div class="product_header_btn">
            <a href="">LIKE! <i class="far fa-heart"></i></a>
        </div>
    </div>
    <div class="product_content">
        <div class="product_content_text">
            <img src="/assets/images/products/<?=$product->image?>" alt="image-of-<?=$product->name?>">
            <p><?=$product->description?></p>
        </div>
        <div class="product_content_ingr">
            <h5 class="product_h5">Ingredienser</h5>
            <ul>
            <?php if (!empty($ingrList)) : ?>
                <?php foreach($ingrList as $ingr) : ?>
                    <li><?=$ingr['amount']?><?=$ingr['measure_name']?>. <?=$ingr['name']?></li>
                <?php endforeach; ?>
                <?php else : ?>
                    <li>Ingen ingredienser tilføjet</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="product_comments">
        <div class="product_comments_container product_comments_header">
            <h5 class="product_h5">kommentarer</h5>
            <small><?=$commentCount?> <i class="far fa-comments"></i></small>
        </div>
        <?php if ($auth->auth_role !== "guest") : ?>
            <form method="post">
                <div class="product_comments_input_container">
                    <i class="material-icons">edit</i>
                    <input type="text" name="content" placeholder="fortæl os hvad du synes...">
                </div class="product_comments_input">
                <button type="submit" name="savecomment">Indsæt</button>
            </form>
        <?php endif; ?>
        <div class="product_comments_list">
            <?php foreach($pagination as $comment) : ?>
                <div class="product_comments_list_container" name="comment<?=$product->id?>">
                    <div class="product_comments_list_container_image" style="background-image:url('/assets/images/avatars/<?=$comment['avatar'] !== null ? $comment['avatar'] : "placeholder.png"?>')">
                    </div>
                    <div class="product_comments_list_container_text">
                        <h4><?=$comment['firstname']?> <?=$comment['lastname']?></h4>
                        <small><?=$comment['created_at']?></small>
                        <p><?=$comment['content']?></p>
                        <?php if ($comment['user_id'] == $auth->auth_user_id) : ?>
                            <form id="deletecomment" method="post" style="display:block">
                                <input type="hidden" name="commentid" value="<?=$comment['id']?>">
                                <button style="padding:0;background:none" type="submit" name="deletecomment"><i style="font-size:1.2rem;color:black" class="material-icons">delete</i></button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?=$paginationClass->paginationLinks()?>
        </div>
    </div>
</article>
<?php
if (isset($_GET['page'])) {
    echo '
    <script>
        $("html, body").animate({
            scrollTop: $(".product_comments").offset().top
        }, "slow");
    </script>
    ';
}
include("../assets/incl/footer.php");