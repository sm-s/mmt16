<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'MMT';

//debug prints
//print_r($this->request->session()->read('selected_project_role'));
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->Html->script(array(
        '//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js'
    )) ?>
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div id="area51">
	<div id="statusbar">
	    <!-- This div shows the top-left corner (currently chosen project) -->
		<div id="statusleft">
	    	<?php
	    		// display info only if user is logged in
	    		if ( !empty($this->request->session()->read('Auth.User')) ){
	        		
		    		// fetch the name of current project
					$selected_project = $this->request->session()->read('selected_project');
		            $name = $selected_project['project_name'];
                            
		            // the text part
		            if ($selected_project)
			    		print_r('Current project: '.$name);
			    }
	    	?>
	    </div>
	    
		<!-- this div shows the top-right corner (user's name + role) -->
	    <div id="statusright">
	        <?php
	        	/* Displays user information to every page
	        	   Requirement ID: 23
	        	   - Andy
	        	*/
	        	// checks if logged in
	        	if ( empty($this->request->session()->read('Auth.User')) ){
	        		print_r('Currently not logged in');
	        	} else {
	        		// prints user's full name
	        		print_r( ($this->request->session()->read('Auth.User.first_name')).' '.($this->request->session()->read('Auth.User.last_name')) );
					// checks if user has accessed any projects
					if ($this->request->session()->check('selected_project') ) {
						/* FIX 10.3.2016: now being a non-member is also shown
						   Requirement ID: 23
						   - Andy
						*/
						// display current role. Non-member status is also displayed
						if (($this->request->session()->read('selected_project_role')) != 'notmember' ) {
							print_r(', ' . ($this->request->session()->read('selected_project_role')) );
						} else {
							print_r(', not a member');
						}
					}
				}
	        ?>
	    </div>
	    
	    <!-- this div is only for clearing the two divs above (otherwise the floats wouldn't work) -->
	    <div class="clearer"></div>
    </div> <!-- statusbar -->

	<!-- top navigation bar -->
	<nav id="navtop" role="navigation" data-topbar>
		
		<!-- Left side (displays current location) -->
	    <nav id="navleft" class="large-3">
	        <ul>
	            <li class="title-area">
	                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
	            </li>
	        </ul>
	    </nav>

		<!-- every other button -->
	    <nav id="navright" class="large-9">
	    	<ul>
	    		 <li class="navbutton">
	            	<?= $this->Html->link(__('Home'), ['controller' => 'Projects', 'action' => 'index']) ?>
	            </li>
	    	
		    	<?php 
		        	// If not logged in, show login buttons
		        	if(empty($this->request->session()->read('Auth.User'))) { 
		        ?>
			        <nav class="logins">
						<li class="navbutton">
							<?= $this->Html->link(__('Log in'), ['controller' => 'Users', 'action' => 'login']) ?>
						</li>
						<li class="navbutton">
							<?= $this->Html->link(__('Sign up'), ['controller' => 'Users', 'action' => 'signup']) ?>
						</li>
					</nav>

				<?php 
					// logged in with a project selected
	        		} elseif( $this->request->session()->check('selected_project') ) {
	        	?>
	                <li class="navbutton"><?= $this->Html->link(__('Project'), ['controller' => 'Projects', 'action' => 'view', $this->request->session()->read('selected_project')['id']]) ?></li>
					<?php
						// if not a member, particular links are not shown 
						if ( $this->request->session()->read('selected_project_role') != 'notmember' ) { ?>
			                <li class="navbutton"><?= $this->Html->link(__('Weekly reports'), ['controller' => 'Weeklyreports', 'action' => 'index']) ?></li>
			                <li class="navbutton"><?= $this->Html->link(__('Log time'), ['controller' => 'Workinghours', 'action' => 'index']) ?></li>
					<?php } ?>
					
	                <li class="navbutton"><?= $this->Html->link(__('Charts'), ['controller' => 'Charts', 'action' => 'index']) ?></li>
	                
					<?php } else { ?>

	                <nav class="logins">
	                    <li class="login"><?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'editprofile']) ?></li>
	                    <li class="login"><?= $this->Html->link(__('Log out'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
	                </nav>
	                
	                <?php } ?>
			
	        </ul> <!-- end -->
	    </nav>
	
		<!--
	    <nav class="top-bar expanded">
	    	
		</nav>
		-->	
		<div class="clearer"></div>
	</nav>

    <?= $this->Flash->render() ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
    <footer>
    </footer>
</div>
</body>
</html>
