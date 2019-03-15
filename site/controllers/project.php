<?php

return function ($site, $pages, $page) {
  $title = $page->title()->html();
  $texts = $pages->visible()->filterBy('intendedTemplate', 'default');
  $projects = new Collection();
  $projects->append('0', $page);

  return array(
  'title' => $title,
  'texts' => $texts,
  'projects' => $projects
  );
}

?>
