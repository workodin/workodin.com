<?php

$id = $form->getInt("id");
$objPDOStatement = Site::Get("Model")->readLine("Post", "id", $id);
foreach($objPDOStatement as $tabLine)
{
    // SECURITE: protection contre les attaques XSS
    // https://www.php.net/manual/fr/function.array-map.php
    // array_map("htmlspecialchars", $tabLine);
    extract($tabLine);

    $htmlMedia = "";
    if ($urlMedia != "")
    {
        $htmlMedia =
<<<CODEHTML
<img src="$urlMedia" title="$urlMedia">
<span>$urlMedia</span>
CODEHTML;

    }
    $htmlForm =
<<<HTML
        <label for="form-title">titre</label>
        <input id="form-title" type="text" name="title" required placeholder="titre" value="$title">
        <label for="form-uri">uri</label>
        <input id="form-uri" type="text" name="uri" required placeholder="uri" value="$uri">
        <label for="form-category">catégorie</label>
        <input id="form-category" type="text" name="category" required placeholder="catégorie" value="$category">
        <label for="form-template">template</label>
        <input id="form-template" type="text" name="template" placeholder="template" value="$template">
        <label for="form-code">code</label>
        <textarea id="form-code" name="code" required placeholder="votre code" rows="20">$code</textarea>
        <label for="form-urlMedia">url Media</label>
        $htmlMedia
        <input id="form-urlMedia" type="file" name="urlMedia" placeholder="upload Media">
        <label for="form-publicationDate">date Publication</label>
        <input id="form-publicationDate" type="text" name="publicationDate" placeholder="Y-m-d H:i:s" value="$publicationDate">
        <input type="hidden" name="id" value="$id">

HTML;

}
?>
<?php if (!empty($tabLine)): ?>
<section>
    <h3>Modification de contenu</h3>
    <form id="form-post" action="#form-post" method="POST" enctype="multipart/form-data">
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