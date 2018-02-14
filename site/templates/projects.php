<?php snippet('header') ?>

<div id="page-content" class="projects-list">

	<?php foreach ($projects as $key => $project): ?>

	<?php
	$medias = $project->medias()->toStructure();
	if ($medias->first() && $first = $medias->first()->toFile()){
		$ratio = $first->ratio();
	}
	// $height = "height: ". (100/$ratio) ."vw;";
	$style = "";
	if ($project->padding()->isNotEmpty()) $style .= "padding: 0 ".$project->padding()."%";
	?>

    <div class="slider" data-ratio="<?= $ratio ?>" style="<?= $style ?>">
    	<div class="post">
    	
    		<?php foreach ($medias as $key => $image): ?>
    	
    				<?php if($image = $image->toFile()): ?>
    				<?php $isVideo = $image->isVideo() ?>
    			
    				<div class="scene" 
    				data-id="<?= $key+1 ?>" 
    				<?php if($image->caption()->isNotEmpty()): ?>
    				data-caption="<?= $image->caption()->kt()->escape() ?>" 
    				<?php endif ?>
    				data-media="<?= e($isVideo, 'video', 'image') ?>"
    				>
    				
    				<?php if($isVideo): ?>
    					<div class="content video <?= $image->contentSize() ?>">
    						<?php 
    						if ($key == 0) {
    							$poster = thumb($image, array('width' => 1500))->url();
    						} else {
    							$poster = thumb($image, array('width' => 1500, 'height' => round(1500/$ratio), 'crop' => true))->url();
    						}
    	
    						if ($image->videostream()->isNotEmpty() || $image->videoexternal()->isNotEmpty() || $image->videofile()->isNotEmpty()) {
    							$video  = '<video preload="none" class="media js-player"';
    							$video .= ' poster="'.$poster.'"';
    							if ($image->videostream()->isNotEmpty()) {
    								$video .= ' data-stream="'.$image->videostream().'"';
    							}
    							$video .= ' width="100%" height="100%" controls="false" loop>';
    							if ($image->videoexternal()->isNotEmpty()) {
    								$video .= '<source src=' . $image->videoexternal() . ' type="video/mp4">';
    							} else if ($file = $image->videofile()->toFile()){
    								$video .= '<source src=' . $file->url() . ' type="video/mp4">';
    								if ($file = $image->videofilewebm()->toFile()){
    									$video .= '<source src=' . $file->url() . ' type="video/webm">';
    								}
    							}
    							$video .= '</video>';
    							echo $video;
    						}
    						else {
    							$url = $image->videolink();
    							if ($image->vendor() == "youtube") {
    								echo '<div class="media js-player" data-type="youtube" data-video-id="' . $url  . '"></div>';
    							} else {
    								echo '<div class="media js-player" data-type="vimeo" data-video-id="' . $url  . '"></div>';
    							}
    						}
    						?>
    					</div>
    				<?php else: ?>
    					<div class="content image <?= $image->contentSize() ?>">
    						<?php 
    						$srcset = '';
    						if ($key == 0) {
    							$src = $image->width(1000)->url();
    							for ($i = 1000; $i <= 3000; $i += 500) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
    						}
    						else {
    							$src = thumb($image, array('width' => 1000, 'height' => round(1000/$ratio), 'crop' => true))->url();
    							for ($i = 1000; $i <= 3000; $i += 500) $srcset .= thumb($image, array('width' => $i, 'height' => round($i/$ratio), 'crop' => true))->url() . ' ' . $i . 'w,';
    						}
    						?>
    						<img class="media lazy <?php e($key == 0, " lazyload lazypreload") ?>" 
    						data-src="<?= $src ?>" 
    						data-srcset="<?= $srcset ?>" 
    						data-sizes="auto" 
    						data-optimumx="1.5" 
    						alt="<?= $title.' - © '.$site->title()->html() ?>" height="100%" width="auto" />
    						<noscript>
    							<img src="<?= thumb($image, array('width' => 1500))->url() ?>" alt="<?= $title.' - © '.$site->title()->html() ?>" width="100%" height="auto" />
    						</noscript>
    					</div>
    				<?php endif ?>
    			
    				</div>
    			
    				<?php endif ?>
    			
    		<?php endforeach ?>
    		
    	</div>
    	
    	<div class="captions">
    		<?php if ($project->text()->isNotEmpty()): ?>
    			<div class="caption"><?= $project->text()->kt() ?></div>
    		<?php endif ?>
    		<div class="additional-caption"></div>
    	</div>
    </div>

	<?php endforeach ?>

</div>

<?php snippet('footer') ?>