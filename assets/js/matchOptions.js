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
			this.append(draggedItem);
		});
	}
}
}
adddragging();
