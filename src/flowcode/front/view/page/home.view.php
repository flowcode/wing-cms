
<div id="home-posts">

    <?php foreach ($viewData['pager']->getItems() as $entidad): ?>
        <div class="post">
            <span class="post-date"><?php echo $entidad->getFormatedDate() ?></span>
            <a class="post-title" href="/post/<?php echo $entidad->getPermalink() ?>" ><?php echo $entidad->getTitle() ?></a>
            <div><?php echo $entidad->getIntro() ?></div>
        </div>
    <?php endforeach; ?>


    <div class="pager">
        <a href="/home/index/page/<?php echo $viewData['pager']->getPrevPage() ?>" >Prev</a>
        <span>pagina</span>
        <strong><?php echo $viewData['pageNumber'] ?></strong>
        <span>de <?php echo $viewData['pager']->getPageCount() ?></span>
        <a href="/home/index/page/<?php echo $viewData['pager']->getNextPage() ?>" >Next</a>
    </div>
</div>
