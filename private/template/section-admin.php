<section>
    <h3>Bienvenue <?php echo $loginUser ?></h3>
    <p><a href="/logout">déconnexion</a></p>
</section>

<section>
    <h3>Gestion des Contenus</h3>
    <form id="form-post" action="#form-post" method="POST">
        <label for="form-title">title</label>
        <input id="form-title" type="text" name="title" required placeholder="titre">
        <label for="form-uri">uri</label>
        <input id="form-uri" type="text" name="uri" required placeholder="uri">
        <label for="form-category">categorie</label>
        <input id="form-category" type="text" name="category" required placeholder="catégorie">
        <label for="form-code">code</label>
        <textarea id="form-code" name="code" required placeholder="votre code" rows="20"></textarea>
        <label for="form-urlMedia">url Media</label>
        <input id="form-urlMedia" type="text" name="urlMedia" required placeholder="url Media">
        <button type="submit">publier votre contenu</button>
        <input type="hidden" name="formKey" value="Post">
        <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
        <input type="hidden" name="formTagMethod" value="Create">
        <div class="feedback">
            <?php $form->process("Post") ?>
        </div>
    </form>
    
</section>

<section>
    <h3>Liste des contenus</h3>
    <table>
        <tbody>
<?php
$objModel = Site::Get("Model");
$objPDOStatement = $objModel->readLine("Post");
foreach($objPDOStatement as $tabLine)
{
    // SECURITE: protection contre les attaques XSS
    // https://www.php.net/manual/fr/function.array-map.php
    array_map("htmlspecialchars", $tabLine);
    
    echo "<tr>";
    foreach($tabLine as $column => $value)
    {
        echo "<td>$value</td>";
    }    
    echo "</tr>";
}
?>
        </tbody>
    </table>
<section>