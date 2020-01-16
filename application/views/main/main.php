<main class="center-page">
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
                    </p>
                    <a href="http://eshop.com/show/<?= $product->id ?>">
                        <img src="/public/images/<?= $product->image ?>" alt="<?= $product->title ?>">
                    </a>
                    <p class="name">
                        <a href="http://eshop.com/show/<?= $product->id ?>"><?= $product->title ?></a>
                    </p>
                    <?php foreach($product->attributes as $attribute) : ?>
                        <span class="attributes">Attributes: <?= $attribute->title ?></span>
                    <?php endforeach; ?>
                    <span class="quantity">Available: <?= $product->quantity ?></span>
                    <span class="price"><?= $product->price ?>₴</span>
                </div>
            <?php endforeach; ?>
    </section>
</main>