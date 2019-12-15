<?php
return array(
    '' => 'storage/getProducts',
    'show/([0-9]+)' => 'storage/getProductById/$1',
    'login' => 'authorization/',
    'signed' => 'authorization/checkAuthorization',
    'logout' => 'user/logout',
);