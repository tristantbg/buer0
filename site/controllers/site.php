<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$texts = $pages->visible()->filterBy('intendedTemplate', 'default');

	return array(
	'title' => $title,
	'texts' => $texts,
	);
}

?>
