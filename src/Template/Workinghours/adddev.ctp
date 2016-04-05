<?php
echo $this->Html->css('jquery-ui.min');
echo $this->Html->script('jquery');
echo $this->Html->script('jquery-ui.min');
?>

<nav class="large-2 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="workinghours form large-4 medium-8 columns content float: left">
    <?= $this->Form->create($workinghour) ?>
    <fieldset>
        <legend><?= __('Log time for another member') ?></legend>
        <?php
            echo $this->Form->input('member_id', ['options' => $members]);
            
            /*
             * Req #21
             * 
             * Using jQuery UI datepicker
             * Added css and js files for datepicker to webroot
             * Changed settings for validation in WorkingHoursTable.php
             * Readonly turns the text field grey and doesn't allow other input than 
             * the date selected from the calendar
             * Added input[readonly] to cake.css
             */     
            echo $this->Form->input('date', ['type' => 'text', 'readonly' => true]);
            ?> </br>
        <?php  
            echo $this->Form->input('description');
            echo $this->Form->input('duration');
            echo $this->Form->input('worktype_id', ['options' => $worktypes]);
        
           /*
             * Req #21
             * 
             * Fetching from the db the date when the project was created
             */ 
           
            $project_id = $this->request->session()->read('selected_project')['id'];
            $query = Cake\ORM\TableRegistry::get('Projects')
                ->find()
                ->select(['created_on']) 
                ->where(['id =' => $project_id])
                ->toArray(); 
                
            foreach($query as $result) {
                $temp = date_parse($result);
                $year = $temp['year'];
                $month = $temp['month'];
                $day = $temp['day'];   
                $mDate = date("d M Y", mktime(0,0,0, $month, $day, $year));
            } 
        ?>    
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<script> 
    /*
     * Req #21
     * 
     * minDate is the date the project was created
     * maxDate is the current day
     * both the input field and the icon can be clicked
     */
    $( "#date" ).datepicker({
        minDate: new Date('<?php echo $mDate; ?>'),
        maxDate: '0', 
        firstDay: 1,
        showWeek: true,
        showOn: "both",
        buttonImage: "/Metrix/img/glyphicons-46-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date"       
    });
</script>
