<!-- The third page in the weeklyreport form.
     A input is added for all developers managers.
     Pre calculated workinghours are added automatically and if the user
     goes backwards on the page the current values are saved.
-->
<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="weeklyhours form large-6 medium-12 columns content float: left">
    <?= $this->Form->create($weeklyhours) ?>
    <fieldset>
        <legend><?= __('Add Weeklyhours, Page 3/3') ?></legend>
        <?php
            $current_weeklyhours = $this->request->session()->read('current_weeklyhours');
            // if its not the first time the user visits this page in the same report
            // then previous values are loaded
            // else the pre calculated hours are added
            if(!is_null($current_weeklyhours)){
                echo "<tr>";
                for($count = 0; $count < count($memberlist); $count++){
                    print_r($memberlist[$count]['member_name']);
                    echo "<td>";
                    echo $this->Form->input("{$count}.duration", array('value' => $current_weeklyhours[$count]['duration']));
                    echo "</td>";
                }
                echo "</tr>";
            }
            else{
                echo "<tr>";
                for($count = 0; $count < count($memberlist); $count++){
                    print_r($memberlist[$count]['member_name']);
                    echo "<td>";
                    echo $this->Form->input("{$count}.duration", array('value' => $hourlist[$count]));
                    echo "</td>";
                }
                echo "</tr>";
            }
        ?>
        <div style="margin-top: 2em">
        	<?php
        		/* REQ ID 27: navigating back now doesn't require fields  to be filled
        		* Also positions of buttons slightly altered
            	* Navigating back to previous page changed to regular link to avoid confusion
	        	*/
        		echo $this->Form->button('Submit', ['name' => 'submit', 'value' => 'submit', 'style' => 'float: right;']);
        	?>
        	<!-- for positioning back-link -->
		    <div style="padding-top: 0.7em;">
			    <?php
			    	// echo $this->Form->button('Back', ['name' => 'submit', 'value' => 'previous']);
			        echo $this->Html->link('Previous Page', ['controller' => 'Metrics', 'action' => 'addmultiple']); 
		    	?>
	    	</div>
        </div>
    </fieldset>
    <?php 
        
    ?>
    <?= $this->Form->end() ?>
</div>
