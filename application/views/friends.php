<div class = "container">
	<? if(count($friends) > 0){ ?>
	<h3>Friends</h3>
	<? foreach($friends as $friend){ ?>
<div class="row">
	<div class="profile-head">
		<div class="profiles container thumbnail">
			<div class="col-md-2 col-sm-3 col-xs-5">
				<div class="row">
					<img src="<?= assetUrl(); ?>img/users/<?= $friend['imageLocation'] ?>" class="img-responsive"/>

				</div>
			</div>
				 <div class="col-md-9 col-sm-8 col-xs-9">
					 <div class="row">
									 <div class="col-sm-12"><h4><?= $friend['username'] ?></h4>
									 <hr>
									 </div>

										<div class="col-sm-6 col-xs-6">
											<p><?= $friend['firstname'] ?> <?= $friend['lastname'] ?></p>
											<p><?= $friend['age'] ?> yrs</p>
											<p><?= $friend['city'] ?></p>
										</div>
										 <div class="col-sm-6 col-xs-6">
											 <? if ($friend['InterestCount'] > 0){ ?>
												<h5><?= $friend['InterestCount'] ?> Common Interest Including:</h5>
												<p><? foreach ($friend['CommonInterest'] as $value) { ?>
													<span><?= $value ?></span>,
												<? } ?></p>
												<? } ?>
												<? if($friend['ActivitySuggestion'] != ""){ ?>
												<h5>Suggested Activity:</h5>
												<p><?= $friend['ActivitySuggestion'] ?></p>
												<? } ?>
										</div>
						</div>
					</div>
				 <div class="col-md-1 col-sm-1 col-xs-3">
					 <ul class="nav navbar-vertical navbar-right bg-danger">
							<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/ViewProfile/view/<?= $friend['username'] ?>">
								<span class="tooltp text-center"> Profile</span>
									<span class="glyphicon glyphicon-user"></span>
								</a></li>
							<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Message/chat/<?= $friend['username'] ?>">
								<span class="tooltp text-center"> Connect</span>
									<span class="glyphicon glyphicon-comment"></span>
								</a></li>
								<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Friends/Remove/<?= $friend['username'] ?>">
									<span class="tooltp text-center"> Remove</span>
										<span class="glyphicon glyphicon-remove-circle"></span>
									</a></li>
						</ul>
					</div>
		</div>
	</div><!--profile-head close-->
	</div><!--row-close-->
<? } ?>
<? } ?>
<? if(count($pending) > 0){ ?>
<h3>Pending</h3>
<? foreach($pending as $friend){ ?>
<div class="row">
<div class="profile-head">
	<div class="profiles container thumbnail">
		<div class="col-md-2 col-sm-3 col-xs-5">
			<div class="row">
				<img src="<?= assetUrl(); ?>img/users/<?= $friend['imageLocation'] ?>" class="img-responsive"/>

			</div>
		</div>
			 <div class="col-md-9 col-sm-8 col-xs-9">
				 <div class="row">
								 <div class="col-sm-12"><h4><?= $friend['username'] ?></h4>
								 <hr>
								 </div>

									<div class="col-sm-6 col-xs-6">
										<p><?= $friend['firstname'] ?> <?= $friend['lastname'] ?></p>
										<p><?= $friend['age'] ?> yrs</p>
										<p><?= $friend['city'] ?></p>
									</div>
									<div class="col-sm-6 col-xs-6">
										<? if ($friend['InterestCount'] > 0){ ?>
										 <h5><?= $friend['InterestCount'] ?> Common Interest Including:</h5>
										 <p><? foreach ($friend['CommonInterest'] as $value) { ?>
											 <span><?= $value ?></span>
										 <? } ?></p>
										 <? } ?>
										 <? if($friend['ActivitySuggestion'] != ""){ ?>
										 <h5>Suggested Activity:</h5>
										 <p><?= $friend['ActivitySuggestion'] ?></p>
										 <? } ?>
								 </div>
					</div>
				</div>
			 <div class="col-md-1 col-sm-1 col-xs-3">
				 <ul class="nav navbar-vertical navbar-right bg-danger">
						<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/ViewProfile/view/<?= $friend['username'] ?>">
							<span class="tooltp text-center"> Profile</span>
								<span class="glyphicon glyphicon-user"></span>
							</a></li>
						<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Message/chat/<?= $friend['username'] ?>">
							<span class="tooltp text-center"> Connect</span>
								<span class="glyphicon glyphicon-comment"></span>
							</a></li>
							<? if($friend['sentBy'] == $_SESSION['username']){ ?>
							<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Friends/Remove/<?= $friend['username'] ?>">
								<span class="tooltp text-center"> Cancel Pending</span>
									<span class="glyphicon glyphicon-remove-circle"></span>
								</a></li>
							<? }else{ ?>
								<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Friends/Confirm/<?= $friend['username'] ?>">
									<span class="tooltp text-center"> Accept</span>
										<span class="glyphicon glyphicon-plus"></span>
									</a></li>
								<li><a class="lnk_usr text-dgr-link" href="<?= base_url(); ?>index.php?/Friends/Remove/<?= $friend['username'] ?>">
									<span class="tooltp text-center"> Decline</span>
										<span class="glyphicon glyphicon-remove-circle"></span>
									</a></li>
							<? } ?>
					</ul>
				</div>
	</div>
</div><!--profile-head close-->
</div><!--row-close-->
<? } ?>
<? } ?>
</div>
<style>
.tooltp {
  position: absolute;
  background: pink;
  float: right;
  width: 0px;
  right: 60px;
  padding: 5px 0px;
  margin: -5px;
  -webkit-transition: width 1s; /* For Safari 3.1 to 6.0 */
  transition: width 1s;
  overflow: hidden;
}
 .lnk_usr:hover .tooltp{
   overflow: hidden;
   display: inline-block;
   right: 60px;
   width: 60px;
 }

 #matchesHeader{
   float:left;
 }

 #matchesBtn{
   float:right;
  vertical-align: sub;
  border: none;
  border-radius: 1.5rem;
  padding: 2%;
  font-weight: 600;
  color: #6c757d;
  cursor: pointer;
 }
</style>
