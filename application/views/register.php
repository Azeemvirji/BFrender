<div class = "loginbox" id="registerbox">
  <img src="<?= assetUrl() ?>img/avatar.png" class="avatar">
        <h1 class="loginHeader">Register</h1>
        <p><?= $msg ?></p>
<?= form_open("Register/registeruser") ?>
          <label>Email</label>
          <input type="email" name="email" required placeholder="Enter Email ID" value="<?= $email ?>">

          <label>Username</label>
          <input type="text" name="username" id="username" required minlength="6" placeholder="Pick a Username" value="<?= $username ?>">

          <label>Date Of Birth</label>
          <input type="date" name="dob" id="dob" required placeholder="Please use format yyyy-mm-dd" />

          <label>Password</label>
          <input type="password" name="password" required minlength="8" placeholder="Enter Password">

          <label>Confirm Password</label>
          <input type="password" name="confirm" required minlength="8" placeholder="Confirm Password">



          <input type="submit" name="submit" value="Register">


<div>
  <?= form_error('email', '<div class="alert alert-danger">', '</div>'); ?>
  <?= form_error('username', '<div class="alert alert-danger">', '</div>'); ?>
  <?= form_error('dob', '<div class="alert alert-danger">', '</div>'); ?>
  <?= form_error('password', '<div class="alert alert-danger">', '</div>'); ?>
  <?= form_error('confirm', '<div class="alert alert-danger">', '</div>'); ?>
</div>
<?= form_close() ?>
    </div>
