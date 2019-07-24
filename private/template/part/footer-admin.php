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
        <h3>Liste des File</h3>
        <div class="tableBox">
            <table v-if="tabFile.length > 0">
                <thead>
                    <tr>
                        <td v-for="curHead in tabHeadFile"{{ curHead }}></td>
                    </tr>
                </thead>
                <tbody>
                    <tr is="tr-dyn" v-on:post-delete="actFileDelete" v-for="(post, index) in tabFile" :key="post.id" :post="post">
                    </tr>
                </tbody>
            </table>
            <p v-else><button v-on:click="actSQL">SQL</button></p>
        </div>
    </div>

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
                    <tr is="tr-dyn" v-on:post-update="actPostUpdate" v-on:post-delete="actPostDelete" v-for="(post, index) in tabResult" :key="post.id" :post="post">
                    </tr>
                </tbody>
            </table>
            <p v-else><button v-on:click="actSQL">SQL</button></p>
        </div>
    </div>

    <div class="toolbar">
        <div><a href="#" v-on:click="actPostCreate">Post</a></div>
        <div><a href="#" v-on:click="actPostRead">Refresh Post</a></div>
        <div><a href="#" v-on:click="actSQL">SQL</a></div>
        <div><a href="#" v-on:click="actFileCreate">File Create</a></div>
        <div><a href="#" v-on:click="actFileCacheReset">File Cache Reset</a></div>
        <div>tabResult: {{ tabResult.length }}</div>
        <div><input type="range" v-model="maxLength" min="" max="2000" step="50"></div>
        <div>{{ maxLength }}</div>
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
                    <input type="text" name="format" required placeholder="format">
                    <textarea type="text" name="code" required placeholder="code" rows=10 v-model="codeSQL"></textarea>
                    <button type="submit">envoyer</button>
                    <input type="hidden" name="formTagMethod" value="Sql">
                    <input type="hidden" name="formTag" value="Admin">
                    <input type="hidden" name="formKey"  v-model="formKey">
                    <div class="feedback">
                    </div>
                </form>
            </div>

            <div v-if="panelActive == 'formFileCreate'">
                <monaco-editor :post="curPost"></monaco-editor>
                <form  v-on:submit.prevent="wk.sendAjax" method="POST" action="#" class="ajax">
                    <textarea class="codeFile" type="text" name="code" required placeholder="code" rows=10 v-model="codeFile"></textarea>
                    <input type="text" name="path" required placeholder="path">
                    <button type="submit">envoyer</button>
                    <input type="hidden" name="formTagMethod" value="File">
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
                    <label for="form-urlMedia-update">url Media ({{ curPost.urlMedia }})</label>
                    <input id="form-urlMedia-update" type="file" name="urlMedia" placeholder="upload Media">
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

    <div v-if="panelActive == 'formFileCreate'">
        {{ showEditor }}
    </div>

</div>
<!--/ app -->

        </main>
        <footer class="row">
        <div class="col col50 footer1">
            <nav class="menu-footer-1">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-1") ?>
                </ul>
            </nav>
        </div>    
        <div class="col col50 footer2">
        <nav class="menu-footer-2">
                <ul>
                    <?php Site::Get("View")->showMenu("menu-footer-2") ?>
                </ul>
            </nav>
            <p><small>(page publiée le <?php echo date("d/m/Y - H:i:s") ?>)</small></p>
        </div>    
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.17.1/min/vs/loader.js"></script>

    <script>
<?php require_once("$baseDir/public/assets/js/site.js") ?>
<?php require_once("$baseDir/public/assets/js/site-admin.js") ?>
    </script>

</body>
</html>
