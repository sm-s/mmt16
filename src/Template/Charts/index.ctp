<?php echo $this->Highcharts->includeExtraScripts(); ?>

<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li> 
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Edit limits') ?></legend>
            <?php
                echo $this->Form->input('weekmin', array('type' => 'number', 'value' => $this->request->session()->read('chart_limits')['weekmin']));
                echo $this->Form->input('weekmax', array('type' => 'number', 'value' => $this->request->session()->read('chart_limits')['weekmax']));
                echo $this->Form->input('yearmin', array('type' => 'number', 'value' => $this->request->session()->read('chart_limits')['yearmin']));
                echo $this->Form->input('yearmax', array('type' => 'number', 'value' => $this->request->session()->read('chart_limits')['yearmax']));
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </ul>
</nav>
<div class="metrics index large-9 medium-8 columns content float: left">

	<!-- 12.3.2016: code cleanup for displaying the charts properly
	     Requirement ID: 7 (Andy)
	-->
    <div class="chart">
        <h4>Phase Chart</h4>
        <div id="phasewrapper">
        	<?php echo $this->Highcharts->render($phaseChart, 'phasechart'); ?>
        </div>
    </div>
    
    <!-- Following two (2) charts are both about requirements, so they share a bigger header -->
    <div class="chart">
        <h4>Requirement Charts</h4>
        <h5>Amounts in numbers</h5>
        <div id="reqwrapper">
        	<?php echo $this->Highcharts->render($reqChart, 'reqchart'); ?>
        </div>
    </div>
    
    <div class="chart">
        <h5>Amounts in percentages</h5>
        <div id="reqpercentwrapper">
        	<?php echo $this->Highcharts->render($reqPercentChart, 'reqpercentchart'); ?>
        </div>
    </div>
  

    <div class="chart">
        <h4>Commit Chart</h4>
        <div id="commitwrapper">
	        <?php echo $this->Highcharts->render($commitChart, 'commitchart'); ?>
	    </div>
	</div>

    <div class="chart">
        <h4>Test Case Chart</h4>
        <div id="testcasewrapper">
	        <?php echo $this->Highcharts->render($testcaseChart, 'testcasechart'); ?>
        </div>
    </div>
    
    <div class="chart">
        <h4>Categorized Working Hour Chart</h4>
        <div id="hourswrapper">
			<?php echo $this->Highcharts->render($hoursChart, 'hourschart'); ?>
		</div>
    </div>

    <div class="chart">
        <h4>Weeklyhour Chart</h4>
        <div id="weeklyhourwrapper">
	        <?php echo $this->Highcharts->render($weeklyhourChart, 'weeklyhourchart'); ?>
		</div>
	</div>
	
</div>
