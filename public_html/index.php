<?php
$pageTitle = "Forside";
include("assets/incl/header.php");
$products = $productsClass->getProductsLimit(8);
?>

<section class="section_carousel">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-image" style="background-image:url('/assets/images/slider/slide1.jpg')"></div>
                <div class="carousel-caption d-md-block">
                    <h3>Vi elsker at lave brød</h3>
                </div>
            </div>
            <div class="carousel-item">
            <div class="carousel-image" style="background-image:url('/assets/images/slider/slide2.jpg')"></div>
                <div class="carousel-caption d-md-block">
                    <h3>Vi elsker at lave brød</h3>
                </div>
            </div>
            <div class="carousel-item">
            <div class="carousel-image" style="background-image:url('/assets/images/slider/slide3.jpg')"></div>
                <div class="carousel-caption d-md-block">
                    <h3>Vi elsker at lave brød</h3>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <i class="fas fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <i class="fas fa-angle-right"></i>
        </a>
    </div>
</section>
<section class="section_article">
    <article class="article">
        <div class="article-header">
            <h4>Vi skaber lækkert brød!</h4>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur excepturi officia non velit fugit, officiis reiciendis? Iste recusandae nihil molestias.</p>
        </div>
        <div class="article-images">
            <div class="article-image">
                <img src="/assets/images/article/article.jpg" alt="">
                <div class="article-text">
                    <h5>kreativitet dyrkes</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, corporis.</p>
                </div>
            </div>
            <div class="article-image">
                <img src="/assets/images/article/article2.jpg" alt="">
                <div class="article-text">
                    <h5>vi elsker brød</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, corporis.</p>
                </div>
            </div>
            <div class="article-image">
                <img src="/assets/images/article/article3.jpg" alt="">
                <div class="article-text">
                    <h5>sans for detaljer</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, corporis.</p>
                </div>
            </div>
        </div>
</article>
</section>

<section class="section_newsletter">
    <div class="newsletter-wrapper">
        <div class="newsletter-header">
            <h4>Tilmeld dig vores nyhedsbrev</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, aliquam.</p>
        </div>
        <form id="formNewsletter" class="newsletter" action="" method="post">
            <div class="newsletter-input-wrapper">
                <span class="newsletter-email-icon"><i class="far fa-envelope"></i></span>
                <input class="newsletter-email-input" id="email" type="text" name="email" placeholder="Indtast din email...">
                <button class="newsletter-email-btn" type="submit" name="submitnl">tilmeld</button>
            </div>
        </form>
    </div>
</section>

<section class="section_products">
    <div class="products">
        <div class="products-header">
            <h4>Nyeste Bagværk</h4>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio consectetur odit doloribus voluptates excepturi? Est asperiores quos reprehenderit eaque labore.</p>
        </div>
        <div class="products-grid">
            <?php foreach($products as $product) : ?>
            <?php $commentCount = $commentsClass->commentCount($product['id']) ?>
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

<!-- NEWSSLETTER SIGNUP AJAX -->
<script>
    form = "#formNewsletter";
    
    $(form).on('submit', function(e) {
        
        e.preventDefault(); // Cancel the submit
        
        if (
            validateInput("#email", "Udfyld e-mail") &&
            validateEmail("#email", "Ugyldig e-mail")
        ) 
        { livequery(".newsletter", false, "/assets/ajax/newsletter.php"); }
    });
</script>

<?php
include("assets/incl/footer.php");