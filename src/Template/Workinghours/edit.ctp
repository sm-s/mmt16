<?php
echo $this->Html->css('jquery-ui.min');
echo $this->Html->script('jquery');
echo $this->Html->script('jquery-ui.min');
?>

<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $workinghour->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $workinghour->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="workinghours form large-8 medium-16 columns content float: left">
    <?= $this->Form->create($workinghour) ?>
    <fieldset>
        <legend><?= __('Edit logged time') ?></legend>
        <?php
            // echo $this->Form->input('member_id', ['options' => $members]);
            // 
            // ISSUE TO FIX
            // format the date that is in the field when the page is opened
            echo $this->Form->input('date', ['type' => 'text', 'readonly' => true]);
            ?> </br>
        <?php  
            echo $this->Form->input('description');
            echo $this->Form->input('duration', array('style' => 'width: 35%;'));
            echo $this->Form->input('worktype_id', ['options' => $worktypes]);    
        /*
         *
        */
            /*
             * Req 21:
             * The weeks when the weekly reports were sent or if there are no reports,
             * the date when the project was created is fetched from the db.
             */ 
           
            $project_id = $this->request->session()->read('selected_project')['id'];
            $query = Cake\ORM\TableRegistry::get('Weeklyreports')
                ->find()
           	->select(['year','week']) 
            	->where(['project_id =' => $project_id])
                ->toArray(); 

            if ($query != null) {
                // picking out the week of the last weekly report from the results
                $max = max($query);

                $maxYear = $max['year'];
                $maxWeek = $max['week'];
                
                // $mDate is the first day of the new weeklyreport week (monday) 
                $monday = new DateTime();
                $monday->setISODate($maxYear,$maxWeek,8);
                $mDate1 = $monday->format('d M Y');
                $mDate = date('d M Y', strtotime($mDate1));
            }
            // There are no weekly reports.
            else {
                $project_id = $this->request->session()->read('selected_project')['id'];
                $query2 = Cake\ORM\TableRegistry::get('Projects')
                    ->find()
                    ->select(['created_on']) 
                    ->where(['id =' => $project_id])
                    ->toArray(); 
                
                foreach($query2 as $result) {
                    $temp = date_parse($result);
                    $year = $temp['year'];
                    $month = $temp['month'];
                    $day = $temp['day'];
                    
                    // $mDate is the date project was created on              
                    $mDate = date("d M Y", mktime(0,0,0, $month, $day, $year));
                }
            }
			echo $this->Form->button(__('Submit'));
        ?>    
 
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<script> 
    /*
     * Req 21
     * minDate is either the first day of the weeklyreport week or 
     * the date project was created
     * maxDate is the current day
     */
    $( "#date" ).datepicker({
        dateFormat: "MM d, yy",
        minDate: new Date('<?php echo $mDate; ?>'),
        maxDate: '0', 
        firstDay: 1,
        showWeek: true,
        showOn: "both",
        buttonImage: "../../webroot/img/glyphicons-46-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date"       
    });
  </script>