
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

// traitement du formulaire
function getInfo($name, $default="")
{
    return trim(strip_tags($_REQUEST["$name"] ?? "$default"));
}
$nom        = getInfo("nom");
$email      = getInfo("email");
if (($nom != "") && (filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    // sauvegarder dans un fichier CSV
    file_put_contents("$baseDir/private/newsletter-$today.csv", "$nom,$email,$today $now\n", FILE_APPEND);

    // message feedback
    echo "merci de votre inscription avec $email ($nom)";

    // on envoie un mail
    // https://www.php.net/manual/fr/function.mail.php
    $headers =  'From: hello@workodin.com' . "\r\n" .
                'Reply-To: hello@workodin.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

    @mail("hello@workodin.com", "newsletter/$email/$nom", "nouvel inscrit: $email / $nom", $headers);
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
                        <p>Venez rencontrer des développeurs de tous niveaux, femmes et hommes, de tout âge sur la France entière, et même au delà des frontières !</p>
                        <p>Travaillez en équipe sur des projets innovants et motivants!</p>
                        <p><a href="https://github.com/workodin/workodin.com">Participez au développement du site workodin.com sur GitHub</a></p>
                    </div>
                </div>
            </section>
