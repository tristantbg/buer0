<?php snippet('header') ?>

<video class="media js-player" poster="<?= $page->file('buero.png')->url() ?>" width="100%">
	<source src="<?= $page->file('trailer_js.webm')->url() ?>" type="video/webm">
	<source src="<?= $page->file('trailer_js.mp4')->url() ?>" type="video/mp4">
</video>
<br>
<div class="caption" style="text-align: center"><?= $page->text()->kt() ?></div>
<br>

<?php snippet('footer') ?>