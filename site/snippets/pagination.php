<?php if ($posts->count() == 0): ?>
  <div class="no-content"><span>No posts yet</span></div>
<?php endif ?>

<?php if($posts->pagination() && $posts->pagination()->hasPages()): ?>

<?php if ($posts->pagination()->hasPrevPage() || $posts->pagination()->hasNextPage()): ?>

  <nav id="pagination">

    <?php if($posts->pagination()->hasNextPage()): ?>
    <a class="next" href="<?php echo $posts->pagination()->nextPageURL() ?>"><h2>Next</h2></a>
    <?php endif ?>

    <?php if($posts->pagination()->hasPrevPage()): ?>
    <a class="prev" href="<?php echo $posts->pagination()->prevPageURL() ?>"><h2>Previous</h2></a>
    <?php endif ?>

  </nav>

<?php endif ?>

<!-- <div class="ajax-loading"><div class="button infinite-scroll-request">Loading</div></div> -->
<?php endif ?>