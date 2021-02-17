
<ul class="nav navbar-nav navbar-right">
 <li><a href="<?= base_url(); ?>index.php?/Home"><span class="glyphicon glyphicon-home"> Home</span></a></li>
 <li><a href="<?= base_url(); ?>index.php?/Profile"><span class="glyphicon glyphicon-user"> Profile</span></a></li>
 <? if($_SESSION['accesslevel'] == 'admin'){ ?>
<li id="navigation"><a href="<?= base_url(); ?>index.php?/Admin">Admin</a></li>
  <? } ?>
 <? if ($loggedin) { ?>
 <li><a href="<?= base_url(); ?>index.php?/Login/logout">Logout</a></li>
 <? } else { ?>
 <li><a href="<?= base_url(); ?>index.php?/Login"><span class="glyphicon glyphicon-log-in"> Login</span></a></li>
 <? } ?>
</ul>
</div>
</nav>
