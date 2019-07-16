<script>
// on prépare avec PHP les infos nécessaires pour JS
// on utiilise PHP pour créer du code JS
var php = {};
php.nbPost     = <?php echo Site::Get("Model")->count("Post") ?>;
php.loginUser  = '<?php echo Site::Get("Session")->get("loginUser") ?>';
php.idUser     = '<?php echo Site::Get("Session")->get("idUser") ?>';
php.formKey    = '<?php $form->show("formKeyPublic") ?>';
</script>

<div id="app">
    <div class="boxResult">
        <div><pre>{{ codeSQL }}</pre></div>
        <h3>Liste des Résultats</h3>
        <div class="tableBox">
            <table v-if="tabResult.length > 0">
                <thead>
                    <tr>
                        <td v-for="curHead in tabHead"{{ curHead }}></td>
                    </tr>
                </thead>
                <tbody>
                    <tr is="tr-dyn" v-on:post-update="actPostUpdate" v-for="(post, index) in tabResult" :key="post.id" :post="post">
                    </tr>
                </tbody>
            </table>
            <p v-else><button v-on:click="actSQL">SQL</button></p>
        </div>
    </div>

    <div class="toolbar">
        <div><button v-on:click="actPostCreate">Post</button></div>
        <div><button v-on:click="actPostRead">Refresh Post</button></div>
        <div><button v-on:click="actSQL">SQL</button></div>
        <div>tabResult: {{ tabResult.length }}</div>
        <div>Post: {{ nbPost }}</div>
        <div><input type="checkbox" id="mustConfirmDelete" v-model="mustConfirmDelete"><label for="mustConfirmDelete">confirmation avant delete</label></div>
        <div>{{ message }}</div>
        <div>User: {{ loginUser }} ({{ idUser }})</div>
        <div><a href="/logout">déconnexion</a></div>
    </div>

    <div class="popup" v-bind:class="popupClass">
        <div class="popupPanel">
            <div class="btnClose"><a href="#" v-on:click="actPopupHide">fermer</a></div>
            <div v-if="panelActive == 'formSQL'">
                <p>note: les requêtes en lectre doivent commencer avec SELECT...</p>
                <form  v-on:submit.prevent="wk.sendAjax" method="POST" action="#" class="ajax">
                    <textarea type="text" name="code" required placeholder="code" rows=10 v-model="codeSQL"></textarea>
                    <input type="text" name="format" required placeholder="format">
                    <button type="submit">envoyer</button>
                    <input type="hidden" name="formTagMethod" value="Sql">
                    <input type="hidden" name="formTag" value="Admin">
                    <input type="hidden" name="formKey"  v-model="formKey">
                    <div class="feedback">
                    </div>
                </form>
            </div>
            <div v-if="panelActive == 'formPostCreate'">
                <h3>Ajouter un Post</h3>
                <form v-on:submit.prevent="wk.sendAjax" id="form-post" action="#form-post" method="POST" enctype="multipart/form-data" class="ajax">
                    <label for="form-title">title</label>
                    <input id="form-title" type="text" name="title" required placeholder="titre">
                    <label for="form-uri">uri</label>
                    <input id="form-uri" type="text" name="uri" required placeholder="uri">
                    <label for="form-category">categorie</label>
                    <input id="form-category" type="text" name="category" required placeholder="catégorie">
                    <label for="form-template">template</label>
                    <input id="form-template" type="text" name="template" placeholder="template">
                    <label for="form-code">code</label>
                    <textarea id="form-code" name="code" required placeholder="votre code" rows="20" v-model="formCode"></textarea>
                    <label for="form-urlMedia">url Media</label>
                    <input id="form-urlMedia" type="file" name="urlMedia" placeholder="upload Media">
                    <p>nb caractères: {{formCode.length }}</p>
                    <button type="submit">publier votre contenu</button>
                    <input type="hidden" name="formKey"  v-model="formKey">
                    <input type="hidden" name="formTag" value="Admin">
                    <input type="hidden" name="formTagMethod" value="Create">
                    <input type="hidden" name="formResponse" value="Ajax">
                    <div class="feedback">
                    </div>
                </form>
            </div>
            <div v-if="panelActive == 'formPostUpdate'">
                <h3>Modifier un Post ({{ curPost.id}})</h3>
                <form v-on:submit.prevent="wk.sendAjax" id="form-post" action="#form-post" method="POST" enctype="multipart/form-data" class="ajax">
                    <label for="form-title">title</label>
                    <input id="form-title" type="text" name="title" required placeholder="titre" v-model="curPost.title">
                    <label for="form-uri">uri</label>
                    <input id="form-uri" type="text" name="uri" required placeholder="uri" v-model="curPost.uri">
                    <label for="form-category">categorie</label>
                    <input id="form-category" type="text" name="category" required placeholder="catégorie" v-model="curPost.category">
                    <label for="form-template">template</label>
                    <input id="form-template" type="text" name="template" placeholder="template" v-model="curPost.template">
                    <label for="form-code">code</label>
                    <textarea id="form-code" name="code" required placeholder="votre code" rows="20" v-model="curPost.code"></textarea>
                    <label for="form-urlMedia">url Media ({{ curPost.urlMedia }})</label>
                    <input id="form-urlMedia" type="file" name="urlMedia" placeholder="upload Media">
                    <p>nb caractères: {{ curPost.code.length }}</p>
                    <button type="submit">modifier votre contenu</button>
                    <input type="hidden" name="formKey"  v-model="formKey">
                    <input type="hidden" name="formTag" value="Admin">
                    <input type="hidden" name="formTagMethod" value="Update">
                    <input type="hidden" name="id" v-model="curPost.id">
                    <input type="hidden" name="formResponse" value="Ajax">
                    <div class="feedback">
                    </div>
                </form>
            </div>
        </div>    
    </div>
</div>

