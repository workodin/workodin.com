<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Workodin.com : le site pour trouver et préparer votre poste de développeur web depuis chez vous</title>
    <meta name="description" content="Workodin : le site pour trouver et préparer votre poste de développeur web depuis chez vous">
    <meta name="keywords" content="emploi, formation, développeur web, formation distance">

    <link rel="icon" type="image/png" href="/assets/images/icon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <style>
html, body {
    width:100%;
    height:100%;
    font-size:16px;
    box-sizing:border-box;
    margin:0;
    padding:0;
    background-color:#000000;
    font-family: 'Roboto', sans-serif;
}    
.page {
    max-width:1280px;
    margin:0 auto;
    background-color:#ffffff;
    min-height:100%;
    background: url('/assets/images/workodin-workout.jpg');
    background-size:cover;
}
section {
    padding:1rem;
    background-color:rgba(255,255,255,0.8);
}
header, footer {
    background-color:rgba(0,0,0,0.8);
    color:#ffffff;
    min-height:10vmin;
}
header {
    padding:1rem;
}
a {
    color: #666666;
    text-decoration:none;
}
img {
    max-width:100%;
    object-fit:cover;   
}
figure {
    margin:0;
}
input, button {
    padding:0.5rem;
    margin:0.25rem;
    font-size:1rem;
}
form .feedback {
    padding:1rem;
}
/* flex */
.row {
    display:flex;
    flex-wrap:wrap;
    width:100%;
}
.col {
    min-width:320px;
    padding-top:1rem;
}
.col50 {
    width:50%;
}
.col40 {
    width:40%;
}
.col30 {
    width:30%;
}
.col p {
    margin-top:0;
    padding-left:1rem;
}

    </style>
</head>
<body>
    <div class="page">
        <header>
            <h1><a href="/">Workodin.com</a></h1>
            <strong>Workout & Coding. Everyday & Everywhere.</strong>
        </header>
        <main>

            <section>
                <h2>Découvrez les offres d'emploi Développeur Web Fullstack, près de chez vous</h2>
                <p>Nous allons construire un observatoire des offres d'emploi sur la France.</p>
                <p>Entreprises: détaillez votre description de poste et les niveaux de compétences attendus.</p>
                <ul>
                    <li>HTML</li>
                    <li>CSS, Flex & Grid</li>
                    <li>JavaScript</li>
                    <li>PHP</li>
                    <li>SQL</li>
                </ul>
                <ul>
                    <li>Programmation Orientée Objet</li>
                    <li>MVC et Design Patterns</li>
                    <li>Framework et CMS</li>
                </ul>
                <ul>
                    <li>WordPress</li>
                    <li>Laravel</li>
                    <li>Symfony</li>
                </ul>
                <ul>
                    <li>VueJS</li>
                    <li>BabylonJS</li>
                    <li>jQuery</li>
                    <li>Bootstrap</li>
                </ul>
            </section>

            <section>
                <h2>Préparez vos compétences avec une formation à distance</h2>
                <p>Entrainez-vous aux techniques professionnelles pour réaliser des sites internet.</p>
                <p>Chaque jour, réussissez des exercices pratiques et apprenez de nouvelles techniques.</p>
                <ul>
                    <li>Site Vitrine (TPE, PME)</li>
                    <li>Site Blog (Magazine)</li>
                    <li>Site Petites Annonces (Marketplace)</li>
                </ul>
                
            </section>

            <section>
                <h2>Suivez le projet: inscrivez-vous à la newsletter</h2>
                <form id="form-newsletter" action="#form-newsletter" method="POST">
                    <label for="form-nom">nom</label>
                    <input id="form-nom" type="text" name="nom" required placeholder="votre nom">
                    <label for="form-email">email</label>
                    <input id="form-email" type="text"  type="email" name="email" required placeholder="votre email">
                    <button type="submit">je soutiens ce projet !</button>
                    <div class="feedback">
<?php
// https://www.php.net/manual/fr/function.date-default-timezone-set.php
date_default_timezone_set("Europe/Paris");

// traitement du formulaire
function getInfo($name, $default="")
{
    return trim(strip_tags($_REQUEST["$name"] ?? "$default"));
}
$nom        = getInfo("nom");
$email      = getInfo("email");
if (($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    $today = date("Y-m-d");
    $now   = date("H:i:s");
    // sauvegarder dans un fichier CSV
    file_put_contents(__DIR__ . "/../private/newsletter-$today.csv", "$nom,$email,$today $now\n", FILE_APPEND);

    // message feedback
    echo "merci de votre inscription avec $email ($nom)";
}
?>
                    </div>
                </form>
            </section>

            <section>
                <h2>Rejoignez une communauté de partage et d'entraide</h2>
                <div class="row">
                    <div class="col col40">
                        <figure>
                            <img src="/assets/images/workodin-team2.jpg" alt="workodin team">
                        </figure>
                    </div>
                    <div class="col col40">
                        <p>Venez rencontrer des développeurs de tous niveaux, femmes et hommes, de tout âge sur la France entière, et même au delà des frontières !.</p>
                        <p>Travaillez en équipe sur des projets innovants et motivants!</p>
                        <p><a href="https://github.com/workodin/workodin.com">Participez au développement du site sur GitHub</a></p>
                    </div>
                </div>
            </section>

       </main>
        <footer class="row">
        <div class="col col50">
            <p><a href="https://github.com/workodin/workodin.com">participez au développement du site sur GitHub</a></p>
        </div>    
        <div class="col col50">
            <p><a href="//workodin.com">workodin.com</a> - tous droits réservés - &copy;2019</p>
            <p><a href="//workodin.com/credits">crédits</a> - <a href="//workodin.com/mentions-legales">mentions légales</a></p>
            <p><small>(page publiée le <?php echo date("d/m/Y - H:i:s") ?>)</small></p>
        </div>    
        </footer>
    </div>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-143142316-1"></script>
    <script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-143142316-1');
    </script>

</body>
</html>