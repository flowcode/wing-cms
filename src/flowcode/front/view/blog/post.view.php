<div class="noticia">
    <span class="fecha"><?php echo $viewData['post']->getDate(); ?></span> 
    <h1><?php echo $viewData['post']->getTitle(); ?></h1>
    <? if ($viewData['post']->getType() == "d"): ?>
        <div class="post-intro"><?php echo $viewData['post']->getIntro(); ?></div>
    <? endif; ?>
    <div class="post-body"><?php echo $viewData['post']->getBody(); ?></div>


</div>
