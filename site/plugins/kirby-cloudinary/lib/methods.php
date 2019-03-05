<?php

function cloudinaryFetchID($url) {
	// return str_replace(kirby()->urls()->content(), c::get('kirby.cloudinary.fetch_id'), $url);
	return str_replace(kirby()->urls()->thumbs(), c::get('kirby.cloudinary.fetch_id'), $url);
}

file::$methods['cl_crop'] = function($file, $width, $height, $params = []) {
	$params = array_merge(
		[ "width" => $width, "height" => $height, "crop" => "fill", "gravity" => "auto"],
		$params,
		c::get('kirby.cloudinary.default_params')
	);
	// return cloudinary_url(cloudinaryFetchID($file->url()), $params);
	return cloudinary_url(cloudinaryFetchID($file->width(2000)->url()), $params);
};

file::$methods['cl_thumb'] = function($file, $params = []) {
	$params = array_merge(
		$params,
		c::get('kirby.cloudinary.default_params')
	);
	// return cloudinary_url(cloudinaryFetchID($file->url()), $params);
	return cloudinary_url(cloudinaryFetchID($file->width(2000)->url()), $params);
};