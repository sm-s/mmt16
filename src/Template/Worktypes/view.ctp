<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Worktype'), ['action' => 'edit', $worktype->id]) ?> </li>
    </ul>
</nav>
<div class="worktypes view large-9 medium-18 columns content float: left ">
    <h3><?= h($worktype->description) ?></h3>
	<!--
    <table class="vertical-table">
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($worktype->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($worktype->id) ?></td>
        </tr>
    </table>
	-->
    <div class="related">
        <h4><?= __('Related Workinghours') ?></h4>
        <?php if (!empty($worktype->workinghours)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Member Id') ?></th>
				<!--
                <th><?= __('Date') ?></th>
				-->
                <th colspan="3"><?= __('Description') ?></th>
                <th><?= __('Duration') ?></th>
				<!--
                <th class="actions"><?= __('Actions') ?></th>
				-->
            </tr>
            <?php foreach ($worktype->workinghours as $workinghours): ?>
            <tr>
                <td><?= h($workinghours->id) ?></td>
                <td><?= h($workinghours->member_id) ?></td>
				<!--
                <td><?= h($workinghours->date->format('d.m.Y')) ?></td>
				-->
                <td colspan="3"><?= h($workinghours->description) ?></td>
                <td><?= h($workinghours->duration) ?></td>
				<!-- These do not function properly, it's safe to hide them
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Workinghours', 'action' => 'view', $workinghours->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Workinghours', 'action' => 'edit', $workinghours->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Workinghours', 'action' => 'delete', $workinghours->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workinghours->id)]) ?>

                </td>
				-->
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
</div>
