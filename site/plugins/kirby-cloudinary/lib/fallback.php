<?php

file::$methods['cl_crop'] = function($file, $width, $height, $params = []) {
	$params = array_merge(
		[ "width" => $width, "height" => $height, "crop" => true, "gravity" => "auto"],
		$params,
		c::get('kirby.cloudinary.default_params')
	);
	return $file->thumb($params)->url();
};

file::$methods['cl_thumb'] = function($file, $params = []) {
	$params = array_merge(
		$params,
		c::get('kirby.cloudinary.default_params')
	);
	return $file->thumb($params)->url();
};