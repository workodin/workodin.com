
<section>
    <div class="listPost row">
<?php Site::Get("View")->showPost("category", "index", "publicationDate") ?>

        <article>
            <h3>Rejoignez une communauté de partage et d'entraide</h3>
            <h4>Vous avez une question ? <a href="/contact">Contactez-nous !</a></h4>
            <p>Venez rencontrer des développeurs de tous niveaux, femmes et hommes, de tout âge sur la France entière, et même au delà des frontières !</p>
            <p>Travaillez en équipe sur des projets innovants et motivants!</p>
            <p><a href="https://github.com/workodin/workodin.com">Participez au développement du site workodin.com sur GitHub</a></p>
        </article>
        <article>
            <figure>
                <img src="/assets/images/workodin-team2.jpg" alt="workodin team">
            </figure>
        </article>
        <article>
            <h4>Suivez le projet: inscrivez-vous à la newsletter</h4>
            <div class="row">
                <div class="col col40">
                    <form id="form-newsletter" action="#form-newsletter" method="POST">
                        <label for="form-nom">nom</label>
                        <input id="form-nom" type="text" name="name" required placeholder="votre nom">
                        <label for="form-email">email</label>
                        <input id="form-email" type="email" name="email" required placeholder="votre email">
                        <button type="submit">je soutiens ce projet !</button>
                        <input type="hidden" name="formKey" value="Newsletter">
                        <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                        <div class="feedback">
                            <?php $form->process("Newsletter") ?>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </div>
</section>
