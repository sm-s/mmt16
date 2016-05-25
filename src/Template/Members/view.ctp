<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Member'), ['action' => 'edit', $member->id]) ?> </li>
    </ul>
</nav>
<div class="members view large-8 medium-16 columns content float: left">
    <h3><?= h($member->user->first_name . " ". $member->user->last_name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Project Role') ?></th>
            <td><?= h($member->project_role) ?></td>
        </tr>
        <tr>
            <th><?= __('Starting Date') ?></th>
            <td><?php 
			if ($member->starting_date != NULL)
				echo h($member->starting_date->format('d.m.Y')); 
			?></td>
        </tr>
        <tr>
            <th><?= __('Ending Date') ?></th>
            <td><?php 
			if ($member->ending_date != NULL)
				echo h($member->ending_date->format('d.m.Y')); 
			?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= $member->has('user') ? $this->Html->link($member->user->email, ['controller' => 'Users', 'action' => 'view', $member->user->id]) : '' ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Weeklyhours') ?></h4>
        <?php if (!empty($member->weeklyhours)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Weeklyreport id') ?></th>
                    <th><?= __('Duration') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($member->weeklyhours as $weeklyhours): ?>
                <tr>
                    <td><?= h($weeklyhours->weeklyreport_id) ?></td>
                    <td><?= h($weeklyhours->duration) ?></td>
                    <td class="actions">

                    <?= $this->Html->link(__('View'), ['controller' => 'Weeklyhours', 'action' => 'view', $weeklyhours->id]) ?>
                                       
                    <?php       
                    // links for edit and delete are not visible to devs and managers
                    $admin = $this->request->session()->read('is_admin');
                    $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
                    // $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
                    // if($admin || $supervisor || $manager) {
                    if($admin || $supervisor) {
                    ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Weeklyhours', 'action' => 'edit', $weeklyhours->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Weeklyhours', 'action' => 'delete', $weeklyhours->id], ['confirm' => __('Are you sure you want to delete # {0}?', $weeklyhours->id)]) ?>
                    <?php } ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

                <h4><?= __('Related Workinghours') ?></h4>
        <?php if (!empty($member->workinghours)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Description') ?></th>
                    <th><?= __('Duration') ?></th>
                    <th><?= __('Worktype') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($member->workinghours as $workinghours): 
                	$query = Cake\ORM\TableRegistry::get('Worktypes')
                		->find()
                		->where(['id =' => $workinghours->worktype_id])
                		->toArray();
                	$worktype = $query[0];
                ?>
                <tr>
                    <td><?= h($workinghours->date->format('d.m.Y')) ?></td>
                    <td><?= h($workinghours->description) ?></td>
                    <td><?= $this->Number->format($workinghours->duration) ?></td>
	                <td><?= h($worktype->description) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Workinghours', 'action' => 'view', $workinghours->id]) ?>
                    <?php
                        $admin = $this->request->session()->read('is_admin');
                        $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
                        $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
                        
                        // the week and the year of the workinghour
                        $week= $workinghours->date->format('W');
                        $year= $workinghours->date->format('Y');
                        $firstWeeklyReport = false;
                        // the week and year of the last weekly report
                        $project_id = $this->request->session()->read('selected_project')['id'];
                        $query = Cake\ORM\TableRegistry::get('Weeklyreports')
                            ->find()
                            ->select(['year','week']) 
                            ->where(['project_id =' => $project_id])
                            ->toArray();
                        if ($query != null) {
                            // picking out the week of the last weeklyreport from the results
                            $max = max($query);
                            $maxYear = $max['year'];
                            $maxWeek = $max['week'];
                        }
                        else {
                            $firstWeeklyReport = true;
                        }

                        // edit and delete are only shown if the weekly report is not sent
                        // edit and delete can also be viewed by the developer who owns them

			// IF (you are the owning user or a manager) AND workinghour isn't from previous weeks
			// OR you are an admin or a supervisor
			 
                        if ( ( ($member->user_id == $this->request->session()->read('Auth.User.id') || $manager)                        
                                && ($firstWeeklyReport || (($year >= $maxYear) && ($week > $maxWeek) ) ) ) 
                                                || ($admin || $supervisor) ) { ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'Workinghours', 'action' => 'edit', $workinghours->id]) ?>

                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Workinghours', 'action' => 'delete', $workinghours->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workinghours->id)]) ?> 
                    <?php } ?>
                </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>

