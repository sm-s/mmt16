<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php
            $admin = $this->request->session()->read('is_admin');
            $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;

            // FIX: managers can also add new members
            $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
            
            if($admin || $supervisor || $manager ) {
        ?>
			<li><?= $this->Html->link(__('New Member'), ['action' => 'add']) ?></li>
        <?php }
        ?>
    </ul>
</nav>
<div class="members index large-9 medium-18 columns content float: left">
    <h3><?= __('Members') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('project_role') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $member): ?>
            <tr>
                <td><?= $member->has('user') ? $this->Html->link($member->user->first_name . " ". $member->user->last_name, ['controller' => 'Users', 'action' => 'view', $member->user->id]) : '' ?></td>
                <td><?= h($member->project_role) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $member->id]) ?>
                    <?php
			            $admin = $this->request->session()->read('is_admin');
			            $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
			            if($admin || $supervisor){
			        ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $member->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $member->id], ['confirm' => __('Are you sure you want to delete # {0}?', $member->id)]) ?>
                    <?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
