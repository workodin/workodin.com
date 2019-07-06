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


## Ajout d'une étiquette sur les formulaires pour les identifier

1. Pour préparer le site à pouvoir gérer de nombreux formulaires
1. On va ajouter une étiquette à chaque formulaire pour les distinguer
1. On utilise la balise input type="hidden" avec une valeur prédéfinie
1. On choisit pour notre framework name="formTag"
1. Chaque formulaire aura une value différente pour ce champ input

    <input type="hidden" name="formTag" value="Newsletter">

1. Pour le code PHP de traitement du formulaire
1. On ajoute une convention dans notre framework
1. La fonction qui contient le code pour traiter le formulaire DOIT avoir un nom précis
1. On choisit que le nom de la fonction a pour préfixe processForm et pour suffixe la valeur de formTag

    en HTML:
    <input type="hidden" name="formTag" value="Newsletter">
    en PHP:
    function processFormNewsletter ()

## Amélioration du MVC avec les formulaires

1. Pour être plus rigoureux avec le MVC
1. On effectue le traitement des formulaires (controller)
1. Et ensuite, on crée la page qui affiche le message de confirmation (view)
1. On améliore la fonction processForm avec un paramètre formFeedback
1. La fonction sera appelée 2 fois:
1. la première fois pour traiter le formulaire
1. la 2e fois pour afficher le message de confirmation (feedback)
1. Avec cette fonctionnalité dans notre framework, la gestion des formulaire devient plus simple

## Ajout du formulaire de contact

1. On ajoute une page /contact
1. Cette page propose un formulaire de contact pour le visiteur
1. Champs obligatoires: nom, email, message
1. le code HTML et PHP reprennent une bonne partie du code du formulaire de Newsletter

## Ajout de fichiers site.css et site.js

* On ajoute 2 fichiers
* assets/css/site.css
* assets/js/site.js
* On ne charge pas le code par une requête HTML supplémentaire
* mais directement avec PHP et require_once
* Cela permet de mieux séparer les codes HTML, CSS, PHP dans des fichiers spécifiques

## Programmation Orientée Objet

* On a bien avancé sur la partie fonctionnelle
* On peut maintenant ajouter la Programmation Orientée Objet

## Ajout autoload de classe

* La première étape est de rajouter une fonction de callback 
* pour permettre le chargement automatique de classe
* https://www.php.net/manual/fr/function.spl-autoload-register.php
* Nous allons ranger chaque classe dans son propre fichier PHP
* Pour notre framework, on prend comme convention de nommage
* le fichier PHP sera dans le dossier private/class/
* et le nom du fichier sera le nom de la classe (Majuscule au début)

    exemple:
    la classe Site sera déclarée dans le fichier private/class/Site.php

## Méthode constructeur __construct

* La POO inclut de nombreux mécanismes automatiques (cachés car sans code explicite)
* La méthode constructeur __construct
* est appelée automatiquement par PHP quand on écrit new pour créer un objet

    exemple
    $objetSite = new Site;
    // => PHP appelle automatiquement la méthode Site::__construct



## déplacement de code fonctionnel vers objet

* On peut maintenant transformer notre code fonctionnel en code POO
* Il faut déplacer le code dans des méthodes de classe
* ATTENTION: en déplaçant le code des variables dans des méthodes, elles deviennent des variables locales !
* astuce: pour le moment, on peut utiliser la variable Super-Globale $GLOBALS pour manipuler les variables globales
* todo: à terme, il faudra gérer toutes les variables en propriétés de classe

## Déplacement de la fonction setSiteMode en méthode de la classe Site

* Il suffit de déplacer la déclaration de la fonction dans la classe Site
* Attention: pour appeler une méthode de la même classe, il faut ajouter $this->setSiteMode("DEV")
* et non plus directement setSiteMode("DEV")
* En POO, on passe par un objet de la classe pour activer une méthode de la classe
* C'est ce qui fait que la POO est plus lourde à écrire comparé à du code en fonctionnel
* Ensuite on peut continuer à déplacer plus de fonctions dans la classe
* A terme, il ne faudrait plus avoir de fonctions dans le fichier private/function.php
* mais tout notre code devrait être rangé dans le dossier private/class/
* => C'est un critère simple pour évaluer si tout notre code PHP est Orienté Objet !

## Création de classe Form et de méthode process

* En fonctionnel, on avait une fonction processForm
* En POO, on va transformer le code en une classe Form avec une méthode process
* Ensuite on change la fonction getInfo en méthode de Form
* ATTENTION: il faut changer aussi le code des fonctions de traitement

## Création de classes pour les traitements de formulaire

* En fonctionnel, on avait une fonction processFormNewsletter et processFormContact
* En POO, on va transformer le code en des classes 
* FormNewsletter avec une méthode process
* FormContact avec une méthode process
* ATTENTION: on va aussi changer le code de la méthode Form::process
* SECURITE: ce code est pratique mais dangereux si mal sécurisé !

## VERSION 1.0 EN POO

* On a maintenant un framework MVC et POO
* template HTML
* framework de traitement de formulaires en POO
* sans database SQL
* stockage dans des fichiers plats

## Ajout d'un fichier my-config.php

* Ce fichier my-config.php permet de paramétrer le site suivant l'hébergement d'installation
* Ainsi il ne sera pas géré avec git (ajout dans le .gitignore)
* Pour la suite, on y stockera les paramètres comme la connexion à la Base De Données MySQL

## Ajout de la classe Model pour gérer MySQL

* On ajoute la classe Model qui gère l'envoi de requêtes vers MySQL
* On utilise les classes PHP version Orienté Objet 
* PDO
* PDOStatement
* On se protège des injections SQL avec la séparation
* prepare
* execute

## Ajout du mode TERMINAL dans le framework

* On ajoute un fichier install.php
* On modifie la classe Site pour gérer le mode en ligne de commande
* On peut utiliser PHP en ligne de commande

    php install.php

## Ajout de la création de la Table SQL Post

* Pour préparer l'évolution du framework vers un CMS
* On crée une Table SQL Post

## Ajout page install et formulairte d'installation avec clé

* Ajout d'une page install pour pouvoir déclencher l'installation par un formulaire
* Ajout d'une clé d'installation pour protéger l'activation de l'installation

## Ajout méthode insertLine dans la classe Model et modification formulaire Newsletter

* Pour pouvoir insérer une ligne dans une table SQL, on crée la méthode insertLine dans la classe Model
* Pour pouvoir utiliser la classe Model, on ajoute une méthode statique Get dans la classe Site
* (On utilise le Design Pattern Factory pour l'injection de dépendances...)
* => Notre framework est maintenant utilisable avec MySQL

* Pour corriger les erreurs SQL, la méthode debugDumpParams est bien pratique
* https://www.php.net/manual/fr/pdostatement.debugdumpparams.php

* Suppression du stockage dans un fichier
* On nettoie le code de traitement du formulaire de Newsletter pour seulement garder le stockage dans MySQL
* Amélioration: Cela permet aussi de ne plus utiliser les variables globales


