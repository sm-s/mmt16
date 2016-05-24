<?php
	$userid = $this->request->session()->read('Auth.User.id');
	$projid = $this->request->session()->read('selected_project')['id'];
	$wrid = $weeklyreport->id;

	// fetch member id of current user in currently chosen project
	$memid = Cake\ORM\TableRegistry::get('Members')->find()
				->select(['id'])
				->where(['user_id =' => $userid, 'project_id =' => $projid])
				->toArray();
	
	if (!empty($memid[0]->id)) {
		$memid = $memid[0]->id;

		// if current weeklyreport's ID is in notifications, remove the row where current member's id is
		// again, I can't be bothered to try getting along with CakePHP, so I'll use MySQL from PHP
		if ( $connection = mysqli_connect("localhost", "user", "pass", "db") ) {
			$delete = "DELETE FROM notifications"
					. " WHERE member_id = $memid"
					. " AND weeklyreport_id = $wrid";

			if (!mysqli_query($connection, $delete)) {
				exit;
			}
			
			// let's also remove data about unread weeklyreports
			if ( $this->request->session()->read('selected_project_role') == 'supervisor' ) {
				$newreps = Cake\ORM\TableRegistry::get('Newreports')->find()
							->select()
							->where(['user_id =' => $userid, 'weeklyreport_id =' => $wrid])
							->toArray();
				if ( sizeof($newreps) > 0 ) {
					$delete = "DELETE FROM newreports"
							. " WHERE user_id = $userid"
							. " AND weeklyreport_id = $wrid";

					if (!mysqli_query($connection, $delete)) {
						exit;
					}
				}
			}
		}
		mysqli_close( $connection );
	}
		
	// if you're an admin or supervisor, we'll force you to change to the project the weeklyreport is from
	$admin = $this->request->session()->read('is_admin');
	$supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
	$manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
	
	if ( $admin || $supervisor ) {
		// fetch the ID of relevant project
		$query = Cake\ORM\TableRegistry::get('Weeklyreports')
					->find()
					->select(['project_id'])
					->where(['id =' => $weeklyreport['id']])
					->toArray();
		$iidee = $query[0]->project_id;
		
		/* Don't hit me. This code is a modified copy of Projects-controller's view-function.
		 * Essentially it is an unnecessary copy, but it cannot be accessed directly because MVC doesn't
		 * allow using controllers inside other controllers. This wouldn't be a problem if the code
		 * was in Models, but previous teams never used Models and it would be extremely difficult to
		 * change everything at this point
		 */
		$project = Cake\ORM\TableRegistry::get('Projects')->get($iidee, [
            'contain' => ['Members', 'Metrics', 'Weeklyreports']
        ]);
        $this->set('project', $project);
        $this->set('_serialize', ['project']);
		
		// if the selected project is a new one
        if($this->request->session()->read('selected_project')['id'] != $project['id']){
            // write the new id 
            $this->request->session()->write('selected_project', $project);
            // remove the all data from the weeklyreport form if any exists
            $this->request->session()->delete('current_weeklyreport');
            $this->request->session()->delete('current_metrics');
            $this->request->session()->delete('current_weeklyhours');
			
        }
	}
?>
<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<?php
			if ($admin || $supervisor || $manager) { ?>
				<li><?= $this->Html->link(__('Edit Weeklyreport'), ['action' => 'edit', $weeklyreport->id]) ?> </li>
		<?php } ?>
    </ul>
</nav>
<div class="weeklyreports view large-8 medium-16 columns content float: left">
    <h3><?= h($weeklyreport->title) ?></h3>
	<h5><?= h($selected_project = $this->request->session()->read('selected_project')['project_name']) ?></h5>
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
            <th><?= __('Meetings') ?></th>
            <td><?= h($weeklyreport->meetings) ?></td>
        </tr>
        <tr>
            <th><?= __('Requirements link') ?></th>
            <td><?= h($weeklyreport->reglink) ?></td>
        </tr>
        <tr>
            <th><?= __('Problems') ?></th>
            <td><?= h($weeklyreport->problems) ?></td>
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
		if ( $weeklyreport->updated_on != NULL ) {
			echo h($weeklyreport->updated_on->format('d.m.Y'));
		} ?></td>
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
                    <td><?php
						// member infos need refreshing before it can be displayed
						if (empty($weeklyhours->member_name)) {
							header("Refresh: 0");
						}
						echo h($weeklyhours->member_name);
					?></td>
                    <td><?= h($weeklyhours->duration) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Weeklyhours', 'action' => 'view', $weeklyhours->id]) ?>
                        <?php
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
                         <?php
                        // only admins and supervisors can edit metrics
                        $admin = $this->request->session()->read('is_admin');
                        $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
                        if($admin || $supervisor) {
                        ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Metrics', 'action' => 'edit', $metrics->id]) ?>
                         <?php } ?>
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
					// display info about user and time of the comment
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
					
					// display edit and delete options to owner and admin/SV
					/* NOTE! edit functionality not implemented in spring 2016. If next teams want to implement it,
					 * they can uncomment the lines below.
					 * Note also that database table for comments already contains an attribute "date_modified"
					 */

					if ( $query[$i]->user_id == $this->request->session()->read('Auth.User.id') || ($admin || $supervisor) ) {
						echo "<br />";
						echo "<span class='msginfo'>";
						// echo $this->Html->link(__('edit'), ['controller' => 'Comments', 'action' => 'edit', $query[$i]->id]);
						// echo " : : ";
						echo $this->Html->link(__('delete'), ['controller' => 'Comments', 'action' => 'delete', $query[$i]->id]);
						echo "</span><br />";
					}
					echo "</div>";
				}
			}
		?>
		<?php
			// current time
			$datetime = date_create()->format('Y-m-d H:i:s');
			
			echo $this->Form->create('Comments', array('url'=>array('controller'=>'Comments', 'action'=>'add')));
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