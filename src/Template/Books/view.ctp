<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Book $book
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Book'), ['action' => 'edit', $book->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Book'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Authors'), ['controller' => 'Authors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Author'), ['controller' => 'Authors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rents'), ['controller' => 'Rents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rent'), ['controller' => 'Rents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="books view large-9 medium-8 columns content">
    <h3><?= h($book->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($book->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author') ?></th>
            <td><?= $book->has('author') ? $this->Html->link($book->author->name, ['controller' => 'Authors', 'action' => 'view', $book->author->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($book->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pages') ?></th>
            <td><?= $this->Number->format($book->pages) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Publish Year') ?></th>
            <td><?= $this->Number->format($book->publish_year) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Rents') ?></h4>
        <?php if (!empty($book->rents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Book Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Duration Days') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($book->rents as $rents): ?>
            <tr>
                <td><?= h($rents->user_id) ?></td>
                <td><?= h($rents->book_id) ?></td>
                <td><?= h($rents->created) ?></td>
                <td><?= h($rents->duration_days) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Rents', 'action' => 'view', $rents->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Rents', 'action' => 'edit', $rents->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Rents', 'action' => 'delete', $rents->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $rents->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
