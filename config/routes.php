<?php
return array(
    'show/([0-9]+)' => 'storage/getProductById/$1',
    'brand/([0-9]+)' => 'storage/getProductsByBrand/$1',
    'category/([0-9]+)' => 'storage/getProductsByCategory/$1',
    'filters' => 'storage/getProductsByFilters',
    'subCategory/([0-9]+)' => 'storage/getProductsBySubCategory/$1',
    'search' => 'storage/getProductsByTitle',
    'cart-data' => 'storage/getProductsByIds',
    'authorization' => 'authorization/checkAuthorization',
    'logout' => 'user/logout',
    'signup' => 'registration/showRegistrationPage',
    'registered' => 'registration/createCustomer',
    'order' => 'order/order',
    'isAuthorized' => 'user/isAuthorized',
    '' => 'storage/getProductsByPage'
);