<?php
return array(
    '' => 'storage/get_products',
    'show/([0-9]+)' => 'storage/get_product_by_id/$1',
    'login' => 'authorization/show_authorization_page',
    'signed' => 'authorization/check_authorization',
    'logout' => 'user/logout'
);