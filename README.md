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
* https://www.php.net/manual/fr/function.file-put-contents.php


## Découpage du code PHP en tranches dans plusieurs fichiers

* on évolue vers un code plus complexe 
* car on va découper notre code en plus de fichiers
* PHP est un moteur de templates HTML
* => PHP construit le code HTML final pour le navigateur
* => en composant avec différents fichiers disponibles

* DIVIDE AND CONQUER

* on crée des nouveaux fichiers
* starter.php
* private/template/header.php
* private/template/section-index.php
* private/template/footer.php

* et on réaprtit le code php dans ces fichiers

* puis on recompose avec require_once
* https://www.php.net/manual/fr/function.require-once.php

* on crée une variable globale $baseDir
* pour donner le chemin de base à tous les fichiers
* attention: on améliore le code des file_put_contents pour utiliser cette variable $baseDir

* on ajoute aussi la configuration pour afficher les erreurs PHP dans la page
* => plus facile pour le debug


## programmation fonctionnelle

1. on ajoute le fichier private/function.php
1. et on charge le code des fonctions au début de starter.php
1. on peut alors déplacer le code de getInfo dans function.php
1. on peut créer plus de fonctions, par exemple setSiteMode
1. avec la programmation fonctionnelle, on peut ranger du code complexe dans des fonctions
1. => et ensuite activer ce code en appelant la fonction
1. => meilleure organisation et meilleure lisibilité du code
1. exemple: on crée plusieurs fonctions

## MVC: Model View Controller

1. On commence par avoir beaucoup de fichiers dans notre projet
1. Pour organiser notre code, on va suivre la recommendation MVC
1. MVC: Model View Controller
1. => Cela consiste à séparer notre code en 3 parties principales
1. => de manière simple, dans l'avancement actuel de notre projet
1. Model: les données
1. View: les templates
1. Controller: le traitement des formulaires
1. (attention: les fichiers CSV seront maintenant dans le dossier private/model/)

## Routeur pour gérer plusieurs pages

1. Comme on a centralisé toutes les requêtes du navigateur vers index.php
1. Il faut maintenant retrouver quelle est la page demandée par le navigateur
1. On va travailler avec $_SERVER["REQUEST_URI"]
1. On crée une fonction getPageUri
1. On met en place une convention de nommage sur le nom des fichiers de template
1. La page index sera composée avec section-index.php
1. La page credits sera composée avec section-credits.php
1. Si le fichier section n'existe pas, alors on renvoie une erreur HTTP 404
1. Ca y'est on a le code de base de notre framework pour gérer un site avec plusieurs pages !


