<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/successful_authorization.css">
    <link rel="stylesheet" href="/public/css/index.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <title>Awesome eShop</title>
</head>
<body>
    <header class="main-header">
        <nav>
            <div>
                <a href="http://eshop.com/">Awesome eShop</a>
            </div>
            <div>
                <a href="#"><?= $usr_email; ?></a>
                <a href="http://eshop.com/logout">Log out</a>
            </div>
        </nav>
    </header>