<div class = "container">
	<? foreach($friends as $friend){ ?>
	<div class="row">
			<div class="col-md-6">
					<label><?= $friend['username'] ?></label>
			</div>
			<div class="col-md-6">
					<a href="<?= base_url(); ?>index.php?/Message/chat/<?= $friend['username'] ?>"><span class="glyphicon glyphicon-comment"></span></a>
			</div>
	</div>
<? } ?>
</div>
