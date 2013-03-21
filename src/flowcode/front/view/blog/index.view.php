
<div id="home-posts">

    <?php foreach ($viewData['pager']->getItems() as $entidad): ?>
        <div class="post">
            <span class="post-date"><?php echo $entidad->getFormatedDate() ?></span>
            <a class="post-title" href="/blog/post/<?php echo $entidad->getPermalink() ?>" ><?php echo $entidad->getTitle() ?></a>
            <div><?php echo $entidad->getIntro() ?></div>
        </div>
    <?php endforeach; ?>


    <div class="pager">
        <? if ($viewData['pager']->getPrevPage() > 1): ?>
        <a href="/blog/index/page/<?php echo $viewData['pager']->getPrevPage() ?>" >Prev</a>
        <span> | </span>
        <? endif;?>
        <a href="/blog/index/page/<?php echo $viewData['pager']->getNextPage() ?>" >Next</a>
    </div>
</div>
