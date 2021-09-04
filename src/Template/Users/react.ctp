<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
</nav>
<?php $this->Html->css($css, [
    'block' => true
]); ?>

<div class="articles index large-9 medium-8 columns content">
    <!-- this is where the react page mounts -->
    <div id="root" baseUrl="<?= $this->Url->build('/users'); ?>"></div>
    <?= $this->Html->script($js); ?>
</div>
