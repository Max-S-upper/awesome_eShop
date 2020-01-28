<?php
require_once ROOT . '/application/views/includes/head.php';
require_once ROOT.'/application/views/includes/wrapper_product.php';
if ($usr_email) require_once ROOT.'/application/views/includes/header_signed.php';
else require_once ROOT . '/application/views/includes/header.php';
require_once ROOT . '/application/views/includes/signInPopUp.php';
require_once ROOT.'/application/views/includes/search.php';
?>
    <main>
        <section class="emphasized-container">
            <form action="/order" method="post" class="product-container">
                <textarea name="note" placeholder="Comment to your order"></textarea>
            </form>
            <div class="alike-products">
                <?php foreach ($productsAlike as $product): ?>
                    <div class="product">
                        <p class="brand">
                            <a href="http://eshop.com/brand/<?= $product->brand_id ?>"><?= $product->brand ?></a>
                            <img src="/public/images/addToCart.png" class="add-to-cart" data-product-id="<?= $product->id ?>" alt="Add to cart">
                        </p>
                        <a href="http://eshop.com/show/<?= $product->id ?>">
                            <img src="/public/images/<?= $product->image ?>" alt="<?= $product->title ?>">
                        </a>
                        <p class="name">
                            <a href="http://eshop.com/show/<?= $product->id ?>"><?= $product->title ?></a>
                        </p>
                        <span class="price"><?= $product->price ?>₴</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
<?php
require_once ROOT.'/application/views/includes/footer.php';
?>