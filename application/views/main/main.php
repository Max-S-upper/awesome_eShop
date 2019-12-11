<main>
    <h1 class="products-header">Products:</h1>
    <section class="products">
        <?php
        foreach($products as $name => $val): ?>
            <a href="http://eshop.com/show/<?= $val['id'] ?>" class="product">
                <img src="/public/images/<?= $val['picture'] ?>" alt="<?= $name ?>">
                <span class="name"><?= $name ?></span>
                <span class="quantity">Available:<?= $val['quantity'] ?></span>
                <span class="price"><?= $val['price'] ?>₴</span>
            </a>
        <?php endforeach; ?>
    </section>
</main>