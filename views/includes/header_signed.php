<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/css/header.css">
    <link rel="stylesheet" href="/template/css/main.css">
    <link rel="stylesheet" href="/template/css/successful_authorization.css">
    <link rel="stylesheet" href="/template/css/index.css">
    <link rel="stylesheet" href="/template/css/footer.css">
    <title>Awesome eShop</title>
</head>
<body>
    <div class="wrapper">
        <header class="main-header">
            <nav>
                <div>
                    <a href="http://eshop.com/">Awesome eShop</a>
                </div>
                <div>
                    <a href="#"><?= $usr_email; ?></a>
                    <a href="logout">Log out</a>
                </div>
            </nav>
        </header>