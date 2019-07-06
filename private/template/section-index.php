
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
                    <li>Programmation Fonctionnelle</li>
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
                <p>Vous avez une question ? <a href="/contact">Contactez-nous !</a></p>
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
                <div class="row">
                    <div class="col col40">
                        <form id="form-newsletter" action="#form-newsletter" method="POST">
                            <label for="form-nom">nom</label>
                            <input id="form-nom" type="text" name="name" required placeholder="votre nom">
                            <label for="form-email">email</label>
                            <input id="form-email" type="text"  type="email" name="email" required placeholder="votre email">
                            <button type="submit">je soutiens ce projet !</button>
                            <input type="hidden" name="formKey" value="Newsletter">
                            <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                            <div class="feedback">
                                <?php $form->process("Newsletter") ?>
                            </div>
                        </form>
                    </div>
                </div>
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
