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
    <?= $this->Html->meta(
			'tktlogo.png',
			'webroot/img/tkt.png',
			['type' => 'icon'] ); ?>

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
<!-- onmousemove will make any Flash messages disappear -->
<body onmousemove="$('.message').delay(2500).fadeOut(1000);">
<div id="area51">
	<div class="dropdown">
		<button>
			<?php
				// different label text depending on if logged in or not
				if ( empty($this->request->session()->read('Auth.User')) ) {
					echo '<span id="label">Log in</span>';
				} else {
					echo '<span id="label">Options</span>';
				}
			?>
			<img src="webroot/img/arrow.png" />
		</button>
		<div class="dd-content">
			<img src="webroot/img/icon.png" />
			<div id="userinfo">
				<div class="info">Logged in as</div>
				<?php
				/* Displays user information to every page
				   Requirement ID: 23
				   - Andy
				*/
				// checks if logged in
				if ( empty($this->request->session()->read('Auth.User')) ){
					print_r('Currently not logged in');
				?>
				<ul>
					<li class="login">
						<?= $this->Html->link(__('Log in'), ['controller' => 'Users', 'action' => 'login']) ?>
					</li>
					<li id="space">: :</li>
					<li class="login">
						<?= $this->Html->link(__('Sign up'), ['controller' => 'Users', 'action' => 'signup']) ?>
					</li>
				</ul>
				<?php

				} else {
					// prints user's full name
					print_r( ($this->request->session()->read('Auth.User.first_name')).' '.($this->request->session()->read('Auth.User.last_name')) );
					// checks if user has accessed any projects
					if ($this->request->session()->check('selected_project') ) {

						// fetch the name of current project
						$selected_project = $this->request->session()->read('selected_project');
						$name = $selected_project['project_name'];

						echo "<div class=\"info\">On project</div>";

						// the text part
						if ($selected_project)
							print_r($name);
						else
							print_r('none');
						/* FIX 10.3.2016: now being a non-member is also shown
						   Requirement ID: 23
						   - Andy
						*/
						// display current role. Non-member status is also displayed
						echo "<div class=\"info\">Project role</div>";
						if (($this->request->session()->read('selected_project_role')) != 'notmember' ) {
							print_r(($this->request->session()->read('selected_project_role')) );
						} else {
							print_r('not a member');
						}
					}
				?>
				<ul>
					<li class="login">
						<?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'editprofile']) ?>
					</li>
					<li id="space">: :</li>
					<li class="login">
						<?= $this->Html->link(__('Log out'), ['controller' => 'Users', 'action' => 'logout']) ?>
					</li>
				</ul>
				<?php } ?>
			</div>
		</div>
	</div>
	<!-- this non-breaking space is empty content that makes the page render correctly -->
	&nbsp;
	<div id="topimg">
		<img src="webroot/img/ylapalkki.jpg" />
	</div>

	<!-- Left side (displays current location) -->
	<nav id="left-title">
		<ul>
			<li class="title-area">
				<h1><a href=""><?= $this->fetch('title') ?></a></h1>
			</li>
		</ul>
	</nav>
	
	<!-- top navigation bar with every other button -->
	<nav id="navtop" role="navigation" data-topbar>
	    	<ul>
	    		 <li class="navbutton">
	            	<?= $this->Html->link(__('Home'), ['controller' => 'Projects', 'action' => 'index']) ?>
	            </li>
				
				<!-- OLD BUTTONS (reset if necessary)
		    	<?php 
		        	// If not logged in, show login buttons
		        	if(empty($this->request->session()->read('Auth.User'))) { 
		        ?>
			        <nav>
						<li class="login">
							<?= $this->Html->link(__('Log in'), ['controller' => 'Users', 'action' => 'login']) ?>
						</li>
						<li class="login">
							<?= $this->Html->link(__('Sign up'), ['controller' => 'Users', 'action' => 'signup']) ?>
						</li>
					</nav>

				<?php 
					// display logout
	        		} else {
				?>
					<nav>
	                    <li class="login">
							<?= $this->Html->link(__('Log out'), ['controller' => 'Users', 'action' => 'logout']) ?>
						</li>
						<li class="login">
							<?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'editprofile']) ?>
						</li>
	                </nav>
				-->
				<?php 
					}
					// logged in with a project selected
					if( $this->request->session()->check('selected_project') ) {
	        	?>
	                <li class="navbutton"><?= $this->Html->link(__('Project'), ['controller' => 'Projects', 'action' => 'view', $this->request->session()->read('selected_project')['id']]) ?></li>
					<?php
						// if not a member, particular links are not shown 
						if ( $this->request->session()->read('selected_project_role') != 'notmember' ) { ?>
			                <li class="navbutton"><?= $this->Html->link(__('Reports'), ['controller' => 'Weeklyreports', 'action' => 'index']) ?></li>
			                <li class="navbutton"><?= $this->Html->link(__('Log time'), ['controller' => 'Workinghours', 'action' => 'index']) ?></li>
					<?php } ?>
					
	                <li class="navbutton"><?= $this->Html->link(__('Charts'), ['controller' => 'Charts', 'action' => 'index']) ?></li>
	                
					<?php ?>

	                
	                
	                <?php } ?>
			
	        </ul> <!-- end -->
		<div class="clearer"></div>
	</nav>

    <?= $this->Flash->render() ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>

</div>
<hr/>
<footer>
	<!-- "reverse background" for footer -->
	<div id="area52">
		<div class="footerblock">
			<div id="logoblock">
				<img src="webroot/img/pitkalogo1.png" />
				<div class="footerlogo">METRICS</div>
				<div class="footerlogo">MONITORING</div>
				<div class="footerlogo">TOOL</div>
			</div>
		</div>
		<div class="footerblock">
			<h6>PUBLIC PAGES</h6>
			<ul>
				<li><?= $this->Html->link(__('Home'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Public statistics'), ['controller' => 'Projects', 'action' => 'statistics']) ?> </li>
				<li><?= $this->Html->link(__('FAQ'), ['controller' => 'Projects', 'action' => 'faq']) ?> </li>
			</ul>
			<h6>OTHER RESOURCES</h6>
			<ul>
				<li><a href="http://www.uta.fi/sis/tie/pw/statistics.html" target="_blank">Project Work Statistics</a></li>
			</ul>
		</div>
		<div class="footerblock">
			<h6>CONTACT INFO</h6>
			<ul>
				<li><a href="http://www.uta.fi/sis/yhteystiedot/henkilokunta/pekkamakiaho.html" target="_blank">Supervisor's page</a></li>
			</ul>
			<h6>MISC</h6>
			<ul>
				<li><a href="http://mmttest.sis.uta.fi/" target="_blank">MMT's test page</a></li>
			</ul>
		</div>
	</div>
</footer>
</body>
</html>
