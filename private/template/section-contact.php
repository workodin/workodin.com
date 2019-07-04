
<section>
    <h2>Contactez-nous !</h2>
    <div class="row">
        <div class="col col40">
            <form id="form-contact" action="#form-contact" method="POST">
                <label for="form-nom">nom</label>
                <input id="form-nom" type="text" name="nom" required placeholder="votre nom">
                <label for="form-email">email</label>
                <input id="form-email" type="text"  type="email" name="email" required placeholder="votre email">
                <label for="form-message">message</label>
                <textarea id="form-message" name="message" required placeholder="votre message" rows="8"></textarea>
                <button type="submit">envoyer votre message</button>
                <input type="hidden" name="formTag" value="Contact">
                <div class="feedback">
                    <?php $form->process("Contact") ?>
                </div>
            </form>
        </div>
    </div>
</section>
