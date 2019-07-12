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
    <div>Post: {{ nbPost }}</div>
    <div>User: {{ loginUser }} ({{ idUser }})</div>
  </div>
</div>

