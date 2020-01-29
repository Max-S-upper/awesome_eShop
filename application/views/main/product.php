<?php
require_once ROOT . '/application/views/includes/head.php';
require_once ROOT.'/application/views/includes/wrapper_product.php';
if ($usr_email) require_once ROOT.'/application/views/includes/header_signed.php';
else require_once ROOT . '/application/views/includes/header.php';
require_once ROOT . '/application/views/includes/signInPopUp.php';
require_once ROOT . '/application/views/includes/orderPopUp.php';
require_once ROOT . '/application/views/includes/messagePopUp.php';
require_once ROOT.'/application/views/includes/search.php';
?>
<main>
    <section class="emphasized-container">
        <form method="post" class="product-container">
            <div class="single-product-image">
                <p class="brand">
                    <a href="http://eshop.com/brand/<?= $product->brand_id ?>"><?= $product->brand ?></a>
                </p>
                <img src="/public/images/<?= $product->image ?>" alt="<?= $product->title ?>">
            </div>
            <div class="single-product-data" data-product-id="<?= $product->id ?>">
                <p class="name">
                    <h1><?= $product->title ?></h1>
                </p>
                <p class="quantity">
                    <span>Available:<?= $product->quantity ?></span>
                </p>
                <p class="description">
                    <span><?= $product->description ?></span>
                </p>
                <p class="price">
                    <span><?= $product->price ?>₴</span>
                </p>
                <p class="attributes">
                    Attributes:
                    <?php
                    if (count($product->attributes) > 1):
                        foreach($product->attributes as $attribute) : ?>
                            <span data-attribute-id="<?= $attribute->id ?>">
                                <?= $attribute->title ?>,
                            </span>
                        <?php endforeach;
                    endif;
                    if (count($product->attributes) === 1): ?>
                        <span data-attribute-id="<?= $product->attributes->id ?>">
                            <?= $product->attributes->title ?>,
                        </span>
                    <?php endif; ?>
                </p>
                <div class="actions-container">
                    <input id="buy-product" type="submit" class="hidden" name="buy-product" value="<?= $product->id ?>">
                    <label for="buy-product" class="buy-product">Buy</label>
                    <p class="button-primary add-to-cart-btn">Add to cart</p>
                </div>
            </div>
        </form>
        <div class="comments-container">
            <form action="" method="post">
                <div class="rating-container">
                    <span class="rating-star">
                        <svg viewBox="0 0 40 37" class="rating-star">
                            <path d="m19.1147.533962c.3614-.711949 1.409-.711949 1.7704 0l5.4156 10.644638c.1443.283.4223.479.7439.524l12.1088 1.7076c.81.1143 1.1331 1.0805.5478 1.634l-8.7633 8.2861c-.2322.2197-.3389.5373-.2833.8476l2.0679 11.7c.139.7827-.7078 1.3797-1.433 1.0097l-10.8297-5.5231c-.2878-.1467-.632-.1467-.9198 0l-10.83049 5.5231c-.72439.37-1.57126-.227-1.43225-1.0097l2.06797-11.7c.05485-.3103-.0511-.6279-.28405-.8476l-8.761789-8.2861c-.586123-.5535-.2630038-1.5197.547049-1.634l12.10946-1.7076c.3209-.045.5996-.241.7432-.524z"></path>
                        </svg>
                    </span>
                    <span class="rating-star">
                        <svg viewBox="0 0 40 37" class="rating-star">
                            <path d="m19.1147.533962c.3614-.711949 1.409-.711949 1.7704 0l5.4156 10.644638c.1443.283.4223.479.7439.524l12.1088 1.7076c.81.1143 1.1331 1.0805.5478 1.634l-8.7633 8.2861c-.2322.2197-.3389.5373-.2833.8476l2.0679 11.7c.139.7827-.7078 1.3797-1.433 1.0097l-10.8297-5.5231c-.2878-.1467-.632-.1467-.9198 0l-10.83049 5.5231c-.72439.37-1.57126-.227-1.43225-1.0097l2.06797-11.7c.05485-.3103-.0511-.6279-.28405-.8476l-8.761789-8.2861c-.586123-.5535-.2630038-1.5197.547049-1.634l12.10946-1.7076c.3209-.045.5996-.241.7432-.524z"></path>
                        </svg>
                    </span>
                    <span class="rating-star">
                        <svg viewBox="0 0 40 37" class="rating-star">
                            <path d="m19.1147.533962c.3614-.711949 1.409-.711949 1.7704 0l5.4156 10.644638c.1443.283.4223.479.7439.524l12.1088 1.7076c.81.1143 1.1331 1.0805.5478 1.634l-8.7633 8.2861c-.2322.2197-.3389.5373-.2833.8476l2.0679 11.7c.139.7827-.7078 1.3797-1.433 1.0097l-10.8297-5.5231c-.2878-.1467-.632-.1467-.9198 0l-10.83049 5.5231c-.72439.37-1.57126-.227-1.43225-1.0097l2.06797-11.7c.05485-.3103-.0511-.6279-.28405-.8476l-8.761789-8.2861c-.586123-.5535-.2630038-1.5197.547049-1.634l12.10946-1.7076c.3209-.045.5996-.241.7432-.524z"></path>
                        </svg>
                    </span>
                    <span class="rating-star">
                        <svg viewBox="0 0 40 37" class="rating-star">
                            <path d="m19.1147.533962c.3614-.711949 1.409-.711949 1.7704 0l5.4156 10.644638c.1443.283.4223.479.7439.524l12.1088 1.7076c.81.1143 1.1331 1.0805.5478 1.634l-8.7633 8.2861c-.2322.2197-.3389.5373-.2833.8476l2.0679 11.7c.139.7827-.7078 1.3797-1.433 1.0097l-10.8297-5.5231c-.2878-.1467-.632-.1467-.9198 0l-10.83049 5.5231c-.72439.37-1.57126-.227-1.43225-1.0097l2.06797-11.7c.05485-.3103-.0511-.6279-.28405-.8476l-8.761789-8.2861c-.586123-.5535-.2630038-1.5197.547049-1.634l12.10946-1.7076c.3209-.045.5996-.241.7432-.524z"></path>
                        </svg>
                    </span>
                    <span class="rating-star">
                        <svg viewBox="0 0 40 37" class="rating-star">
                            <path d="m19.1147.533962c.3614-.711949 1.409-.711949 1.7704 0l5.4156 10.644638c.1443.283.4223.479.7439.524l12.1088 1.7076c.81.1143 1.1331 1.0805.5478 1.634l-8.7633 8.2861c-.2322.2197-.3389.5373-.2833.8476l2.0679 11.7c.139.7827-.7078 1.3797-1.433 1.0097l-10.8297-5.5231c-.2878-.1467-.632-.1467-.9198 0l-10.83049 5.5231c-.72439.37-1.57126-.227-1.43225-1.0097l2.06797-11.7c.05485-.3103-.0511-.6279-.28405-.8476l-8.761789-8.2861c-.586123-.5535-.2630038-1.5197.547049-1.634l12.10946-1.7076c.3209-.045.5996-.241.7432-.524z"></path>
                        </svg>
                    </span>
                </div>
                <div class="comment-area">
                    <textarea name="comment" placeholder="Type a comment"></textarea>
                    <input type="submit" name="comment-submit" class="button-primary" value="Send">
                </div>
            </form>
        </div>
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