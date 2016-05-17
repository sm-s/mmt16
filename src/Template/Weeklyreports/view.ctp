<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Weeklyreport'), ['action' => 'edit', $weeklyreport->id]) ?> </li>
    </ul>
</nav>
<div class="weeklyreports view large-7 medium-14 columns content float: left">
    <h3><?= h($weeklyreport->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($weeklyreport->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Week') ?></th>
            <td><?= h($weeklyreport->week) ?></tr>
        </tr>
        <tr>
            <th><?= __('Year') ?></th>
            <td><?= h($weeklyreport->year) ?></tr>
        </tr>
        <tr>
            <th><?= __('Reglink') ?></th>
            <td><?= h($weeklyreport->reglink) ?></td>
        </tr>
        <tr>
            <th><?= __('Problems') ?></th>
            <td><?= h($weeklyreport->problems) ?></td>
        </tr>
        <tr>
            <th><?= __('Meetings') ?></th>
            <td><?= h($weeklyreport->meetings) ?></td>
        </tr>
        <tr>
            <th><?= __('Additional') ?></th>
            <td><?= h($weeklyreport->additional) ?></td>
        </tr>
        <tr>
            <th><?= __('Created on') ?></th>
            <td><?= h($weeklyreport->created_on->format('d.m.Y')) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated on') ?></th>
        <td><?php
			if ($weeklyreport->updated_on != NULL)
				echo h($weeklyreport->updated_on->format('d.m.Y'));
		?></td>
    </table>
    <div class="related">
        <h4><?= __('Related Weeklyhours') ?></h4>
            <?php if (!empty($weeklyreport->weeklyhours)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Name / project role') ?></th>
                    <th><?= __('Duration') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($weeklyreport->weeklyhours as $weeklyhours): ?>
                <tr>
                    <td><?= h($weeklyhours->member_name) ?></td>
                    <td><?= h($weeklyhours->duration) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Weeklyhours', 'action' => 'edit', $weeklyhours->id]) ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        <h4><?= __('Related Metrics') ?></h4>
            <?php if (!empty($weeklyreport->metrics)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Metrictype Id') ?></th>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Value') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($weeklyreport->metrics as $metrics): ?>
                <tr>
                    <td><?= h($metrics->metric_description) ?></td>
                    <td><?= h($metrics->date->format('d.m.Y')) ?></td>
                    <td><?= h($metrics->value) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Metrics', 'action' => 'edit', $metrics->id]) ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
		
		<h4><?= __('Comments') ?></h4>
		<?php
			// query for comments
			$query = Cake\ORM\TableRegistry::get('Comments')
						->find()
						->select()
						->where(['weeklyreport_id =' => $weeklyreport['id']])
						->toArray();
			
			if (empty( $query )) {
				echo "<p>No comments yet, be the first one!</p>";
			} else {
				// loop every query row
				for ($i=0; $i<sizeof( $query ); $i++ ) {
					// data into variables
					$userquery = Cake\ORM\TableRegistry::get('Users')
								->find()
								->select(['first_name', 'last_name'])
								->where(['id =' => $query[$i]->user_id])
								->toArray();
					$fullname = $userquery[0]->first_name ." ". $userquery[0]->last_name;
					echo "<div class='messagebox'>";
					echo "<span class='msginfo'>" . $fullname . " left this comment on " . $query[$i]->date_created->format('d.m.Y, H:i') . "</span><br />";
					echo $query[$i]->content;
					echo "</div>";
				}
			}
		?>
		<?php
			// current time
			$datetime = date_create()->format('Y-m-d H:i:s');
			
			echo $this->Form->create('Comments', array('url'=>array('controller'=>'comments', 'action'=>'add')));
		?>
		<fieldset>
			<legend><?= __('New comment') ?></legend>
			<?= $this->Form->textarea('content') ?>
			<?= $this->Form->hidden('user_id', array('type' => 'numeric', 'value' => $this->request->session()->read('Auth.User.id') ) ) ?>
			<?= $this->Form->hidden('weeklyreport_id', array('type' => 'numeric', 'value' => $weeklyreport->id ) ) ?>
			<?php echo $this->Form->button('Submit', ['name' => 'submit', 'value' => 'submit']); ?>
		</fieldset>
		<?= $this->Form->end() ?>
    </div>
</div>