<div class="container emp-profile">
            <form method="post" action="<?= base_url(); ?>index.php?/Edit">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="<?= assetUrl(); ?>img/users/<?= $user['imageLocation'] ?>" alt="no picture uploaded"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5 style="font-weight:600;color:#0062cc;">
                                        <? if($user['fname'] != "" && $user['lname'] !=""){ ?>
                                        <?= $user['fname'] ?> <?= $user['lname'] ?>
                                      <? }else{ ?>
                                        <p>Please add some info about yourself using the edit profile -></p>
                                      <? } ?>
                                    </h5>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="friends-tab" data-toggle="tab" href="#matches" role="tab" aria-controls="matches" aria-selected="false">Matches</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Username</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?= $user['uname'] ?> </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?= $user['email'] ?> </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?= $user['age'] ?> </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Gender</label>
                                            </div>
                                            <div class="col-md-6">
                                                <? if($user['gender'] == 'm'){ ?>
                                                <p>Male</p>
                                              <? }elseif($user['gender'] == 'f'){ ?>
                                                <p>Female</p>
                                              <? }else{ ?>
                                                <p>Not Provided</p>
                                              <? } ?>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane" id="matches" role="tabpanel" aria-labelledby="matches-tab">
                                        <? foreach($friends as $friend){ ?>
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <label><?= $friend['uname'] ?></label>
                                              </div>
                                              <div class="col-md-6">
                                                  <p><?= $friend['lname'] ?></p>
                                              </div>
                                          </div>
                                        <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
