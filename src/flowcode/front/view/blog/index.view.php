<script src="/css/blog.css"></script>
<div id="home-posts">
    <?php foreach ($viewData['pager']->getItems() as $entidad): ?>
        <div class="post well">
            <span class="post-date"><?php echo $entidad->getFormatedDate() ?></span>
            <a class="post-title" href="/blog/post/<?php echo $entidad->getPermalink() ?>" ><h2><?php echo $entidad->getTitle() ?></h2></a>
            <? if ($entidad->getType() == 'd'): ?>
                <div style="display: table;"><?php echo $entidad->getIntro(); ?></div>
            <? else: ?>
                <div style="display: table;"><?php echo $entidad->getBody(); ?></div>
            <? endif; ?>
        </div>
    <?php endforeach; ?>


    <div class="pager">
        <? if ($viewData['pager']->getPrevPage() != $viewData['pager']->getActualPage()): ?>
            <a href="/blog/index/page/<?php echo $viewData['pager']->getPrevPage() ?>" >mas recientes</a>
            <span> | </span>
        <? endif; ?>
        <a href="/blog/index/page/<?php echo $viewData['pager']->getNextPage() ?>" >mas antiguos</a>
    </div>
</div>
