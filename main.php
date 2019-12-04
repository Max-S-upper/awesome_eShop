<?php 
$products = include("products.php");
include("classes/Products.php");
$product = new Products($products);
?>
<main>
    <h1 class="products-header">Products:</h1>
    <section class="products">
        <?php foreach($products as $name => $val): ?>
            <a href="" class="product">
                <img src="images/<?= $val['picture'] ?>" alt="<?= $name ?>">
                <span class="name"><?= $name ?></span>
                <span class="quantity">Available:<?= $val['quantity'] ?></span>
                <span class="price"><?= $val['price'] ?>₴</span>
            </a>
        <?php endforeach; ?>
        <?php
        try {
            $product->get_product('test');
        } catch (Product_id_not_exists $e) {
            echo $e->getMessage();
        }

        try {
            echo '<br>';
            print_r($product->get_product('Supernatural T-shirt'));
        } catch (Product_id_not_exists $e) {
            echo $e->getMessage();
        }
        ?>
    </section>
</main>