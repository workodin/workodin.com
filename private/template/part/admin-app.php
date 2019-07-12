<script>
// on prépare avec PHP les infos nécessaires pour JS
// on utiilise PHP pour créer du code JS
var php = {};
php.nbPost     = <?php echo Site::Get("Model")->count("Post") ?>;
php.loginUser  = '<?php echo Site::Get("Session")->get("loginUser") ?>';
php.idUser     = '<?php echo Site::Get("Session")->get("idUser") ?>';

</script>

<div id="app">
    <div class="toolbar">
        <div>{{ message }}</div>
        <div><button v-on:click="actSQL">SQL</button></div>
        <div>Post: {{ nbPost }}</div>
        <div>User: {{ loginUser }} ({{ idUser }})</div>
    </div>
    <div class="popup" v-bind:class="popupClass">
        <div class="popupPanel">
        <div class="btnClose"><a href="#" v-on:click="actPopupHide">fermer</a></div>
            <form method="POST" action="#" class="ajax">
                <textarea type="text" name="code" required placeholder="code" rows=10></textarea>
                <input type="text" name="format" required placeholder="format">
                <button type="submit">envoyer</button>
                <input type="hidden" name="formTagMethod" value="Sql">
                <input type="hidden" name="formKey" value="Admin">
                <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
                <div class="feedback">
                    <?php $form->process("Admin") ?>
                </div>

            </form>
        </div>
    </div>
</div>

