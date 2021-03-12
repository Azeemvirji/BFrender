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
             <div class="requirments tag-container" id="requirments">
             </div>
           </div>
         </div>

         <!-- Preferences -->
         <div class="panel panel-default blueBorder">
           <div class="preferencesDiv">
           <h4 class="panel-title">Preferences</h4>
           </div>
           <div class="panel-body">
             <div class="preferences tag-container" id="preferences">
             </div>
           </div>
         </div>

         <!-- DealBreaker -->
         <div class="panel panel-default redBorder">
           <div class="dealbreakersDiv">
           <h4 class="panel-title" style="">DealBreaker</h4>
           </div>
           <div class="panel-body">
             <div class="dealbreaker tag-container" id="dealbreaker">
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

                         <div class="portlet-body chat-widget tag-container" style="overflow-y: auto; width: auto; height: 300px;" id="main">
                           <div class="row">
                             <div class="col-lg-12" id="tagsAvailable">
                                   <?php foreach ($tags as $row): ?>
                                     <div class="list-item" draggable="true" id="<?= $row['tagName'] ?>"><?= $row['tagName'] ?></div>
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
                     <a href="" id="All" onclick="return getTags(this.id)">All</a><br/>
                     <?php foreach ($category as $row): ?>
                       <a href="" id="<?= $row['categoryName'] ?>" onclick="return getTags(this.id)"><?= $row['categoryName'] ?></a><br/>
                     <?php endforeach; ?>
                   </div>
                 </div>
               </div>

             </div>
           </div>
           <div id="testResult">
           </div>

<script>
function adddragging(){
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
      if(draggedItem != null){
			     this.append(draggedItem);
           weight = this.id;
           tagName = draggedItem.id;

           setWeight(weight, tagName);

           e.stopImmediatePropagation()
      }
		});
	}
}
}
adddragging();
  function getTags(category){
    var url = window.location.href;
		if(url.includes("index.php?")){
			url = "index.php?/MatchOptions/GetTagsForCategory";
		}else{
			url = "MatchOptions/GetTagsForCategory";
		}
    $.ajax({
      type:'POST',
      data:{category: category},
      url:url,
      success: function(result){
        $('#tagsAvailable').html(result);
          adddragging();
      }
    });

    return false;
  }

  function setWeight(weight, tagName){
    var url = window.location.href;
    if(url.includes("index.php?")){
      url = "index.php?/MatchOptions/SetWeight";
    }else{
      url = "MatchOptions/SetWeight";
    }
    $.ajax({
      type:'POST',
      data:{weight: weight, tagName: tagName},
      url:url,
      success: function(result){

      }
    });
  }
</script>
 <link rel="stylesheet" type="text/css" href="<?= assetUrl(); ?>css/matchOptions.css">
