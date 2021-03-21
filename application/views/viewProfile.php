<div class="container emp-profile">
            <center id="msg"><?= $msg ?></center>
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
                                        <? if($user['firstname'] != "" && $user['lastname'] !=""){ ?>
                                        <?= $user['firstname'] ?> <?= $user['lastname'] ?>
                                      <? }else{ ?>
                                        <p>Please add some info about yourself using the edit profile -></p>
                                      <? } ?>
                                    </h5>
                        </div>
                    </div>

                    <div class="col-md-2">

                    </div>

                    <div class="col-md-8">
                      <hr/>
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Username</label>
                                            </div>
                                            <div class="col-md-10">
                                                <p><?= $user['username'] ?> </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Age</label>
                                            </div>
                                            <div class="col-md-10">
                                                <p><?= $user['age'] ?> </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>Gender</label>
                                            </div>
                                            <div class="col-md-10">
                                                <? if($user['gender'] == 'm'){ ?>
                                                <p>Male</p>
                                              <? }elseif($user['gender'] == 'f'){ ?>
                                                <p>Female</p>
                                              <? }else{ ?>
                                                <p>Not Provided</p>
                                              <? } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-2">
                                            <label>Bio</label>
                                          </div>
                                          <div class="col-md-10">
                                            <p><?= $user['bio'] ?>
                                            </p>
                                          </div>
                                        </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <label>Interests</label>
                        <div class="panel panel-default">
                        <div class="panel-body" id="interestDiv" style="min-height:100px">
                          <?php foreach ($userTags as $row): ?>
                            <p href=""><?= $row ?></p>
                          <?php endforeach; ?>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
            </form>
        </div>
         <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/profile.css">
