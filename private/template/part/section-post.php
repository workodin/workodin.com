<section>
    <h2><?php echo $title ?></h2>
    <div>
<pre class="post">
<?php echo $code ?? "" ?>
</pre>
    </div>

    <div class="listPost row">
<?php Site::Get("View")->showPost("category", $pageUri, "publicationDate") ?>
    </div>
</section>