<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php
            $admin = $this->request->session()->read('is_admin');
            $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;

            // FIX: managers can also add new weeklyreports
            $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;

            if($admin || $supervisor || $manager) {
        ?>
        	<li><?= $this->Html->link(__('New Weeklyreport'), ['action' => 'add']) ?></li>
        <?php } ?>
        <li><?= $this->Html->link(__('Weeklyhours'), ['controller' => 'Weeklyhours', 'action' => 'index']) ?> </li> 
    </ul>
</nav>
<div class="weeklyreports index large-9 medium-18 columns content float: left">
    <h3><?= __('Weeklyreports') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th colspan="2"><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('week') ?></th>
                <th><?= $this->Paginator->sort('year') ?></th>
				<!--
                <th><?= $this->Paginator->sort('created_on') ?></th>
                <th><?= $this->Paginator->sort('updated_on') ?></th>
				-->
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($weeklyreports as $weeklyreport): ?>
            <tr>
                <td colspan="2"><?= h($weeklyreport->title) ?></td>
                <td><?= h($weeklyreport->week) ?></td>
                <td><?= h($weeklyreport->year) ?></td>
				<!--
                <td><?= h($weeklyreport->created_on->format('d.m.Y')) ?></td>
                <td><?php
					if ($weeklyreport->updated_on != NULL)
						echo h($weeklyreport->updated_on->format('d.m.Y'));
				?></td>
				-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $weeklyreport->id]) ?>
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
