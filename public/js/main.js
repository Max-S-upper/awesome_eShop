$(document).ready(() => {
    $(".pushLogin").click(() => {
        let $loginContainer = $(".login-container");
        $loginContainer.removeClass('hidden');
        setTimeout(() => $loginContainer.removeClass('transparent'), 100);
    });

    let $closeLogin = () => {
        let $loginContainer = $(".login-container");
        $loginContainer.addClass('transparent');
        $loginContainer.on('transitionend webkitTransitionEnd oTransitionEnd', () => {
            $loginContainer.addClass('hidden');
            $loginContainer.off('transitionend webkitTransitionEnd oTransitionEnd');
        });
    }

    $(".close-login").click($closeLogin);

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
                    $('header').load('http://eshop.com/application/views/includes/header_signed.php', function() {
                        setTimeout($closeLogin, 100);
                        $("header .email").text($email);
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

    $(".add-to-cart").click(function(e) {
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
    });

    $(".pushCart").click(() => {
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
                let $cartPopUpContainer = `<div class="cart-container"></div>`;
                let $productItems = `<div class="cart">
                                        <div class="emphasized-container">
                                            <h1>Cart:</h1>`;
                // console.log($productsData);
                let $productsData = JSON.parse($productsDataJson);
                console.log($cart);
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
                                                <span>${$productItem['price']}$</span>
                                                <span>Quantity: ${$quantity}</span>
                                            </div>
                                            <div class="remove">
                                                <span data-product-item-id="${$productItem['id']}">x</span>
                                            </div>
                                        </div>`;
                });

                $productItems += `</div>
                                    </div>`;
                $(".search").after($cartPopUpContainer);
                $(".cart-container").html($productItems);
                $(".cart-container .remove span").click(function(e) {
                    let $cart = JSON.parse(localStorage.getItem('cart'));
                    let $removeId = $(e.target).attr('data-product-item-id');
                    $cart = $.grep($cart, ($cartItem) => {
                        return $cartItem['id'] != $removeId;
                    });

                    $(".product-item[data-product-item-id=" + $removeId + "]").remove();
                    localStorage.setItem('cart', JSON.stringify($cart));
                });
            }
        });
    });
});