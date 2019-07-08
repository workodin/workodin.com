
<section>
    <h2>Merci de vous identifier</h2>
    <div class="row">
        <div class="col col40">
            <form id="form-login" action="#form-login" method="POST">
                <label for="form-email">email</label>
                <input id="form-email" type="email" name="email" required placeholder="votre email">
                <label for="form-password">email</label>
                <input id="form-password" type="password" name="password" required placeholder="votre mot de passe">
                <button type="submit">se connecter</button>
                <input type="hidden" name="formKey" value="Login">
                <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                <div class="feedback">
                    <?php $form->process("Login") ?>
                </div>
            </form>
        </div>
    </div>
</section>
