<div class="container bootstrap snippet">
    <div class="row">
  		<div class="col-sm-10"><h1></h1></div>
    	<div class="col-sm-2"><a href="/users" class="pull-right"><img class="img-circle img-responsive" ></a></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->

        </div><!--/col-3-->
    	<div class="col-sm-9">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                <li><a data-toggle="tab" href="#password">Password</a></li>
                <li><a data-toggle="tab" href="#options">Match Options</a></li>
              </ul>


          <div class="tab-content">
            <div class="tab-pane <?= $home ?>" id="home">
                <hr>
                  <form class="form" action="<?= base_url() ?>index.php?/Edit/Submit/" method="post" id="registrationForm" enctype="multipart/form-data">
                      <div class="form-group">

                          <div class="col-xs-6">
                              <label for="first_name"><h4>First name</h4></label>
                              <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" value="<?= $user['fname'] ?>" required maxlength="15" title="enter your first name">
                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-6">
                            <label for="last_name"><h4>Last name</h4></label>
                              <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" value="<?= $user['lname'] ?>" required maxlength="15" title="enter your last name">
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
                              <label for="pic"><h4>Upload a different photo</h4></label>
                              <input type="file" name="pic" id="pic" class="file-upload">
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
                  <form class="form" action="<?= base_url() ?>index.php?/Edit/ResetPassword/" method="post" id="registrationForm">
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
             <div class="tab-pane" id="options">
               <hr>
                  <form class="form" action="##" method="post" id="optionsForm">
                    <div class="form-group">
                      <div class="col-xs-3">
                        <label for="requirements"><h4> Requirements</h4></label>
                        <div id="requirements-div">
                        </div>
                      </div>
                    </div>

                  </form>
             </div>
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
