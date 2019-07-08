
<section>
    <h2>Installation</h2>
    <div class="row">
        <div class="col col40">
            <form id="form-install" action="#form-install" method="POST">
                <label for="form-key">clé</label>
                <input id="form-key" type="text" name="password" required placeholder="votre clé d'installation">
                <label for="form-code">code</label>
                <textarea id="form-code" name="code" required placeholder="votre code" rows="8">
-- installation
SQL
USER                
                </textarea>
                <button type="submit">démarrer</button>
                <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                <input type="hidden" name="formKey" value="Install">
                <div class="feedback">
                    <?php $form->process("Install") ?>
                </div>
            </form>
        </div>
    </div>
</section>
