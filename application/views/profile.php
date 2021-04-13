<div class="container emp-profile">
            <center id="msg"><?= $msg ?></center>
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
                        <a href="<?= base_url(); ?>index.php?/Edit""><input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/></a>
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
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-10">
                                                <p><?= $user['email'] ?> </p>
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
                                        <div class="row">
                                          <div class="col-md-2">
                                            <label>Location</label>
                                          </div>
                                          <div class="col-md-10">
                                            <? if($user['location'] == ""){ ?>
                                              <p>Not Provided</p>
                                            <? }else{ ?>
                                            <p><?= $user['location']['city'] ?>, <?= $user['location']['province'] ?></p>
                                          <? } ?>
                                          </div>
                                        </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <label>Interests</label><a data-toggle="collapse" href="#IntrestsCollapse" aria-expanded="false" aria-controls="IntrestsCollapse" style="float:right">Change</a>
                        <div class="panel panel-default">
                        <div class="panel-body" id="interestDiv" style="min-height:100px">
                          <?php foreach ($userTags as $row): ?>
                            <a href="" id="<?= $row ?>" onclick="return removeTag(this.id)"><?= $row ?></a><br/>
                          <?php endforeach; ?>
                        </div>
                        </div>
                      </div>
                      <div class="collapse col-md-4" id="IntrestsCollapse">
                        <label id="interestsLabel"></label><a data-toggle="collapse" href="#CategoryCollapse" aria-expanded="false" aria-controls="CategoryCollapse" style="float:right">Category</a>
                        <div class="panel panel-default">
                        <div class="panel-body" id="tagsAvailable" style="min-height:100px">
                        </div>
                        </div>
                    </div>
                    <div class="collapse col-md-3" id="CategoryCollapse">
                      <div class="panel panel-default">
                      <div class="panel-body" style="min-height:100px">
                        <a href="" id="All" onclick="return changeCategory(this.id)">All</a><br/>
                        <? foreach($category as $row){ ?>
                          <a href="" id="<?= $row['categoryName'] ?>" onclick="return changeCategory(this.id)"><?= $row['categoryName'] ?></a><br/>
                        <? } ?>
                      </div>
                      </div>
                  </div>
                    </div>
                </div>
        </div>
<script>
  /*
    Description: When a user click on a interest they have, it will remove it by calling this method
    this method will get the name of the interest and then call the RemoveInterest method in the Controller
    If everything goes well it will get the updated interest and for the user from the controller and update the interestDiv

    Input: Name of the tag being removed
    Ouput: false to stop the page from reloading
  */
  function removeTag(tag){
    var url = "<?= base_url() ?>index.php?/Profile/RemoveInterest";
    $.ajax({
      type:'POST',
      data:{tag: tag},
      url:url,
      success: function(result){
        $('#interestDiv').html(result);
      }
    });
    return false;
  }

  /*
    Description: When a user clicks a Interest they want to add to their profile this method will be called
    it will get the name of that interest and call the AddInterest method in the controller
    if everything goes well it will append the new interest to the interestDiv and update the available interests

    Input: Name of the tag being added
    Ouput: false to stop the page from reloading
  */
  function addInterest(tag){
    var url = "<?= base_url() ?>index.php?/Profile/AddInterest";
    $.ajax({
      type:'POST',
      data:{tag: tag},
      url:url,
      success: function(result){
        $('#interestDiv').append("<a href=\"\" id=\"" + tag + "\" onclick=\"return removeTag(this.id)\">" + tag + "</a><br/>");
        changeCategory($('#interestsLabel').html());
      }
    });
    return false;
  }

  /*
  Description: When the user wants to get interests from a different category they click this and the method changes the category

  Input: Name of the category the user selected
  Ouput: false to stop the page from reloading
*/
  function changeCategory(category){
    var url = "<?= base_url() ?>index.php?/Profile/GetTagsForCategory";
    $.ajax({
      type:'POST',
      data:{category: category},
      url:url,
      success: function(result){
        $('#tagsAvailable').html(result);
        $('#interestsLabel').html(category);
      }
    });
    return false;
  }

  // this call is here to populate the avaliable interests when we first load in
  changeCategory("All");
</script>
         <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/profile.css">
