<?php require_once("$viewDir/part/admin-app.php") ?>

<section>
    <h3>Bienvenue <?php echo $loginUser ?></h3>
    <p><a href="/logout">déconnexion</a></p>
</section>

<section>
    <h3>Gestion des Contenus</h3>
    <form id="form-post" action="#form-post" method="POST" enctype="multipart/form-data" class="ajax">
        <label for="form-title">title</label>
        <input id="form-title" type="text" name="title" required placeholder="titre">
        <label for="form-uri">uri</label>
        <input id="form-uri" type="text" name="uri" required placeholder="uri">
        <label for="form-category">categorie</label>
        <input id="form-category" type="text" name="category" required placeholder="catégorie">
        <label for="form-template">template</label>
        <input id="form-template" type="text" name="template" placeholder="template">
        <label for="form-code">code</label>
        <textarea id="form-code" name="code" required placeholder="votre code" rows="20"></textarea>
        <label for="form-urlMedia">url Media</label>
        <input id="form-urlMedia" type="file" name="urlMedia" placeholder="upload Media">
        <button type="submit">publier votre contenu</button>
        <input type="hidden" name="formKey" value="Post">
        <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
        <input type="hidden" name="formTagMethod" value="Create">
        <div class="feedback">
            <?php $form->process("Post") ?>
        </div>
    </form>
    
</section>

<?php

$objModel           = Site::Get("Model");
$objPDOStatement    = $objModel->readLine("Post", "", "", "creationDate");
$formKey            = $form->get("formKeyPublic");
$tabColumn          = [];

$publicDir          = Site::Get("publicDir");

// mise en buffer de l'affichage
// https://www.php.net/manual/fr/function.ob-start.php
ob_start();
foreach($objPDOStatement as $tabLine)
{
    // nom des colonnes
    if (empty($tabColumn))
    {
        $tabColumn = array_keys($tabLine);
    }
    // SECURITE: protection contre les attaques XSS
    // https://www.php.net/manual/fr/function.array-map.php
    array_map("htmlspecialchars", $tabLine);

    echo "<tr>";
    foreach($tabLine as $column => $value)
    {
        if (($column == "urlMedia") && is_file("$publicDir/$value"))
        {
            echo 
<<<HTML
        <td><img src="/$value"></td>
HTML;
        }
        elseif ($column == "code")
        {
            echo 
<<<HTML
        <td><textarea rows="10" disabled>$value</textarea></td>
HTML;
        }
        else
        {
            echo "<td>$value</td>";
        }
    }
    extract($tabLine);    
    // on ajoute une colonne pour le lien delete
    echo 
<<<HTML
    <td><a href="/$uri">voir</a></td>
    <td><a href="admin-update.php?id=$id">modifier</a></td>
    <td><a href="?id=$id&formTag=Post&formTagMethod=Delete&formKey=$formKey">supprimer</a></td>
HTML;

    echo "</tr>";
}

// fin du buffer
// https://www.php.net/manual/fr/function.ob-get-clean.php
$htmlTable = ob_get_clean();

$htmlTableHead = "";
foreach($tabColumn as $column)
{
    $htmlTableHead .= "<td>$column</td>";
}
// colonnes: voir, modifier et supprimer
$htmlTableHead .= "<td></td><td></td><td></td>";

?>
<section>
    <h3>Liste des contenus</h3>
    <div class="tableBox">
        <table>
            <thead>
            <?php echo $htmlTableHead ?>        
            </thead>
            <tbody>
<?php echo $htmlTable ?>        
            </tbody>
        </table>
    </div>
</section>