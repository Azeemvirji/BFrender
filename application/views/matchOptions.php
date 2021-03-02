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
         <div class="panel panel-default">
           <div class="panel-heading">
             <h4 class="panel-title">Requirements</h4>
           </div>
           <div class="panel-body">
             <div class="requirments tag-container">
             </div>
           </div>
         </div>

         <!-- Preferences -->
         <div class="panel panel-default">
           <div class="panel-heading">
           <h4 class="panel-title">Preferences</h4>
           </div>
           <div class="panel-body">
             <div class="preferences tag-container">
             </div>
           </div>
         </div>

         <!-- DealBreaker -->
         <div class="panel panel-default">
           <div class="panel-heading">
           <h4 class="panel-title">DealBreaker</h4>
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
                                   <div class="list-item" draggable="true">Hiking1</div>
                                   <div class="list-item" draggable="true">Hiking2</div>
                                   <div class="list-item" draggable="true">Hiking3</div>
                                   <div class="list-item" draggable="true">Hiking4</div>
                                   <div class="list-item" draggable="true">Hiking5</div>
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
                     <p>All       452</p>
                     <p>Outdoor   4</p>
                     <p>sports    31</p>
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
</style>

 <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/matchOptions.css">
