<?php

$id = $form->getInt("id");
$objPDOStatement = Site::Get("Model")->readLine("Post", "id", $id);
foreach($objPDOStatement as $tabLine)
{
    // SECURITE: protection contre les attaques XSS
    // https://www.php.net/manual/fr/function.array-map.php
    // array_map("htmlspecialchars", $tabLine);
    extract($tabLine);

    $htmlForm =
<<<HTML
        <label for="form-title">title</label>
        <input id="form-title" type="text" name="title" required placeholder="titre" value="$title">
        <label for="form-uri">uri</label>
        <input id="form-uri" type="text" name="uri" required placeholder="uri" value="$uri">
        <label for="form-category">categorie</label>
        <input id="form-category" type="text" name="category" required placeholder="catégorie" value="$category">
        <label for="form-code">code</label>
        <textarea id="form-code" name="code" required placeholder="votre code" rows="20">$code</textarea>
        <label for="form-urlMedia">url Media</label>
        <input id="form-urlMedia" type="text" name="urlMedia" required placeholder="url Media" value="$urlMedia">
        <input type="hidden" name="id" value="$id">

HTML;

}
?>
<?php if (!empty($tabLine)): ?>
<section>
    <h3>Modification de contenu</h3>
    <form id="form-post" action="#form-post" method="POST">
        <?php echo $htmlForm ?>
        <button type="submit">modifier votre contenu</button>
        <input type="hidden" name="formKey" value="Post">
        <input type="hidden" name="formTag" value="<?php $form->show("formKeyPublic") ?>">
        <input type="hidden" name="formTagMethod" value="Update">
        <div class="feedback">
            <?php $form->process("Post") ?>
        </div>
    </form>
</section>
<?php endif; ?>