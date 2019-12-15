<main>
    <h1 class="products-header">Products:</h1>
    <section class="product">
            <a href="http://eshop.com/show/<?= $product->id ?>" class="product">
                <img src="/public/images/<?= $product->picture ?>" alt="<?= $product->name ?>">
                <span class="name"><?= $product->name ?></span>
                <span class="quantity">Available:<?= $product->quantity ?></span>
                <span class="price"><?= $product->price ?>₴</span>
            </a>
    </section>
</main>