<?php
require_once ROOT . '/application/views/includes/head.php';
require_once ROOT.'/application/views/includes/wrapper.php';
if ($usr_email) include(ROOT.'/application/views/includes/header_signed.php');
else require_once ROOT . '/application/views/includes/header.php';
require_once ROOT . '/application/views/includes/signInPopUp.php';
require_once ROOT.'/application/views/includes/search.php';
?>
<main class="center-page">
    <?= $categories ?>
    <?= $filters ?>
    <section class="products">
        <?php if ($err): ?>
            <div class="errors emphasized-container">
                <p><?= $err ?></p>
            </div>
        <?php endif; ?>
        <?php foreach ($products as $product): ?>
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
    </section>
    <?= $pagination ?>
</main>
<?php
require_once ROOT.'/application/views/includes/footer.php';
?>