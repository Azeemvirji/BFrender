<div class = "container">
<h2>Admin</h2>
<strong><?= validation_errors() ?></strong>
<h3>User Table</h3>

<div>
<table>
 <tr>
 <th>Delete</th>
 <th>Freeze</th>
 <th>Username</th>
 <th>Password</th>
 <th>Access level</th>
 <th>Frozen</th>
 </tr>
<? foreach($listing as $row){ ?>
 <tr>
 <td><a href="<?= base_url() ?>index.php?/Admin/delete/<?= $row['compid'] ?>">D</a></td>
 <? if($row['frozen'] == 'Y'){ ?>
   <td><a href="<?= base_url() ?>index.php?/Admin/unfreeze/<?= $row['userId'] ?>">U</a></td>
 <? } else{ ?>
 <td><a href="<?= base_url() ?>index.php?/Admin/freeze/<?= $row['userId'] ?>">F</a></td>
<? } ?>
 <td><?= $row['uname'] ?></td>
 <td><?= $row['password'] ?></td>
 <td><?= $row['accessLevel'] ?></td>
 <td><?= $row['frozen'] ?></td>
 </tr>
<? } ?>
</table>
</div>
<br/>

<?= form_open("Admin/addUser") ?>
<?= form_fieldset("Add new user"); ?>
<?= form_label('Username:', 'username'); ?> <br/>
<?= form_input(array('name' => 'username',
 'id' => 'username',
 'value' => set_value('username',"") ));?> <br>
<?= form_label('Password:', 'password'); ?> <br>
<?= form_input(array('name' => 'password',
 'id' => 'password',
 'value' => set_value('password',"") )); ?> <br>
 <?= form_label('Access Level:', 'accesslevel'); ?> <br>
<?= form_dropdown('accesslevel', $options_dropdown ); ?> <br><br>
<?= form_submit('submit', 'Submit'); ?>
<?= form_reset('reset', 'Clear'); ?>
<?= form_fieldset_close(); ?>
<?= form_close() ?>

<?= $acl ?>
</div>
