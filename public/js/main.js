$(document).ready(() => {
    $(".submit-container input[name=signUp]").click((e) => {
        e.preventDefault();
        let $err = [];
        if (!$(".name-container input").val()) $err.push("Please, enter your name.");
        if (!$(".surname-container input").val()) $err.push("Please, enter your surname.");
        if (!$(".email-container input").val()) $err.push("Please, enter your email.");
        if (!$(".password-container input[name=password]").val()) $err.push("Please, enter your password.");
        if (!$(".password-container input[name=confirm-password]").val()) $err.push("Please, confirm your password.");
        else if ($(".password-container input[name=confirm-password]").val() !== $(".password-container input[name=password]").val()) $err.push("Passwords don't much.");
        $(".errors-container").remove();
        let $errBlockHtml = `<div class="errors-container">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul>`;
        $($err).each(($i, $singleErrorData) => {
            $errBlockHtml += '<li>' + $singleErrorData + '</li>';
        });

        $errBlockHtml += `</ul>
                        </div>`;
        if (!$err[0]) $(".signUp form").submit();
        else $(".signUp form").prepend($errBlockHtml);
    });

    $(".pushLogin").click(() => {
        let $loginContainer = $(".login-container");
        $appearContainer($loginContainer);
    });

    let $appearContainer = ($container) => {
        $container.removeClass('hidden');
        setTimeout(() => $container.removeClass('transparent'), 100);
    };

    let $disappearContainer = ($container) => {
        $container.addClass('transparent');
        $container.on('transitionend webkitTransitionEnd oTransitionEnd', () => {
            $container.addClass('hidden');
            $container.off('transitionend webkitTransitionEnd oTransitionEnd');
        });
    };

    $(".close-login").click(() => $disappearContainer($(".login-container")));

    $(".login-submit").click(() => {
        let $email = $(".email-container input").val();
        let $password = $(".password-container input").val();
        $.ajax({
            url: 'http://eshop.com/authorization',
            type: 'post',
            data: {
                'email': $email,
                'password': $password
            },
            success: ($answer) => {
                if ($answer !== 'ok') {
                    let $errorsContent = `<strong>Whoops! Something went wrong.</strong>
                                            <ul>
                                                <li>${$answer}</li>
                                            </ul>`;
                    $(".login-container .errors-container").html($errorsContent);
                }

                else {
                    // $('header').remove();
                    let $cartCount = $(".cart-quantity").text();
                    $('header').load('http://eshop.com/application/views/includes/header_signed.php', function() {
                        setTimeout(() => $disappearContainer($(".login-container")), 100);
                        $(".cart-quantity").text($cartCount);
                        if ($cartCount) $(".cart-quantity").addClass('cart-quantity-active');
                        $("header .email").text($email);
                        $(".pushCart").click($showCartProducts);
                    });
                }
            },
            error: ($err) => {
                console.log(`Error: ${$err}`);
            }
        });
    });

    if (JSON.parse(localStorage.getItem('cart'))) {
        let $cartQuantityBlock = $(".cart-quantity");
        $cartQuantityBlock.text(JSON.parse(localStorage.getItem('cart')).length);
        $cartQuantityBlock.addClass("cart-quantity-active");
    }

    let $addToCart = function(e) {
        let $cartQuantityBlock = $(".cart-quantity");
        let $quantity = $cartQuantityBlock.text() ? $cartQuantityBlock.text() : 0;
        let $cart = JSON.parse(localStorage.getItem('cart'));
        let $curIdProduct = $(e.target).attr('data-product-id');
        let $increaseCartCounter = () => {
            $quantity++;
            if (!$cartQuantityBlock.hasClass("cart-quantity-active")) {
                $cartQuantityBlock.addClass("cart-quantity-active");
            }

            $cartQuantityBlock.text($quantity);
        };

        if ($cart) {
            let $isProductInCart = false;
            $($cart).each(($i, $cartItem) => {
                if ($cartItem['id'] === $curIdProduct) {
                    $cartItem['quantity'] = parseInt($cartItem['quantity']) + 1;
                    $isProductInCart = true;
                    return false;
                }
            });

            if (!$isProductInCart) {
                $increaseCartCounter();
                $cart = [...$cart, {'id': $(e.target).attr('data-product-id'), 'quantity': 1}];
            }
        }

        else {
            $increaseCartCounter();
            $cart = [{'id': $(e.target).attr('data-product-id'), 'quantity': 1}];
        }

        localStorage.setItem('cart', JSON.stringify($cart));
    };

    $(".add-to-cart").click($addToCart);
    $(".add-to-cart-btn").click($addToCart);

    let $removeCartItems = function(e) {
        let $cart = JSON.parse(localStorage.getItem('cart'));
        let $removeId = $(e.target).attr('data-product-item-id');
        let $cartQuantityBlock = $(".cart-quantity");
        let $quantity = $cartQuantityBlock.text() ? $cartQuantityBlock.text() : 0;
        $cart = $.grep($cart, ($cartItem) => {
            return $cartItem['id'] != $removeId;
        });

        $(".product-item[data-product-item-id=" + $removeId + "]").remove();
        $quantity--;
        $cartQuantityBlock.text($quantity);
        localStorage.setItem('cart', JSON.stringify($cart));
    };

    let $showCartProducts = () => {
        let $cart = JSON.parse(localStorage.getItem('cart'));
        let $productsIds = [];
        $($cart).each(($i, $product) => {
            $productsIds = [...$productsIds, $product['id']];
        });

        $.ajax({
            url: 'http://eshop.com/cart-data',
            method: 'post',
            data: {
                'productsIds': $productsIds
            },
            success: ($productsDataJson) => {
                let $cartPopUpContainer = `<div class="cart-container hidden transparent"></div>`;
                let $productItems = `<div class="cart">
                                        <div class="emphasized-container">
                                            <div class="close-cart-container"><span class="close-cart">x</span></div>
                                            <h1>Cart:</h1>`;
                let $productsData = JSON.parse($productsDataJson);
                if (!$productsData[0]) {
                    $productItems += '<p>Empty</p>';
                }

                $($productsData).each(($i, $productItem) => {
                    let $quantity;
                    $($cart).each(($i, $productLocalStorageData) => {
                        if ($productLocalStorageData['id'] === $productItem['id']) {
                            $quantity = $productLocalStorageData['quantity'];
                        }
                    });

                    $productItems += `<div class="product-item" data-product-item-id="${$productItem['id']}">
                                            <div class="picture">
                                                <a href="http://eshop.com/show/${$productItem['id']}">
                                                    <img src="/public/images/${$productItem['image']}" alt="${$productItem['title']}">
                                                </a>
                                            </div>
                                            <div class="title">
                                                <a href="http://eshop.com/show/${$productItem['id']}">${$productItem['title']}</a>
                                            </div>
                                            <div class="price">
                                                <span class="price-data" data-signle-item-price="${$productItem['price']}">${parseInt($productItem['price']) * parseInt($quantity)}$</span>
                                                <p class="quantity">
                                                    <span>Quantity:</span>
                                                    <input type="number" min="1" max="${$productItem['quantity']}" class="quantity-data" data-product-item-id="${$productItem['id']}" value="${$quantity}">
                                                </p>
                                            </div>
                                            <div class="remove">
                                                <span data-product-item-id="${$productItem['id']}">x</span>
                                            </div>
                                        </div>`;
                });

                $productItems += `</div>
                                    </div>`;
                $(".search").after($cartPopUpContainer);
                let $cartContainer = $(".cart-container");
                $cartContainer.html($productItems);
                $appearContainer($cartContainer);
                $(".close-cart").click(() => $disappearContainer($cartContainer));
                $(".cart-container .remove span").click($removeCartItems);
                $(".quantity-data").on('change', (e) => {
                    let $cart = JSON.parse(localStorage.getItem('cart'));
                    let $id = $(e.target).attr('data-product-item-id');
                    let $priceDataBlock = $(".product-item[data-product-item-id=" + $id + "] .price-data");
                    let $price = $priceDataBlock.attr('data-signle-item-price');
                    let $maxQuantity = parseInt($(e.currentTarget).attr('max'));
                    let $minQuantity = parseInt($(e.currentTarget).attr('min'));
                    let $currentQuantity = parseInt($(e.currentTarget).val());
                    if ($maxQuantity < $currentQuantity) {
                        $(e.currentTarget).val($maxQuantity);
                    }

                    else if ($minQuantity > $(e.currentTarget).val()) {
                        $(e.currentTarget).val($minQuantity);
                    }

                    $($cart).each(($i, $productLocalStorageData) => {
                        if ($productLocalStorageData['id'] === $id) {
                            $productLocalStorageData['quantity'] = $(e.currentTarget).val();
                        }
                    });
                    $priceDataBlock.text((parseInt($(e.currentTarget).val()) * parseInt($price)) + "$");
                    localStorage.setItem('cart', JSON.stringify($cart));
                });
            }
        });
    };

    $(".pushCart").click($showCartProducts);
});