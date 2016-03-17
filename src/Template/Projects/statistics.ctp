<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Edit limits') ?></legend>
                <?php
                    echo $this->Form->input('weekmin', array('type' => 'number', 'value' => $this->request->session()->read('statistics_limits')['weekmin']));
                    echo $this->Form->input('weekmax', array('type' => 'number', 'value' => $this->request->session()->read('statistics_limits')['weekmax']));
                    echo $this->Form->input('year', array('type' => 'number', 'value' => $this->request->session()->read('statistics_limits')['year']));
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
    </ul>
</nav>
<div class="projects view large-10 medium-8 columns content float: left">
    <h3><?= h('Public statistics') ?></h3>
    <table border="1">
        <h4><?= h('Weeklyreports') ?></h4>
        <tbody>
            <tr>
                <td></td>
                <?php 
                $min = $this->request->session()->read('statistics_limits')['weekmin'];
                $max = $this->request->session()->read('statistics_limits')['weekmax'];
                for ($x = $min; $x <= $max; $x++) {
                    echo "<td>$x</td>";
                } 
                ?>
            </tr>
            
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= h($project['project_name']) ?></td>
                    <?php
                    	/* Wrapping cells' data in link tags if weeklyreports are available
                    	 * For supervisors/admins only
                    	 * Requirement ID: 4
                    	 */
                    	$admin = $this->request->session()->read('is_admin');
						$supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;

                    	foreach ($project['reports'] as $report):
                    ?>
                        <td><?php
                        	// adding link tags around X's if admin or supervisor
                        	if ( $report == 'X' && ($admin || $supervisor) ) { ?>
                        		<a href="www.google.com">
                        	<?php
                        		} ?>
                        	<!-- this is the data inside the cells -->
                        	<?= h($report) ?>
                        <?php
                        	// closing link tags
                        	if ( $report == 'X' && ($admin || $supervisor) ) {
                        ?>
                        		</a>
                        	<?php } ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    <table border="1" style="width:50%;">
        <h4><?= h('Total Weeklyhours') ?></h4>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= h($project['project_name']) ?></td>
                    <td><?= h($project['duration']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
</div>
