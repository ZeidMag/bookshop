<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rent $rent
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rent'), ['action' => 'edit', $rent->user_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rent'), ['action' => 'delete', $rent->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $rent->user_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rent'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rents view large-9 medium-8 columns content">
    <h3><?= h($rent->user_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $rent->has('user') ? $this->Html->link($rent->user->id, ['controller' => 'Users', 'action' => 'view', $rent->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Book') ?></th>
            <td><?= $rent->has('book') ? $this->Html->link($rent->book->title, ['controller' => 'Books', 'action' => 'view', $rent->book->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Duration Days') ?></th>
            <td><?= $this->Number->format($rent->duration_days) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($rent->created) ?></td>
        </tr>
    </table>
</div>
