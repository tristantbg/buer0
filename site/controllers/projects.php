<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$texts = $pages->visible()->filterBy('intendedTemplate', 'default');
	$projects = $page->children()->visible();

	return array(
	'title' => $title,
	'texts' => $texts,
	'projects' => $projects
	);
}

?>

