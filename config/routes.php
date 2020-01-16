<?php
return array(
    'show/([0-9]+)' => 'storage/getProductById/$1',
    'brand/([0-9]+)' => 'storage/getProductsByBrand/$1',
    'search' => 'storage/getProductsByTitle',
    'login' => 'authorization/showAuthorizationPage',
    'authorization' => 'authorization/checkAuthorization',
    'logout' => 'user/logout',
    'signup' => 'registration/showRegistrationPage',
    'registered' => 'registration/createCustomer',
    'profile' => 'authorization/showWelcomePage',
    '' => 'storage/getProducts'
);