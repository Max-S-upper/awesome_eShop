<?php
return array(
    '' => 'storage/getProducts',
    'show/([0-9]+)' => 'storage/getProductById/$1',
    'brand/([0-9]+)' => 'storage/getProductsByBrand/$1',
    'login' => 'authorization/showAuthorizationPage',
    'signed' => 'authorization/checkAuthorization',
    'logout' => 'user/logout',
);