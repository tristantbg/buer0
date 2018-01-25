<?php 
/**
 * Retrieves the thumbnail from a youtube or vimeo video
 * @param - $src: the url of the "player"
 * @return - string
 * @todo - do some real world testing. 
 * 
**/
function get_video_thumbnail( $src ) {
	$url_pieces = explode('/', $src);
	
	if ( $url_pieces[2] == 'vimeo.com' ) { // If Vimeo
		$id = $url_pieces[3];
		$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
		$thumbnail = $hash[0]['thumbnail_large'];
	} elseif ( $url_pieces[2] == 'www.youtube.com' ) { // If Youtube
		$extract_id = explode('?', $url_pieces[4]);
		$id = $extract_id[0];
		$thumbnail = 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
	}
	return $thumbnail;
}

function get_video_provider( $src ) {
	$url_pieces = explode('/', $src);
	
	if ( $url_pieces[2] == 'vimeo.com' ) { // If Vimeo
		$id = $url_pieces[3];
		$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $id . '.php'));
		$thumbnail = $hash[0]['thumbnail_large'];
		$provider = 'vimeo';
	} elseif ( $url_pieces[2] == 'www.youtube.com' ) { // If Youtube
		$extract_id = explode('?', $url_pieces[4]);
		$id = $extract_id[0];
		$thumbnail = 'http://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
		$provider = 'youtube';
	}
	return array("provider" => $provider, "id" => $id);
}