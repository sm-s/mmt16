<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php
            use Cake\I18n\Time;
            
            $admin = $this->request->session()->read('is_admin');
            $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
            $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
            if ( !($supervisor) ) {
            ?>
            <li><?= $this->Html->link(__('Log time'), ['action' => 'add']) ?></li>
            <?php 
            } 
            if($admin || $supervisor || $manager) {
            ?>
            <li><?= $this->Html->link(__('Log time for another member'), ['action' => 'adddev']) ?></li>
        <?php } ?>
    </ul>
</nav>
<div class="workinghours index large-9 medium-18 columns content float: left">
    <h3><?= __('Logged time') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('member_id') ?></th>
                <th><?= $this->Paginator->sort('duration') ?></th>
                <th><?= $this->Paginator->sort('date') ?></th>    
                <th><?= $this->Paginator->sort('worktype_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($workinghours as $workinghour): ?>
            <tr>
                <?php
                    foreach($memberlist as $member){
                        if($workinghour->member->id == $member['id']){
                           $workinghour->member['member_name'] = $member['member_name'];
                        }
                    }
                ?>
                <td><?= $workinghour->has('member') ? $this->Html->link($workinghour->member->member_name, ['controller' => 'Members', 'action' => 'view', $workinghour->member->id]) : '' ?></td>
                <td><?= $this->Number->format($workinghour->duration) ?></td>
                <td><?= h($workinghour->date->format('d.m.Y')) ?></td>
                <td><?= $workinghour->has('worktype') ? $this->Html->link($workinghour->worktype->description, ['controller' => 'Worktypes', 'action' => 'view', $workinghour->worktype->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $workinghour->id]) ?>
                    <?php
                    $admin = $this->request->session()->read('is_admin');
                    $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
                    $manager = ( $this->request->session()->read('selected_project_role') == 'manager' ) ? 1 : 0;
                    // the week and the year of the workinghour
                    $week= $workinghour->date->format('W');
                    $year= $workinghour->date->format('Y');
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
					
                        /* BUG FIX: admins couldn't see times that were old
                	 * Now it looks kinda complicated, but it means this:
			 * IF (you are the owning user or a manager) AND workinghour isn't from previous weeks
			 * OR you are an admin or a supervisor
			 */
                    if ( ( ($workinghour->member->user_id == $this->request->session()->read('Auth.User.id') || $manager)
                            && ($firstWeeklyReport || (($year >= $maxYear) && ($week > $maxWeek)))) 
					     || ($admin || $supervisor) ) { ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $workinghour->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $workinghour->id], ['confirm' => __('Are you sure you want to delete # {0}?', $workinghour->id)]) ?> 
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
