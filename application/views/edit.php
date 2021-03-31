<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1></h1></div>
    	<div class="col-sm-2"><a href="/users" class="pull-right"><img class="img-circle img-responsive" ></a></div>
    </div>
    <div class="row">
      <form class="form" action="<?= base_url() ?>index.php?/Edit/Submit/" method="post" id="registrationForm1" enctype="multipart/form-data">
  		<div class="col-sm-3"><!--left col-->
          <img src="<?= assetUrl(); ?>img/users/<?= $user['imageLocation'] ?>" style="width:70%" alt="no picture uploaded"/>
          <label for="pic"><h4>Upload a different photo</h4></label>
          <input type="file" name="pic" id="pic" class="file-upload">

        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                <li><a data-toggle="tab" href="#password">Password</a></li>
              </ul>


          <div class="tab-content">
            <div class="tab-pane <?= $home ?>" id="home">
                <hr>

                      <div class="form-group">

                          <div class="col-xs-6">
                              <label for="first_name"><h4>First name</h4></label>
                              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" value="<?= $user['firstname'] ?>" required maxlength="15" title="enter your first name">
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="last_name"><h4>Last name</h4></label>
                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" value="<?= $user['lastname'] ?>" required maxlength="15" title="enter your last name">
                          </div>
                      </div>

                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="email"><h4>Email</h4></label>
                            <input type="email" class="form-control" style="color:gray;" name="email" id="email" placeholder="you@email.com" value="<?= $user['email'] ?>" title="enter your email.">
                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-xs-6">
                             <label for="gender"><h4>Gender</h4></label><br/>
                              <select id="gender" name="gender" class="col-xs-12">
                                  <option value="#">Select</option>
                                  <option <? if($user['gender'] == "m"){ echo "selected";} ?> value="m">Male</option>
                                  <option <? if($user['gender'] == "f"){ echo "selected";} ?> value="f">Female</option>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="col-xs-12">
                            <label for="bio"><h4>Bio</h4></label><br/>
                            <textarea id="bio" name="bio" rows="4" cols="110"><?= $user['bio'] ?></textarea>
                        </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="province"><h4>Province</h4></label><br/>
                            <select id="province" name="province" class="col-xs-12">
                              <? foreach($provinces as $row){ ?>
                                <option <? if($user['location']['province'] == $row['province']){ echo "selected";} ?> value="<?= $row['province'] ?>"><?= $row['province'] ?></option>
                              <? } ?>
                            </select><br/>
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="city"><h4>City</h4></label><br/>
                            <select id="city" name="city" class="col-xs-12">
                              <? foreach($cities as $row){ ?>
                                <option <? if($user['location']['city'] == $row['city']){ echo "selected";} ?> value="<?= $row['locationId'] ?>"><?= $row['city'] ?></option>
                              <? } ?>
                            </select><br/>
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                               	<button class="btn btn-lg btn-secondary" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                            </div>
                      </div>
              	</form>

              <hr>

             </div><!--/tab-pane-->
             <div class="tab-pane <?= $password ?>" id="password">

               <hr>
                  <form class="form" action="<?= base_url() ?>index.php?/Edit/ResetPassword/" method="post" id="registrationForm2">
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="password"><h4> Current Password</h4></label>
                              <input type="password" class="form-control" style="color:black;" name="currentPassword" id="currentPassword" placeholder="password" title="enter your password.">
                              <?= form_error('currentPassword', '<div class="error">', '</div>'); ?>
                          </div>
                      </div>

                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="password"><h4>New Password</h4></label>
                              <input type="password" class="form-control" style="color:black;" name="newPassword" id="newPassword" placeholder="password" title="enter your new password">
                               <?= form_error('newPassword', '<div class="error">', '</div>'); ?>
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="verify"><h4>Verify Password</h4></label>
                              <input type="password" class="form-control" style="color:black;" name="verify" id="verify" placeholder="Verify Password" title="enter your new password again">
                               <?= form_error('verify', '<div class="error">', '</div>'); ?>
                          </div>
                      </div>
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                               	<button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                            </div>
                      </div>
              	</form>

             </div>
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->

<script>
  $("#province").change(function(){
    var province = $("#province").val();
    $("#city").empty();

    var url = "<?= base_url() ?>index.php?/Edit/GetCities";
    $.ajax({
      type:'POST',
      data:{province: province},
      url:url,
      success: function(result){
        $("#city").append(result);
      }
    });

    //var option = "<option value=\"" + province + "\">" + province + "</option>";
    //$("#city").append(option);
  });
</script>
