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
 <td><a href="<?= base_url() ?>index.php?/Admin/freeze/<?= $row['compid'] ?>">F</a></td>
 <td><?= $row['username'] ?></td>
 <td><?= $row['password'] ?></td>
 <td><?= $row['accesslevel'] ?></td>
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
<?= form_input(array('name' => 'accesslevel',
 'id' => 'accesslevel',
 'value' => set_value('accesslevel',"") )); ?> <br>
<?= form_submit('submit', 'Submit'); ?>
<?= form_fieldset_close(); ?>
<?= form_close() ?>

<?= $acl ?>