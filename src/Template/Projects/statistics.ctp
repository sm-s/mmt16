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
                <td>
                <?php 
                $min = $this->request->session()->read('statistics_limits')['weekmin'];
                $max = $this->request->session()->read('statistics_limits')['weekmax'];
                
                // correction for nonsensical values
                if ( $min < 1 )  $min = 1;
                if ( $min > 52 ) $min = 52;
                if ( $max < 1 )  $max = 1;
                if ( $max > 52 ) $max = 52;
                if ( $max < $min ) { 
					$temp = $max; 
                	$max = $min;
                	$min = $temp;
                }

                for ($x = $min; $x <= $max; $x++) {
                    echo "<td>$x</td>";
                } 
                ?></td>
            </tr>
            
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= h($project['project_name']) ?></td>
                    <?php                    
						$admin = $this->request->session()->read('is_admin');
						$supervisor = ( $this->request->session()->read('selected_project_role') == 'supervisor' ) ? 1 : 0;

						// query iterator, resets after finishing one row
						$i = 0;

                    	foreach ($project['reports'] as $report):
                    		// if current project is already finished (= non-empty finished_date), print empty data cells in else
			            	if ( empty( $project['finished_date'] ) ) {
					?>
		                        <td>
		                        <?php
		                        	// non-X's print like normal
		                        	if ( !($report == 'X') ) { ?>
		                        		<?= h($report) ?>
		                        <?php
		                        	}
		                        	// adding link to X's if admin or supervisor
		                        	// BUG FIX 31.3.: links to weeklyreports now actually link to correct reports
		                        	elseif ( $report == 'X' && ($admin || $supervisor) ) { 
		                        		// fetching the ID for current weeklyreport's view-page
		                        		$query = Cake\ORM\TableRegistry::get('Weeklyreports')
											->find()
											->select(['id'])
											->where(['project_id =' => $project['id'], 
											         'week >=' => $min])
											->toArray();
										// transforming returned query item to integer
										$reportId = $query[$i++]->id;

										echo $this->Html->link(__($report.' (view)'), [
										                                              'controller' => 'Weeklyreports',
		                        		                                              'action' => 'view',
		                        		                                              $reportId ]) ?>
		                        <?php
		                        	// displays X without a link to other users
		                        	} else { ?>
		                        		<?= h($report) ?>
		                        <?php
		                        	} ?>
		                        </td>
	                        <?php
                        	} // end if (else = print empty data cells)
                        	else { ?>
                        		<td></td>
                        	<?php } ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    <table border="1" style="width:50%;">
        <h4><?= h('Total weeklyhours') ?></h4>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= h($project['project_name']) ?></td>
                    <td><?= h($project['duration']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    
    <article>
    	<h4><?= h('Additional statistics') ?></h4>
    	<p>Visit the <a href="http://www.uta.fi/sis/tie/pw/statistics.html" target="_blank">Statistics page</a> of Project Work course.</p>
    </article>
</div>
