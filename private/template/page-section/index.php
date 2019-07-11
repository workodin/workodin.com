
<section>
    <h2>Formation professionnelle, intensive et rapide</h2>
    <div class="listPost row">
<?php Site::Get("View")->showPost("category", "index", "publicationDate") ?>

        <article>
            <h3>Rejoignez une communauté de partage et d'entraide</h3>
            <p>Venez rencontrer des développeurs de tous niveaux, femmes et hommes, de tout âge sur la France entière, et même au delà des frontières !</p>
            <p>Travaillez en équipe sur des projets innovants et motivants!</p>
            <p><a href="https://github.com/workodin/workodin.com">Participez au développement du site workodin.com sur GitHub</a></p>
        </article>

        <article>
            <h3>Vous avez une question ?</h3>
            <h4><a href="/contact">Contactez-nous !</a></h4>
            <figure>
                <img src="/assets/images/workodin-team2.jpg" alt="workodin team">
            </figure>
        </article>
        
        <article>
            <h3>Suivez le projet</h3>
            <h4>inscrivez-vous à la newsletter</h4>
                <form id="form-newsletter" action="#form-newsletter" method="POST" class="ajax">
                    <label for="form-nom">nom</label>
                    <input id="form-nom" type="text" name="name" required placeholder="votre nom">
                    <label for="form-email">email</label>
                    <input id="form-email" type="email" name="email" required placeholder="votre email">
                    <button type="submit">inscription</button>
                    <input type="hidden" name="formKey" value="Newsletter">
                    <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                    <div class="feedback">
                        <?php $form->process("Newsletter") ?>
                    </div>
                </form>
        </article>
    </div>
</section>
