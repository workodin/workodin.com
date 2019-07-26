<!DOCTYPE html>
<html lang="<?php Site::Show("lang") ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title><?php Site::Show("description") ?></title>

    <!-- http://robots-txt.com/meta-robots/ -->
    <meta name="robots" content="noindex, nofollow">

    <meta name="description" content="<?php Site::Show("description") ?>">
    <meta name="keywords" content="<?php Site::Show("keywords") ?>">


    <link rel="canonical" href="https://workodin.com<?php echo Site::Get("pagePath") ?>">
    <link rel="icon" type="image/png" href="/assets/images/icon.png">

    <!-- vuetify -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@3.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <style>
<?php require_once("$baseDir/public/assets/css/site.css") ?>
    </style>
</head>
<body class="<?php echo $pageUri ?>">
    <div class="page">
        <header>
            <h1><a href="/"><?php Site::Show("h1") ?></a></h1>
            <h2><?php Site::Show("h2") ?></h2>
            <nav>
                <ul>
                    <?php Site::Get("View")->showMenu("menu") ?>
                </ul>
            </nav>
        </header>
        <main>
