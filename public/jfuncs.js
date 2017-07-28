function deleteItem(id,from) {
	if(confirm("Do you confirm delete action?")) {
		$.post('/functions/jfuncs.php', { action: "deleteitem", id: id, from: from }, function(result) {
			location.reload();
		});		
	}
}

$('.settings_icon').click(function() {
	$(this).toggleClass('opened');
	$(this).next().slideToggle(250);
});

$('.notify .close i').click(function() {
	$(this).parent().parent().fadeOut(250);
});