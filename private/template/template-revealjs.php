<?php
// on récupère la source markdown
$urlMarkdown = $form->getInfo("source");
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title>reveal.js</title>

		<link rel="stylesheet" href="/assets/revealjs/css/reset.css">
		<link rel="stylesheet" href="/assets/revealjs/css/reveal.css">
		<link rel="stylesheet" href="/assets/revealjs/css/theme/black.css">

		<!-- Theme used for syntax highlighting of code -->
		<link rel="stylesheet" href="/assets/revealjs/lib/css/monokai.css">

		<!-- Printing and PDF exports -->
		<script>
			var link = document.createElement( 'link' );
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.href = window.location.search.match( /print-pdf/gi ) ? '/assets/revealjs/css/print/pdf.css' : '/assets/revealjs/css/print/paper.css';
			document.getElementsByTagName( 'head' )[0].appendChild( link );
		</script>
	</head>
	<body>
		<div class="reveal">
			<div class="slides">
				<?php if ($urlMarkdown): ?>
				<section data-markdown="<?php echo $urlMarkdown ?>"></section>
				<?php else: ?>
				<section><?php echo date("H:i:s") ?></section>
				<?php endif; ?>
			</div>
		</div>

		<script src="/assets/revealjs/js/reveal.js"></script>

		<script>
			// More info about config & dependencies:
			// - https://github.com/hakimel/reveal.js#configuration
			// - https://github.com/hakimel/reveal.js#dependencies
			Reveal.initialize({
				dependencies: [
					{ src: '/assets/revealjs/plugin/markdown/marked.js' },
					{ src: '/assets/revealjs/plugin/markdown/markdown.js' },
					{ src: '/assets/revealjs/plugin/notes/notes.js', async: true },
					{ src: '/assets/revealjs/plugin/highlight/highlight.js', async: true }
				]
			});
		</script>
	</body>
</html>