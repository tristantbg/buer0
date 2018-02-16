<!DOCTYPE html>
<html lang="en" class="no-js">
<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-site-verification" content="vr1WjL-Njq48OG87EqLro1nV5XnHX2oJVWOvGXmnP70" />
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="canonical" href="<?php echo html($page->url()) ?>" />
	<?php if($page->isHomepage()): ?>
		<title><?= $site->title()->html() ?></title>
	<?php else: ?>
		<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
	<?php endif ?>
	<?php if($page->isHomepage()): ?>
		<meta name="description" content="<?= $site->description()->html() ?>">
	<?php else: ?>
		<meta name="DC.Title" content="<?= $page->title()->html() ?>" />
		<?php if(!$page->text()->empty()): ?>
			<meta name="description" content="<?= $page->text()->excerpt(250) ?>">
			<meta name="DC.Description" content="<?= $page->text()->excerpt(250) ?>"/ >
			<meta property="og:description" content="<?= $page->text()->excerpt(250) ?>" />
		<?php else: ?>
			<meta name="description" content="">
			<meta name="DC.Description" content=""/ >
			<meta property="og:description" content="" />
		<?php endif ?>
	<?php endif ?>
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="<?= $site->keywords()->html() ?>">
	<?php if($page->isHomepage()): ?>
		<meta itemprop="name" content="<?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $site->title()->html() ?>" />
	<?php else: ?>
		<meta itemprop="name" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>" />
	<?php endif ?>
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= html($page->url()) ?>" />
	<?php if($page->featured()->isNotEmpty() && $ogimage = $page->featured()->toFile()): ?>
		<?php $ogimage = $ogimage->width(1200) ?>
		<meta property="og:image" content="<?= $ogimage->url() ?>"/>
		<meta property="og:image:width" content="<?= $ogimage->width() ?>"/>
		<meta property="og:image:height" content="<?= $ogimage->height() ?>"/>
	<?php else: ?>
		<?php if($site->ogimage()->isNotEmpty() && $ogimage = $site->ogimage()->toFile()): ?>
			<?php $ogimage = $ogimage->width(1200) ?>
			<meta property="og:image" content="<?= $ogimage->url() ?>"/>
			<meta property="og:image:width" content="<?= $ogimage->width() ?>"/>
			<meta property="og:image:height" content="<?= $ogimage->height() ?>"/>
		<?php endif ?>
	<?php endif ?>

	<meta itemprop="description" content="<?= $site->description()->html() ?>">
	<link rel="apple-touch-icon" sizes="57x57" href="<?= url('assets/images/favicon/apple-icon-57x57.png') ?>">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= url('assets/images/favicon/apple-icon-60x60.png') ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= url('assets/images/favicon/apple-icon-72x72.png') ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= url('assets/images/favicon/apple-icon-76x76.png') ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= url('assets/images/favicon/apple-icon-114x114.png') ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= url('assets/images/favicon/apple-icon-120x120.png') ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= url('assets/images/favicon/apple-icon-144x144.png') ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= url('assets/images/favicon/apple-icon-152x152.png') ?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= url('assets/images/favicon/apple-icon-180x180.png') ?>">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?= url('assets/images/favicon/android-icon-192x192.png') ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= url('assets/images/favicon/favicon-32x32.png') ?>">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= url('assets/images/favicon/favicon-96x96.png') ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= url('assets/images/favicon/favicon-16x16.png') ?>">
	<link rel="manifest" href="<?= url('assets/images/favicon/manifest.json') ?>">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?= url('assets/images/favicon/ms-icon-144x144.png') ?>">
	<meta name="theme-color" content="#ffffff">
	<link rel="shortcut icon" href="<?= url('assets/images/favicon.ico') ?>">
	<link rel="icon" href="<?= url('assets/images/favicon.ico') ?>" type="image/x-icon">

	<?php 
	echo css('assets/css/build/build.min.css');
	echo js('assets/js/vendor/modernizr.min.js');
	?>
	
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url('assets/js/vendor/jquery.min.js') ?>">\x3C/script>')</script>

	<?php if(!$site->customcss()->empty()): ?>
		<style type="text/css">
			<?php echo $site->customcss()->html() ?>
		</style>
	<?php endif ?>

</head>
<body>

<div id="outdated">
	<div class="inner">
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser.
	<br>Please <a href="http://outdatedbrowser.com" target="_blank">upgrade your browser</a> to improve your experience.</p>
	</div>
</div>

<div id="loader"></div>

<div id="main">

  <header>
  	<div id="site-title">
  		<a href="<?= $site->url() ?>">
  			<h1>Buero</h1>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 342.1 77.9">
			<g fill="#868686">
			  <path d="M35.6 76.4H0V1.3h35c11.2 0 19.1 6.3 19.1 18.2 0 6.6-3.6 14.5-10.8 17.6C51 39.9 56 47.3 56 56.3c0 6.2-1.8 11.2-5.4 14.8-3.2 3.3-8.3 5.3-15 5.3zm-3.7-66.3H9.4v23.6h25.1c6.8 0 9.8-6.5 9.8-12.7 0-7.4-4.5-10.9-12.4-10.9zm14.5 45.8c0-7.8-4.6-13.4-13.2-13.4H9.4v25.6H33c8.5 0 13.4-3.4 13.4-12.2zM67.4 56V1.3h9.4v52.8c0 9.5 6.7 15 21 15 11.8 0 20.3-5.2 20.3-14.9V1.3h9.4v54.9c0 13.9-12.7 21.6-29.9 21.6-17.2.1-30.2-6.7-30.2-21.8zM142.1 76.4V1.3H192V10h-40.7v24.1h39v8.7h-39v24.8h41.1v8.7h-50.3zM268.8 76.4h-10.5l-16.7-32.8h-26.4v32.8h-9.4V1.3h37.8c14 0 19.7 8.4 19.7 20.7 0 9.8-3.4 18-12.6 19.7l18.1 34.7zm-53.5-66.3v25.1h27.1c9-.5 11.2-3.9 11.2-12.4 0-10.3-2.9-12.8-12.8-12.8h-25.5zM272.2 39.3c0-23 15.1-39.3 34.9-39.3C326.9 0 342 16.2 342 39.4c0 22.8-15.1 38.5-34.9 38.5-19.8 0-34.9-15.7-34.9-38.6zm9.2 0c0 15.4 10.5 29.9 25.7 29.9 15.3 0 25.7-14.5 25.7-29.9 0-15.5-10.5-30.5-25.7-30.5-15.3-.1-25.7 15-25.7 30.5z"/>
			</g>
			</svg>
		</a>
  	</div>
  	<div id="menu">
    <?php foreach ($texts as $key => $t): ?>	
      <a class="text-toggle" data-target="<?= $t->uid() ?>" href="<?= $t->url() ?>">
      	<?= $t->title()->html() ?>
      </a>
    <?php endforeach ?>
  </div>
  </header>

   <div id="texts">
  	<?php foreach ($texts as $key => $t): ?>
  		<div class="text" data-target="<?= $t->uid() ?>">
  			<?= $t->text()->kt() ?>
  		</div>
  	<?php endforeach ?>
  </div>

	<div id="container">