<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        
        <?php
            $admin = $this->request->session()->read('is_admin');
            $supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;
            if($admin || $supervisor){
        ?>
            <li><?= $this->Html->link(__('Edit Project'), ['action' => 'edit', $project->id]) ?> </li>
        <?php
            }
        ?>        
        <li><?= $this->Html->link(__('Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Metrics'), ['controller' => 'Metrics', 'action' => 'index']) ?> </li>     
    </ul>
</nav>
<div class="projects view large-6 medium-12 columns content float: left">
    <h3><?= h($project->project_name) ?></h3>
	<p>
		<?= h($project->description) ?>
	</p>
    <table class="vertical-table">
		<!--
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($project->description) ?></td>
        </tr>
		-->
        <tr>
            <th><?= __('Created On') ?></th>
            <td><?= h($project->created_on->format('d.m.Y')) ?></tr>
        </tr>
        <tr>
            <th><?= __('Updated On') ?></th>
            <td><?= h($project->updated_on->format('d.m.Y')) ?></tr>
        </tr>
        <tr>
            <th><?= __('Finished Date') ?></th>
            <td><?= h($project->finished_date->format('d.m.Y')) ?></tr>
        </tr>
        <tr>
            <th><?= __('Is Public') ?></th>
            <td><?= $project->is_public ? __('Yes') : __('No'); ?></td>
         </tr>
    </table>
</div>
