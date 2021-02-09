
<div class = "container">
    <div class="row">

        <div class="col-sm-6">
          <h1> Welcome to</h1>
          <p class="big-text"> BFrender</p>
          <p> With BFrender, you can make friends from nearby or from around the world</p>
          <? if(!$loggedin) {?>
            <a class="btn btn-first" href = "<?= base_url(); ?>index.php?/Login">Login</a>
            <a class="btn btn-first" href = "#">Sign Up</a>
          <? } ?>
        </div>

        <div class="col-sm-6">
        <img src="<?= assetUrl() ?>img/Friends.png" class="img-responsive">
        </div>

    </div>
</div>
