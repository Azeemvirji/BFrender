
<ul class="nav navbar-nav navbar-right">

 <? if($_SESSION['accesslevel'] == 'admin'){ ?>
<li id="navigation"><a href="<?= base_url(); ?>index.php?/Admin"><span class="glyphicon glyphicon-cog"> Admin</span></a></li>
  <? } ?>
 <? if ($loggedin) { ?>
   <li ><a href="<?= base_url(); ?>index.php?/Edit"><span class="glyphicon glyphicon-cog"> Settings</span></a></li>
   <li><a href="<?= base_url(); ?>index.php?/Friends"><span class="glyphicon glyphicon-globe"> Friends</span></a></li>
   
   <li><a href="<?= base_url(); ?>index.php?/Matches"><span class="glyphicon glyphicon-plus"> Matches</span></a></li>
 <li><a href="<?= base_url(); ?>index.php?/Profile"><span class="glyphicon glyphicon-user"> Profile</span></a></li>
 <li><a href="<?= base_url(); ?>index.php?/Login/logout"><span class="glyphicon glyphicon-log-out"> Logout</span></a></li>
 <? } else { ?>
 <li><a href="<?= base_url(); ?>index.php?/Home"><span class="glyphicon glyphicon-home"> Home</span></a></li>
 <li><a href="<?= base_url(); ?>index.php?/Login"><span class="glyphicon glyphicon-log-in"> Login</span></a></li>
 <? } ?>
</ul>
</div>
</nav>
</header>
