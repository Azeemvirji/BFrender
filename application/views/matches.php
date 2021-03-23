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
<div class="container">
	<form method="post" action="<?= base_url(); ?>index.php?/MatchOptions">
	<!-- Match option button -->
	<div class="row">
	<div class="col-md-6" id="matchesHeader">
       <h3>Top Friend Matches</h3>
    </div>
	<div class="col-md-6">
        <input type="submit" value="Match Options" id="matchesBtn"/>
	</div>
	</div>
	
	<!-- Matches -->
	<? foreach($matches as $match){ ?>
    <div class="row">
	<div class="profile-head">
      <div class="profiles container thumbnail">
        <div class="col-md-2 col-sm-3 col-xs-5">
          <div class="row">
            <img src="<?= assetUrl(); ?>img/users/<?= $match['imageLocation'] ?>" class="img-responsive"/>

          </div>
        </div>
           <div class="col-md-9 col-sm-8 col-xs-9">
             <div class="row">
                     <div class="col-sm-12"><h4><?= $match['firstname'] ?> <?= $match['lastname'] ?></h4>
                     <hr>
                     </div>

                      <div class="col-sm-6 col-xs-6">
                        <p><?= $match['age'] ?> yrs</p>
                        <p>North York</p>
                        <p>Toronto</p>
						<p>Rank: <?= $match['rank'] ?>, Score: <?= $match['score'] ?></p>
                      </div>
                       <div class="col-sm-6 col-xs-6">
                          <h5>7 Common Interest Including:</h5>
                          <p><span>Craft Beers</span><span> Hockey </span><span> Camping </span></p>
                          <h5>Suggested Activity:</h5>
                          <p>Hiking</p>
                      </div>
              </div>
            </div>
           <div class="col-md-1 col-sm-1 col-xs-3">
             <ul class="nav navbar-vertical navbar-right bg-danger">
                <li><a class="lnk_usr text-dgr-link" href="#" title="Contacts">
                  <span class="tooltp text-center"> Profile</span>
                    <span class="glyphicon glyphicon-user"></span>
                  </a></li>
                <li><a class="lnk_usr text-dgr-link" href="#" title="Chat">
                  <span class="tooltp text-center"> Connect</span>
                    <span class="glyphicon glyphicon-comment"></span>
                  </a></li>
              </ul>
            </div>
      </div>
    </div><!--profile-head close-->
  </div><!--row-close-->
  </form>
<? } ?>
</div>
