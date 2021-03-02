<input type="text" name="search" id="search" style="border-radius:10px;" placeholder="Search" onkeyup="findmatch(this.value)"/>

<div id="searchResults">

</div>
<script>
	function findmatch(str){
		var url = window.location.href;
		if(url.includes("index.php?")){
			url = "index.php?/Friends/Find";
		}else{
			url = "Friends/Find";
		}
		$.ajax({
			type:'POST',
			data:{str: str},
			url:url,
			success: function(result){
				$('#searchResults').html(result);
			}
		});
	}
</script>
