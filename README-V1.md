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

# Ajout classe Email

* On va créer une classe Email pour gérer l'envoi des emails
* Cela permet de simplifier le code de traitement de Newsletter

# Contact: Amélioration traitement formulaire

* On modifie le code PHP de traitement du formulaire de Contact
* On ne stocke plus les messages dans des fichiers
* mais dans la table SQL Contact

## Antispam: protection des formulaires

* Au bout de quelques jours, les formulaires sont déjà spammés
* (alors que les moteurs de recherche n'ont même pas encore référence le site...)
* Il faut compliquer la vie aux spammeurs...

* technique1: 
* ajout d'un champ supplémentaire dont la valeur change à chaque visite
* => ça ne protège pas, car les spammeurs visitent le site et analyse le code avant de forger le formulaire

* technique2:
* On teste si les spammeurs exécutent le code JS de la page
* on inverse les champs formTag et formKey, ce qui désactive le traitement du formulaire
* ajout de code js pour remettre les bonnes valeurs dans chaque champ au chargement de la page
* à suivre...

## Log des visites dans MySQL

* Pour suivre les visites, on va mémoriser chaque visite dans une table SQL Visit
* On améliore la classe Model pour garder une seule connexion SQL à chaque requête
* La performance web.dev reste à 98%

## Ajout de template de page

* On peut vouloir créer des templates de page différents
* Modification de la Classe Site pour tester si un template de page existe
* On peut ainsi suivre les requêtes vers robots.txt des moteurs de recherche

## Ajout du formulaire de login

* Pour préparer la partie Back-Office
* On ajoute une page publique /login avec un formulaire de login
* On ajoute une page /admin (qui devra être protégée...) 

## Ajout de la méthode Model::count

* On améliore le formulaire de Newsletter
* On vérifie que l'email n'est pas déjà présent dans la table SQL Newsletter
* Si déjà présent, on ne crée pas de doublon

## Ajout de la méthode Model::readLine

* On complète le formulaire de Login
* Comme le mot de passe est stocké dans MySQL avec un hashage
* (obligation légale avec le RGPD)
* On doit procéder en plusieurs étapes
* étape1: on cherche une ligne qui correspond à l'email fourni par le visiteur
* étape2: si on trouve une ligne, on récupère le mot de passe hashé
* étape3: on peut utiliser la fonction password_verify qui valide que les 2 mots de passe correspondent
* https://www.php.net/manual/fr/function.password-verify.php


* On ajoute la création d'un User avec le rôle admin dans FormInstall
* BUG: il faut d'abord créer les tables SQL et ensuite créer le User admin ?!

## Ajout de la classe Session et finalisation du Login/Logout

* On utilise les sessions PHP pour mémoriser les infos sur un visiteur connecté
* Et on peut maintenant finaliser le formulaire de Login
* pour mémoriser les infos sur le User si le Login est correct
* Et on peut ensuite retrouver ces infos de session sur la page admin
* si le visiteur est un User admin alors on affiche la page admin
* sinon, on affiche une page 404
* Et on ajoute une page logout pour se déconnecter

* On ajoute des redirections pour faciliter la navigation pour le visiteur

## Ajout de header-admin.php et footer-admin.php

* La partie Back-Office est différente de la partie publique
* On va créer de nouveaux fichiers pour la partie admin
* header-admin.php et footer-admin.php
* on ajoute notamment la balise meta noindex pour ne pas être référencé


    <!-- http://robots-txt.com/meta-robots/ -->
    <meta name="robots" content="noindex, nofollow">

## Ajout du CRUD sur la table Post

* CRUD
* Create
* Read
* Update
* Delete
* La vie du développeur web tourne autour du CRUD !

## Ajout de formulaire admmin de création de Post (Create)

* sur la page admin, on ajoute un formulaire pour créer des contenus (Post)
* SECURITE: il faut bien vérifier le niveau du User dans le traitement du formulaire

## Ajout de la classe Controller

* Pour simplifier le traitement des formulaires, on ajoute une classe Controller
* On utilise le chainage des appels de méthodes pour obtenir un code plus compact
* Astuce: la méthode retourne $this pour permettre le chainage des appels

## Ajout de l'affichage de la table Post (Read admin)

* On ajoute dans la page admin l'affichage des Post
* SECURITE: Il faut se protéger contre les attaques XSS avec du JS
* On désactive le code HTML (et ainsi les balises script)
* avec la fonction htmlspecialchars

## Ajout du Delete sur Post

* Sur la page admin, on ajoute un lien "supprimer" sur chaque ligne de Post
* On ne passe pas par une balise form, mais une balise a
* Astuce: on forge la requête directement dans l'URL
* SECURITE: bien vérifier car on peut effacer toute une table SQL !!!

## Ajout de tri sur Read

* On affiche les lignes de Post du plus récent au plus ancien
* Amélioration de l'affichage du tableau html 
* On utilise ob_start et ob_get_clean pour simplifier le code PHP
* https://www.php.net/manual/fr/function.ob-start.php
* https://www.php.net/manual/fr/function.ob-get-clean.php

## Ajout de la page News (Read public)

* On ajoute une page /news
* Cette page affiche seulement les Post dans la catégorie "news"
* On fait une "boucle" de Read en filtrant sur la catégorie dans la table SQL Post
* IMPORTANT: les boucles sont fondamentales dans les CMS

## Ajout Update sur Post

* Ajout de la page admin-update.php
* Ajout de Model::updateLine
* Ajout de Controller::updateLine

## Ajout check unique sur uri dans Post

* Chaque Post doit avoir une uri unique
* Il faut gérer le cas de l'update sur l'uri
* Chaque Post a sa propre page accessible avec son uri

## Amélioration du CMS

* Gestion de la date de publication pour choisir l'ordre d'affichage des Post dans la page /news
* Améliorations du CSS et utilisation de la balise HTML pre

## Upload de fichier pour Post

* modifier le formulaire HTML pour gérer upload
* https://www.w3schools.com/php/php_file_upload.asp
* https://www.php.net/manual/fr/features.file-upload.post-method.php
* SECURITE: on fait le choix de restreindre la liste des fichiers à des extensions connues
* Vérifier les paramètres php.ini
* upload_max_filesize
* post_max_size
* note: o2switch plante sur une erreur "502 bad gateway" si on essaie d'uploader un fichier .php ?
* affichage des images sur la page /news

## Ajout de boucle (loop) sur la page d'accueil

* Le contenu statique de la page d'accueil est maintenant remplacé par une boucle sur Post avec categorie=index
* Ajout de CSS et utilisation de balise HTML pre

## Ajout de boucle (loop) dans template-post.php

* Ajout d'une boucle sur Post qui affiche les Post avec category=$pageUri
* Le code du Post est toujours affiché avant
* Les pages /news, /formation, /emploi utilisent ce template
* il faut créer les Post avec les URI adaptées et supprimer section-news.php
* => On a maintenant un moyen simple de créer des pages dynamiques ;-p

# Ajout de la balise link rel="canonical"

* Pour améliorer le référencement des pages par les moteurs de recherche
* On fournit une URL officielle pour chaque page
* Cela évite des problèmes de duplicate content
* Cette URL sera celle proposée par les moteurs de recherche
* (Notamment pour le https...)

## Reorganisation du dossier template

* Comme il commence à y avoir beaucoup de fichiers dans le dossier template/
* On crée des sous-dossiers: 
* template/page
* template/page-section
* template/part
* Il faut aussi modifier la classe Site et les chemins à tester

## Ajout template-code.php

* Ce template permet de renvoyer le contenu brut de la colonne code dans Post
* Utile pour gérer du code dans un CMS

## Ajout de convertisseur de code

* Pour écrire du code le plus simplement possible
* Il faut ensuite enrichir le code avant de l'afficher au visiteur
* On utilise les expressions régulières pour traiter les textes rapidement
* https://www.php.net/manual/fr/function.preg-replace.php

## Ajout de menu dynamique dans Post

* Avec un CMS, il est important de pouvoir créer des pages, 
* mais ensuite, il faut pouvoir créer des menus pour naviguer entre les pages
* Ajout de la méthode View::showMenu
* qui va extraire d'un Post un code au format JSON
* https://www.php.net/manual/fr/function.json-decode.php
* Le format JSON devient un tableau associatif PHP
* => C'est facile à manipuler ensuite !

* Le format JSON est assez facile à lire et écrire...
* (attention: vérifier que le dernier élément n'a pas virgule à la fin...)

## Ajout de paramétrage sur header et footer

* Dans le header, il y a un espace pour un menu principal
* Dans le footer, il y a 2 colonnes pour 2 menus
* Dans le header, les h1 et h2 doivent être définis dans le fichier my-config.php
* Dans le head, les infos lang, robots, title, description, keywords doivent être définis dans le fichier my-config.php
* => On obtient un CMS qui est en marque blanche!
* Vous pouvez maintenant l'utiliser pour vos projets ;-p
* Avec ces fonctionnalités, on peut prototyper rapidement un site

## Ajout de JS et PHP pour formulaire Ajax

* AJAX est maintenant devenu le standard pour envoyer les formulaires
* En effet, AJAX permet de ne pas détruire et reconstruire la page
* Pour le visiteur, l'expérience est plus rapide
* Dans notre framework, il suffit d'ajouter la classe ajax à la balise form
* Le code JS va ajouter un callback pour prendre la main sur ces formulaires

## Ajout de VueJS

* VueJS est une librairie qui aide à créer des pages web réactives plus facilement
* https://fr.vuejs.org/v2/guide/index.html
* La documentation est très bien organisée et traduite en français
* C'est surement le successeur de jQuery
* Pour démarrer, il suffit de charger le code de la librairie
* Et ensuite, on ajoute son code JS

## Admin: Ajout de toolbar

* Dans le code HTML de VueJS, on enrichit la page de composants
* On ajoute une toolbar en position fixed, en bas de la page
* Astuce: Dans un fichier .php, on peut créer du code JS
* Cela permet de transférer des infos depuis PHP vers JS
* Pour plus de clarté, on crée un objet en javascript qui contiendra toutes les infos provenant de PHP

## VueJS: ajout de bouton et popup

* On ajoute un bouton dans la toolbar, et quand on clique sur le bouton, alors une popup s'affiche
* Dans la popup, on ajoute un bouton pour pouvoir cacher la popup
* Avec VueJS, on peut gérer les événements des utilisateurs
* https://fr.vuejs.org/v2/guide/events.html
* Et on peut gérer dynamiquement les classes sur les balises
* https://fr.vuejs.org/v2/guide/class-and-style.html

## Ajax: ajout de formulaire Admin

* En mode agile, on a besoin de faire évoluer la Base De Données régulièrement
* On ajout eun formulaire en Ajax qui permet de lancer n'importe quelle requête SQL
* DANGER: 
* Il faut bien protégér le traitement de ce formulaire, 
* car un hacker pourrait complètement prendre la main sur la BDD !!!

# SQL: Ajout de la colonne idUser dans Post

* On ajoute une relation One-to-Many entre User et Post
* Un Post est créé par un User
* Un User peut créer plusieurs Post
* => On ajoute une colonne idUser dans Post qui servira de Clé étrangère (Foreign Key) vers la table User
* Dans le traitement du Create de Post, on complète avec idUser de la session

## VueJS et Ajax: ajout de l'affichage des résultats à une requête SQL

* Pour les requêtes SQL en lectre (READ), c'est mieux de pouvoir récupérer la liste des résultats dans la réponse Ajax
* On modifie le code PHP pour ajouter dans la réponse Json du serveur, le tableau qui contient les lignes trouvées
* Et on crée un template VueJS pour pouvoir afficher dynamiquement la liste des résultats
* Attention: on tombe dans des petits travers de VueJS...
* Pas moyen de faire 2 boucles imbriquées, il faut passer par un template intermédiaire (car VueJS manipule des alias et pas des variables JS)
* il faut respecter la structure HTML et on ne peut pas insérer des templates n'importe où dans le DOM
* astuce: utiliser la balise HTML nécessaire pour le DOM et ajouter l'attribut spécial VueJS is="mon-template"
* => Pour l'administrateur, on obtient un outil CRUD puissant, sur toute la base de données SQL !
* DANGER: 
* Il faut bien protégér le traitement de ce formulaire, 
* car un hacker pourrait complètement prendre la main sur la BDD !!!

## Back-office, VueJS et Ajax: CRUD sur Post

* Dans le back-office, on passe tout le CRUD sur Post avec VueJS et Ajax
* Il faut entrer dans les détails de VueJS...
* Pour nettoyer, on enlève ensuite, la partie admin qui n'était pas avec VueJS

## Améliorations sécurité liens vers pages externes

* suivre les recommendations de https://web.dev/
* https://web.dev/external-anchors-use-rel-noopener/


## Ajout des Commandes

* Le contenu des articles est simplement du texte
* Mais on a souvent besoin de pouvoir insérer des éléments plus complexes avec le texte
* WordPress utilise le système des [shortcodes] pour réaliser cette combinaison
* Nous allons nous appuyer sur une ligne de commande orientée objet
* si une ligne commence par @/ alors c'est une commande qui sera remplacée
* le format sera simplement

    @/classe/methode/param

* qui activera le code PHP

    (new ExtClasse)->runMethode(param)

exemple:

    commande:
    @/form/newsletter/hello

    code PHP activé:
    (new ExtForm)->runNewsletter("hello")

## Simplification de l'antispam en JS

* Pour être traité, chaque formulaire doit envoyer une clé
* le code html des formulaires ne contient pas cette clé
* la clé est ajouté juste avant d'envoyer le formulaire en Ajax
* Ainsi les formulaires qui ne sont pas envoyées en Ajax seront considérées comme du spam
* A surveiller si les spammeurs reviennent ?


## Ajout du formulaire de création de compte

* Première version du formulaire de création de compte
* le compte est tout de suite activé
* le login donne alors l'accès à la page d'espace membre
* le login est maintenant aussi en Ajax, avec une redirection par JS (et non plus PHP...)

## Ajout de méthode ExtForm::runPost

* Cette méthode permet d'aller chercher dans Post un code 
* et de l'insérer dans un autre Post avec la commande

    @/form/post/uri-du-post

* attention: il doit y avoir des problèmes si on fait des boucles infinies

* Exemple: 
* on peut créer le formulaire de contact avec son code HTML dans un Post
* On peut supprimer le template contact.php

* L'idée est de permettre de gérer le maximum de code dans MySQL
* cela va alléger le code PHP

* On supprime aussi le template login.php
* A la place, on crée un Post pour le formulaire et un autre pour la page /login
* Et la page insère le formulaire avec @/form/post/form-login

* Ajout de la méthode ExtForm::runInfo
* Cela permet de supprimer le template info.php

* Ajout de la méthode ExtForm::runLogout
* Cela permet de supprimer le template logout.php
* On modifie le template-code.php pour gérer ces pages spéciales avec catégory=command

* On crée dans Post le formulaire d'installation
* Cela permet de supprimer le fichier template/page-section/install.php

* On crée dans Post le contenu de la page d'accueil (index)
* Cela permet de supprimer le fichier template/page-section/index.php

## Ajout de tracking sur Temps de la requête et Mémmoire consommée

* On ajoute 2 colonnes dans la table Visit
* requestTime   INT(11)     => en ms
* requestMemoy  INT(11)     => en ko
* Ajout de code PHP pour suivre la consommation de ressources (temps et mémoire à chaque requête)
* https://www.php.net/manual/fr/function.hrtime.php
* https://www.php.net/manual/fr/function.memory-get-peak-usage.php


## Ajout de table SQL FIle

* On ajoute une table SQL File
* On ajoute sur la page admin, un formulaire de création pour File
* En plus de stocker la ligne dans SQL, on crée un fichier cache dans le dossier my-work/
* Cela permet de créer des fichiers "virtuels"
* ces fichiers seront historisés dans la table SQL
* la dernière version sera dans le fichier cache
* Ensuite, on modifiera le code PHP pour aller chercher ces fichiers cache en plus des fichiers du framework !!!

## Modification code Site pour gérer les fichiers cache

* En plus de chercher le fichier du framework, on cherche si un fichier cache équivalent existe
* Test:
* Ajout dans File de private/template/template-membre.php 
* => cela crée un fichier cache dans my-work/
* suppression du fichier réel private/template/template-membre.php
* quand on affiche l'espace membre, c'est le fichier cache qui est utilisé ;-p
* => on peut maintenant stocker du code PHP dans SQL
* => le framework PHP garde des fichiers cache PHP pour les utiliser
* => le repo git ne verra pas ces fichiers cache, donc git ne donne plus la vision complète du code

## Ajout de chargement de classe à partir des fichiers cache File

* On ajoute une nouvelle fonction callback pour le chargement automatique de classe
* On va chercher dans le dossier cache my-work/ si un fichier cache File correspond
* si oui, alors on charge le code PHP de la classe
* => On peut maintenant ajouter du code HTML et PHP avec la partie admin
* => Cela permet de coder des formulaires avec leur traitement !

## templates avec fichiers virtuels

* on fait évoluer les templates pour pouvoir gérer avec les fichiers virtuels
* les templates de private/template/page/
* les templates de private/template/page-section/
* les templates de private/template/
* Ajout d'un paramètre de configuration templatePriority="virtual" pour donner la priorité aux fichiers virtuels

## Admin: ajout de Read et Delete sur File

* On affiche la liste des File
* On peut supprimer une ligne File (et cela supprime aussi le fichier virtuel de cache)
* On peut aussi supprimer l'ensemble des fichiers virtuels
* Si un fichier virtuel n'est pas trouvé, on va chercher si une ligne File correspond
* Si oui, on crée de nouveau le fichier virtuel de cache
* ATTENTION: 
* cela peut provoquer trop de requêtes SQL en SELECT... 
* => suivre les performances pour optimiser si besoin...

## Email: envoi en HTML et pièce jointe

* Ajout envoi email html et pièce jointe
* Ajout d'envoi du fichier File par email dans traitement de formulaire File Create
* retour à microtime car hrtime disponible pour PHP7.3+ seulement

## Monaco Editor

* Il faudrait pouvoir écrire du code avec plus d'outils qu'un simple champ textarea
* On ajoute l'éditeur Monaco Editor dans la partie admin
* https://github.com/microsoft/monaco-editor
* Pour combiner monaco editor et vuejs, on crée un nouvel template vuejs 
* et ensuite, on charge le JS de monaco editor sur l'événement "mounted" dans le template vuejs

## Améliorations UX admin

* Monaco Editor plus grand
* Ajout range pour longueur de texte dans td
* Ajout monaco editor dans Post Create et Update
* Ajout "click to copy" sur les td pour créer à partir d'un code existant
* améliorations CSS

## Ajout de Vuetify dans l'espace membre

* https://vuetifyjs.com/en/
* La version 2 vient de sortir
* Vuetify est une bibliothèque de composants UI pour VueJS
* Le design sur les principes du Material Design V2

## Ajout de template RevealJS pour créer des slideshows

* https://revealjs.com/#/
* RevealJS est un framework JS pour créer des présentations (slideshow)
* Il est facilement utilisable avec du HTML, CSS et JS
* Il est possible d'utiliser le format Markdown pour le contenu
* Il est possible de charger le contenu Markdown à partir d'une URL

## Ajout de template Adminer

* Pour gérer plus efficacement la base de données
* tout le code tient en une seule page
* https://www.adminer.org
* un template est maintenant disponible

## Ajout de colonne priority dans Post

* On a besoin de pouvoir choisir l'ordre d'affichage des Post dans une boucle
* La colonne priority permet de donner un tri prioritaire 
* et ensuite un deuxieme tri sur les plus récents
* les codes CRU doivent être modifiés pour gérer cette colonne priority qui est un entier
