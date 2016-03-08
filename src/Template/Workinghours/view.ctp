<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php
        	$admin = $this->request->session()->read('is_admin');
			$supervisor = $this->request->session()->read('is_supervisor');
        	
        	if($admin || $supervisor
			|| $workinghour->member->user_id == $this->request->session()->read('Auth.User.id') ) { ?>
				<li><?= $this->Html->link(__('Edit logged time'), ['action' => 'edit', $workinghour->id]) ?> </li>
		<?php } ?>
    </ul>
</nav>
<div class="workinghours view large-7 medium-8 columns content float: left">
    <h3><?= h("View logged time") ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Member') ?></th>
            <td><?= $workinghour->has('member') ? $this->Html->link($workinghour->member->member_name, ['controller' => 'Members', 'action' => 'view', $workinghour->member->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($workinghour->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($workinghour->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Duration') ?></th>
            <td><?= $this->Number->format($workinghour->duration) ?></td>
        </tr>
        <tr>
            <th><?= __('Worktype') ?></th>
            <td><?= $workinghour->has('worktype') ? $this->Html->link($workinghour->worktype->description, ['controller' => 'Worktypes', 'action' => 'view', $workinghour->worktype->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($workinghour->date->format('Y-m-d')) ?></tr>
        </tr>
    </table>
</div>
