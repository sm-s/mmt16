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
                ['action' => 'delete', $member->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $member->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="members form large-8 medium-16 columns content float: left">
    <?= $this->Form->create($member) ?>
    <fieldset>
        <legend><?= __('Edit Member') ?></legend>
        <?php
            
            // echo $this->Form->input('user_id', ['options' => $users]);
            
            echo $this->Form->input('project_role', 
                ['options' => array('developer' => 'developer', 'manager' => 'manager', 'supervisor' => 'supervisor')]);
            
            // echo $this->Form->input('starting_date', ['empty' => true, 'default' => '']);
            // echo $this->Form->input('ending_date', ['empty' => true, 'default' => '']);
            
            // Using jQuery UI datepicker
            echo $this->Form->input('starting_date', ['type' => 'text', 'readonly' => true, 'id' => 'datepicker1']);            
            ?> </br>
            <?php            
            echo $this->Form->input('ending_date', ['type' => 'text', 'readonly' => true, 'id' => 'datepicker2']);
           
            // Fetching from the db the date when the project was created          
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
    // minDate is the date the project was created
    // maxDate is the current day

       $( "#datepicker1" ).datepicker({
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
        $( "#datepicker2" ).datepicker({
        dateFormat: "MM d, yy",
        minDate: new Date('<?php echo $mDate; ?>'),
        firstDay: 1,
        showWeek: true,
        showOn: "both",
        buttonImage: "../../webroot/img/glyphicons-46-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date"       
    });
</script>
