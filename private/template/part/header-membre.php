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

</head>
<body class="<?php echo $pageUri ?>">
    <div class="page">
        <main>

        <div id="app">
    <v-app>
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list dense>
      <v-list-item @click="">
          <v-list-item-action>
          </v-list-item-action>
          <v-list-item-content>
              <v-list-item-title><a href="/">Accueil</a></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="">
          <v-list-item-action>
          </v-list-item-action>
          <v-list-item-content>
              <v-list-item-title><a href="/membre">Espace Membre</a></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="">
          <v-list-item-action>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title><a href="/logout">Déconnexion</a></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="indigo" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Espace Membre Workodin</v-toolbar-title>
    </v-app-bar>

    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex>
          <div class="left">
