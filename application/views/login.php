<div class = "loginbox" id="loginbox">
  <img src="<?= assetUrl() ?>img/avatar.png" class="avatar">
    <h1 class="loginHeader">Login</h1>
    <p><?= $msg ?></p>
<?= form_open("Login/loginuser") ?>
      <label>Username</label>
      <input type="text" name="username" id="username" value="<?= $username ?>" placeholder="Enter Username">
      <label>Password</label>
      <input type="password" name="password" id="password" placeholder="Enter Password">
      <input type="submit" name="loginsubmit" value="Login">
<?= form_close() ?>

</div>
