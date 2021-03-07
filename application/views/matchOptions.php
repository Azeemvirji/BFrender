<div class="container">
  <div class="row">
        <div class="col-md-12 col-lg-12">
          <h1> Match Options</h1>
        </div>
  </div>
</div>
<hr>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <!-- Requirements -->
         <div class="panel panel-default greenBorder">
           <div class="requirementsDiv">
             <h4 class="panel-title">Requirements</h4>
           </div>
           <div class="panel-body">
             <div class="requirments tag-container">
             </div>
           </div>
         </div>

         <!-- Preferences -->
         <div class="panel panel-default blueBorder">
           <div class="preferencesDiv">
           <h4 class="panel-title">Preferences</h4>
           </div>
           <div class="panel-body">
             <div class="preferences tag-container">
             </div>
           </div>
         </div>

         <!-- DealBreaker -->
         <div class="panel panel-default redBorder">
           <div class="dealbreakersDiv">
           <h4 class="panel-title" style="">DealBreaker</h4>
           </div>
           <div class="panel-body">
             <div class="dealbreaker tag-container">
             </div>
           </div>
         </div>



       </div>
       <!-- Middle Screen  -->
           <div class="col-md-6">
             <div class="container">
               <div class="row">
                 <div class="col-sm-6 ">
                   <div class="portlet portlet-default">
                     <div class="portlet-heading">
                       <div class="portlet-title">
                         <h4>Tags Available</h4>
                       </div>

                     <div class="clearfix"></div>
                     </div>

                     <div id="chat" class="panel-collapse collapse in">

                         <div class="portlet-body chat-widget tag-container" style="overflow-y: auto; width: auto; height: 300px;">
                           <div class="row">
                             <div class="col-lg-12">
                                   <?php foreach ($tags as $row): ?>
                                     <div class="list-item" draggable="true"><?= $row['tagName'] ?></div>
                                   <?php endforeach; ?>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <!-- Right side of screen -->

               <div class="col-md-3">


                 <!-- Tag Category -->
                 <div class="panel panel-default">
                   <div class="panel-heading">
                     <h4 class="panel-title">Tag Category</h4>
                   </div>
                   <div class="panel-body">
                     <?php foreach ($category as $row): ?>
                       <?= $row['categoryName'] ?><br/>
                     <?php endforeach; ?>
                   </div>
                 </div>
               </div>

             </div>
           </div>

<script>
const list_items = document.querySelectorAll('.list-item');
const containers = document.querySelectorAll('.tag-container');

let draggedItem = null;

for (let i = 0; i < list_items.length; i++) {
	const item = list_items[i];

	item.addEventListener('dragstart', function () {
		draggedItem = item;
		setTimeout(function () {
			item.style.display = 'none';
		}, 0)
	});

	item.addEventListener('dragend', function () {
		setTimeout(function () {
			draggedItem.style.display = 'block';
			draggedItem = null;
		}, 0);
	})

	for (let j = 0; j < containers.length; j ++) {
		const container = containers[j];

		container.addEventListener('dragover', function (e) {
			e.preventDefault();
		});

		container.addEventListener('dragenter', function (e) {
			e.preventDefault();
		});

		container.addEventListener('dragleave', function (e) {
		});

		container.addEventListener('drop', function (e) {
			this.append(draggedItem);
		});
	}
}
</script>

<style>
.requirments, .preferences, .dealbreaker{
  height:auto;
  min-height: 50px;
}

.dealbreakersDiv{
  background-color:red;
  color: white;
  padding: 10px 15px;
}

.redBorder{
  border: 2px solid red;
}

.preferencesDiv{
  background-color:blue;
  color: white;
  padding: 10px 15px;
}

.blueBorder{
  border: 2px solid blue;
}

.requirementsDiv{
  background-color:green;
  color: white;
  padding: 10px 15px;
}

.greenBorder{
  border: 2px solid green;
}

</style>

 <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/matchOptions.css">
