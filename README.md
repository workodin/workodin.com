# workodin.com

Code pour le site internet https://workodin.com 

## landing page

* créer un dossier public/
* créer le fichier public/index.php
* ajouter le code HTML de base pour uen page web responsive

```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Workodin : le site pour trouver et préparer votre poste de développeur web depuis chez vous</title>
    <meta name="description" content="Workodin : le site pour trouver et préparer votre poste de développeur web depuis chez vous">
    <meta name="keywords" content="emploi, formation, développeur web, formation distance">
</head>
<body>
    <div class="page">
        <header>
            <h1>WORKODIN</h1>
        </header>
        <main>
            <section>
                <h2>Découvrez les offres d'emploi près de chez vous</h2>
            </section>
            <section>
                <h2>Préparez vos compétences avec une formation à distance</h2>
            </section>
            <section>
                <h2>Rejoignez une communauté de partage et d'entraide</h2>
            </section>
        </main>
        <footer>
            <p>tous droits réservés - &copy;2019</p>
        </footer>
    </div>
</body>
</html>
```

## tester les performances du site

* Google propose un site qui permet de vérifier si le code d'une page est correct et si les temps de chargement sont rapides.
* https://web.dev

## ajouter un peu de CSS

* ajouter du contenu et du code CSS

## Google Analytics

* on ajoute rapidement Google Analytics
* pour commencer à suivre la fréquentation du site
* https://analytics.google.com/
* (il faut avoir créé un compte gmail pour accéder aux services Google)
* => Google fournit un code JS à ajouter avant la balise fermante body
* (note: on tombe à 99% de performance sur web.dev)
* On peut immédiatement suivre la fréquentation du site dans Google Analytics en Temps Réel

## Ajout de .htaccess pour centraliser les URLs sur index.php

* Grâce aux Rewrite Rules
* on peut ajouter un fichier .htaccess dans le dossier public/
* https://wordpress.org/support/article/htaccess/
* on paramètre le serveur web Apache pour déléguer les requêtes à index.php
* => toutes les URLs sont centralisées par index.php
* exemple: https://workodin.com/hello


```
# BEGIN WordPress

RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]

# END WordPress
```

## Ajouter un favicon et le fichier robots.txt

* les navigateurs et les moteurs de recherche utilisent ces fichiers
* (note: on passe à 98% en performance web.dev)


## Ajouter une police de caractères Roboto

* https://fonts.google.com/specimen/Roboto?selection.family=Roboto
* (note: sur web.dev, on a un conseil "high" Eliminate render-blocking resources)

## Ajouter une image de fond

* https://pexels.com
* https://allthefreestock.com

## Ajout de CSS Flex

* et aussi ajout d'images
* (note: on passe à 97% en performance, avec un conseil sur les tailles des images)

## premier tag: version 0.4

* on a la base pour une landing page
* qui peut commencer à être référencé par les moteurs de recherche

## Ajout de contenu pour référencement

* ajouter plus de texte pour améliorer le référencement

## Ajout du formulaire d'inscription à la newsletter

* ajout du code html et css pour le formulaire
* ajout du code php pour le traitement du formulaire
* on enregistre les infos dans un fichier .csv
* ajout de fichier .gitignore pour ne pas gérer les fichier private/*.csv dans git
* (note: web.dev / performance = 96%)


## Ajout de l'envoi d'un mail suite à inscription à la newsletter

https://www.php.net/manual/fr/function.mail.php

## Ajout de log pour suivre les visiteurs

* on récupère les différentes informations dans le tableau associatif $_SERVER
* et on crée une nouvelle ligne dans un fichier "log"
https://www.php.net/manual/fr/function.file-put-contents.php



