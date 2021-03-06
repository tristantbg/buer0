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
		
		<button class="flickity-prev-next-button touch previous" type="button" aria-label="previous"><svg viewBox="0 0 100 100" ><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path></svg></button>
		<button class="flickity-prev-next-button touch next" type="button" aria-label="next"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180) "></path></svg></button>
    	
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
    							$poster = $image->cl_thumb(array('width' => 1000));
    						} else {
    							$poster = $image->cl_crop(1000, round(1000/$ratio));
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
    							// $placeholder = $image->thumb(array('width' => 50))->dataURI();
    							$src = $image->cl_thumb(array('width' => 1000));
    							for ($i = 1000; $i <= 2000; $i += 500) $srcset .= $image->cl_thumb(array('width' => $i)) . ' ' . $i . 'w,';
    						}
    						else {
    							$src = $image->cl_crop(1000, round(1000/$ratio));
    							for ($i = 1000; $i <= 2000; $i += 500) $srcset .= $image->cl_crop($i, round($i/$ratio)) . ' ' . $i . 'w,';
    						}
    						?>
    						<img class="media lazy <?php e($key == 0, " lazyload lazypreload") ?>" 
    						src="<?= $src ?>" 
    						data-srcset="<?= $srcset ?>" 
    						data-sizes="auto" 
    						data-optimumx="1.5" 
    						alt="<?= $project->title()->html().', © '.$site->title()->html() ?>" height="100%" width="auto" />
    						<noscript>
    							<img src="<?= $image->cl_thumb(array('width' => 1500)) ?>" alt="<?= $project->title()->html().', © '.$site->title()->html() ?>" width="100%" height="auto" />
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

	<?php snippet('pagination', ['posts' => $projects]) ?>

</div>

<?php snippet('footer') ?>