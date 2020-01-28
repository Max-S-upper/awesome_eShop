$(document).ready(() => {
    let $showErrorInPopUp = ($errorsContainer, $err) => {
        let $errorsBlock = $("#js-err");
        if ($errorsBlock.length) $errorsBlock.remove();
        let $errBlockHtml = `<div id="js-err" class="errors-container">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul>`;
        $($err).each(($i, $singleErrorData) => {
            $errBlockHtml += '<li>' + $singleErrorData + '</li>';
        });

        $errBlockHtml += `</ul>
                        </div>`;
        $errorsContainer.prepend($errBlockHtml);
    };

    $(".submit-container input[name=signUp]").click((e) => {
        e.preventDefault();
        let $err = [];
        if (!$(".name-container input").val()) $err.push("Please, enter your name.");
        if (!$(".surname-container input").val()) $err.push("Please, enter your surname.");
        if (!$(".email-container input").val()) $err.push("Please, enter your email.");
        if (!$(".password-container input[name=password]").val()) $err.push("Please, enter your password.");
        if (!$(".password-container input[name=confirm-password]").val()) $err.push("Please, confirm your password.");
        else if ($(".password-container input[name=confirm-password]").val() !== $(".password-container input[name=password]").val()) $err.push("Passwords don't much.");
        if (!$err[0]) $(".signUp form").submit();
        else $showErrorInPopUp($(".signUp form"), $err);
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
                    $showErrorInPopUp($(".errors-container"), [$answer]);
                }

                else {
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

                let $totalAmount = 0;

                $($productsData).each(($i, $productItem) => {
                    let $quantity;
                    $($cart).each(($i, $productLocalStorageData) => {
                        if ($productLocalStorageData['id'] === $productItem['id']) {
                            $quantity = $productLocalStorageData['quantity'];
                        }
                    });

                    let $price = parseInt($productItem['price']) * parseInt($quantity);
                    $totalAmount += $price;
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
                                                <span class="price-data" data-signle-item-price="${$productItem['price']}">${$price}₴</span>
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

                $productItems += `        <div class="total-amount">
                                                    <span>Total amout: </span>
                                                    <span class="total-amout-data">${$totalAmount}₴</span>
                                            </div>
                                        </div>
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
                    let $previousPrice = parseInt($priceDataBlock.text());
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

                    let $currentProductPrice = parseInt($(e.currentTarget).val()) * parseInt($price);
                    $(".total-amout-data").text((parseInt($(".total-amout-data").text()) - $previousPrice) + $currentProductPrice + "₴");
                    $priceDataBlock.text($currentProductPrice + "₴");
                    localStorage.setItem('cart', JSON.stringify($cart));
                });
            }
        });
    };

    $(".pushCart").click($showCartProducts);

    $(".filter input").on('change', (e) => {
        let $subCategoryId = $(".filters-container").attr('data-subcategory-id');
        let $checkedFiltersData = [];
        $(".filter input:checked").each(($i, $checkedFilterData) => {
            $checkedFiltersData = [...$checkedFiltersData, $checkedFilterData.id.split('filter')[1]];
        });

        if (!$checkedFiltersData[0]) {
            $(".filter input").each(($i, $checkedFilterData) => {
                $checkedFiltersData = [...$checkedFiltersData, $checkedFilterData.id.split('filter')[1]];
            });
        }

        console.log($checkedFiltersData);
        $.ajax({
            url: '/filters',
            type: 'post',
            data: {
                'subCategoryId': $subCategoryId,
                'attributeIds': $checkedFiltersData
            },
            success: ($productsData) => {
                console.log($productsData);
                $(".product").remove();
                $(".errors").remove();
                if ($productsData === 'not found') {
                    $errorHtml = `<div class="errors emphasized-container">
                                    <p>Products not found</p>
                                </div>`;
                    $(".products").append($errorHtml);
                }

                else {
                    $products = JSON.parse($productsData);
                    $productsHtml = '';
                    $($products).each(($i, $product) => {
                        $productsHtml += `<div class="product">
                                            <p class="brand">
                                                <a href="http://eshop.com/brand/${$product['brand_id']}">${$product['brand']}</a>
                                                <img src="/public/images/addToCart.png" class="add-to-cart" data-product-id="${$product['id']}" alt="Add to cart">
                                            </p>
                                            <a href="http://eshop.com/show/${$product['id']}">
                                                <img src="/public/images/${$product['image']}" alt="${$product['title']}">
                                            </a>
                                            <p class="name">
                                                <a href="http://eshop.com/show/${$product['id']}">${$product['title']}</a>
                                            </p>`;
                        $($product['attributes']).each(($i, $attribute) => {
                            $productsHtml += `<span class="attributes">Attributes: ${$attribute['title']}</span>`;
                        });

                        $productsHtml += `    <span class="quantity">Available: ${$product['quantity']}</span>
                                          <span class="price">${$product['price']}₴</span>
                                        </div>`;
                    });

                    $(".products").append($productsHtml);
                }
            }
        });
    });

    $("#buy-product").click((e) => {
        e.preventDefault();
        $.ajax({
            url: '/isAuthorized',
            type: 'get',
            success: ($data) => {
                let $user = JSON.parse($data);
                console.log($user);
                if ($user['errorMessage'] === 'not authorized') {
                    $appearContainer($(".login-container"));
                }

                else if ($user['errorMessage']) {
                    alert($user['errorMessage']);
                }

                else {
                    console.log($user['data']['phone']);
                    if ($user['data']['phone']) $(".order-note input[name=phone]").val($user['data']['phone']);
                    $appearContainer($(".order-note-container"));
                    $(".close-container").click(() => $disappearContainer($(".order-note-container")));
                    $(".order-submit").click(() => {
                        let $phoneNumber = $(".order-note input[name=phone]").val();
                        let $note = $(".order-note textarea[name=order-note]").val();
                        let $productId = $(".single-product-data").attr("data-product-id");
                        let $price = $(".price span").text().split('₴')[0];
                        let $attributes = [];
                        document.querySelectorAll(".attributes > span").forEach(($attribute) => {
                            $attributes.push($attribute.getAttribute('data-attribute-id'));
                        });

                        if (!$phoneNumber) {
                            $showErrorInPopUp($(".errors-container"), ['Please, enter your phone number']);
                        }

                        else {
                            $.ajax({
                                url: '/order',
                                type: 'post',
                                data: {
                                    'userId': $user['data']['id'],
                                    'productId': $productId,
                                    'quantity': 1,
                                    'attributes': $attributes,
                                    'price': $price,
                                    'phoneNumber': $phoneNumber,
                                    'note': $note
                                },
                                success: ($answer) => {

                                }
                            });
                        }
                    });
                }
            }
        })
    });
});