<!DOCTYPE html>
<html lang="<?php Site::Show("lang") ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- http://robots-txt.com/meta-robots/ -->
    <meta name="robots" content="noindex, nofollow">

    <title><?php Site::Show("description") ?></title>
    <meta name="description" content="<?php Site::Show("description") ?>">
    <meta name="keywords" content="<?php Site::Show("keywords") ?>">

    <link rel="canonical" href="https://workodin.com<?php echo Site::Get("pagePath") ?>">
    <link rel="icon" type="image/png" href="/assets/images/icon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" >

    <style>
<?php require_once("$baseDir/public/assets/css/site.css") ?>
<?php require_once("$baseDir/public/assets/css/site-admin.css") ?>
    </style>
</head>
<body class="<?php echo $pageUri ?>">
    <div class="page">
        <header>
            <h1><a href="/"><?php Site::Show("h1") ?></a></h1>
            <h2><?php Site::Show("h2") ?></h2>
            <nav>
                <ul>
                    <?php Site::Get("View")->showMenu("menu-admin") ?>
                </ul>
            </nav>
        </header>
        <main>

