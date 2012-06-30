$(document).ready(function(){
	$('#eventsTab').click(function(){
	
		$.ajax({
			url: "showEvents.php",
			success: function(allEvents){
				$('#panel').html(allEvents);
			}
		});
			
		return false;
	});
	
		
	
	$('#contactsTab').click(function(){
		$.ajax({
			url: "showContacts.php",
			success: function(allContacts){
				$('#panel').html(allContacts);
			}
		});
		return false;
	});
	
	$('#searchTab').click(function(){
		$.get('search.html', function(searchForm){
			$('#panel').html(searchForm);
			$('#panel').append('<script type="text/javascript" src="takeSearchResults.js"></script>');
		});
		return false;
	});
});