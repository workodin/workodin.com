<?php

// COPY THIS FILE TO my-config.php 

if (is_file("my-localhost.php"))
{
    $tabConfigSQL = [];
}
else
{
    $tabConfigSQL = [
        "database"  =>  "CHANGE_SQL_DATABASE",
        "user"      =>  "CHANGE_SQL_USER",
        "password"  =>  "CHANGE_SQL_PASSWORD",
    ];
}

$installKey = "CHANGE_INSTALL_KEY";
$adminEmail = "CHANGE_INSTALL_EMAIL";

// TEMPLATE
Site::Set("templatePriority", "");

// UPLOAD
Site::Set("uploadPath", "assets/media");
Site::Set("publicDir", __DIR__ . "/public");
Site::Set("uploadDir", __DIR__ . "/public/assets/media");

// SITE META CONFIG META
Site::Set("lang", "CHANGE_SITE_LANG");
Site::Set("robots", "CHANGE_SITE_ROBOTS");
Site::Set("title", "CHANGE_SITE_TITLE");
Site::Set("description", "CHANGE_SITE_DESCRIPTION");
Site::Set("keywords", "CHANGE_SITE_KEYWORDS");
Site::Set("h1", "CHANGE_SITE_H1");
Site::Set("h2", "CHANGE_SITE_H2");
