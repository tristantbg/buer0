<?php

file::$methods['isVideo'] = function($file) {
  return $file->videofile()->isNotEmpty() || $file->videostream()->isNotEmpty() || $file->videolink()->isNotEmpty() || $file->videoexternal()->isNotEmpty();
};