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
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
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
                        <label id="interestsLabel">All</label><a data-toggle="collapse" href="#CategoryCollapse" aria-expanded="false" aria-controls="CategoryCollapse" style="float:right">Category</a>
                        <div class="panel panel-default">
                        <div class="panel-body" id="tagsAvailable" style="min-height:100px">
                          <?php foreach ($allTags as $row): ?>
                            <?php if ($row['tagName'] != ""): ?>
                              <a href="" id="<?= $row['tagName'] ?>" onclick="return addInterest(this.id)"><?= $row['tagName'] ?></a><br/>
                            <?php endif; ?>
                          <?php endforeach; ?>
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
            </form>
        </div>
<script>
  function removeTag(tag){
    var url = window.location.href;
    if(url.includes("index.php?")){
      url = "index.php?/Profile/RemoveInterest";
    }else{
      url = "Profile/RemoveInterest";
    }
    $.ajax({
      type:'POST',
      data:{tag: tag},
      url:url,
      success: function(result){
        $('#interestDiv').html(result);
        console.log(result);
      }
    });
    return false;
  }
  function addInterest(tag){
    var url = window.location.href;
    if(url.includes("index.php?")){
      url = "index.php?/Profile/AddInterest";
    }else{
      url = "Profile/AddInterest";
    }
    $.ajax({
      type:'POST',
      data:{tag: tag},
      url:url,
      success: function(result){
        $('#interestDiv').append("<a href=\"\" id=\"" + tag + "\" onclick=\"return removeTag(this.id)\">" + tag + "</a>");
        changeCategory($('#interestsLabel').html());
      }
    });
    return false;
  }
  function changeCategory(category){
    var url = window.location.href;
    if(url.includes("index.php?")){
      url = "index.php?/Profile/GetTagsForCategory";
    }else{
      url = "Profile/GetTagsForCategory";
    }
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
</script>
         <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/profile.css">
