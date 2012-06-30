$(document).ready(function(){


	$(".deleteEvent").click(function(){
		var id = $(this).parent().parent().attr('id');
		
		$.ajax({
			type: "GET",
			data: "id=" +id.replace("event-",""),
			url: "deleteEvent.php",
			success:function(msg){
				$('#'+id).remove();
			}
		});
		return false;
	});
	
	var fomrNewEvent = '<form id="addEvent" method="POST" action="addingEvent.php">'+
	'<input type="text" name="note" placeholder="New Event" /><br/><label for="categories">Categories:</label><select id="categories" name="categoryId"><option value="category-0">null category</option></select></br><input type="text" name="place" placeholder="e.g. Sofia" /><br/><input type="text" name="start" id="chooseDateTime" placeholder="year-mm-dd tt" /><br/><a href="javascript:;" id="addContacts">Добави контакти</a><div id="contactsPlaceholder"></div><input type="submit" name="submit" value="DONE" class="button" /><input type="reset" name="reset" value="CLEAR" class="button" /><a href="" id="discardEvent">Cansel</a></form>';
	
	$("#addEventButton").click(function(){
        $.getJSON('categoriesJSON.php', function(data){
            var categoriesChooser = '';
            for(var i = 0; i < data.length; i++){
               categoriesChooser += '<option value="' + data[i].categoryid + '">' + data[i].type + '</option>';
            }
            $("select#categories").html(categoriesChooser);
            
        });	
       	
		$('.eventList').append('<li>' + fomrNewEvent + '</li>');
		$('#addContacts').click(function(){
			$.getJSON('contactsJSON.php', function(contacts){
				
				var contactsChooser = '<div id="chooseContacts">';
				for(var i = 0; i < contacts.length; i++){
					
					contactsChooser += '<input type="checkbox" name="contacts[]" value="' + contacts[i].contactid + '">' + contacts[i].name + " " + contacts[i].familyname + "<br/>" + contacts[i].note + "</input>";
					
				}
				contactsChooser += '<a href="javascript:;" id="hideContacts">Скрий контактите</a>';
				contactsChooser += '</div>';
				
				$('#contactsPlaceholder').html(contactsChooser);
				$('#hideContacts').click(function(){
					$('#chooseContacts').remove();
				});
			});
			return false;
		});
		$('#chooseDateTime').datetimepicker();
		$('#addEvent').submit(function(){
			var form = $(this);
			$.post(form.attr('action'), form.serialize(), function(r){
				form.parent().remove();
				$('.eventList').append(r);
				$('.discardEvent').click(function(){
					$(this).parent().remove();
				});
			});
			
			return false;
		});
		
		return false;
	});
	
	$('.noteEvent').editable('editEvent.php', {
		indicator: "saving...",
		tooltrip: "click to edit",
		cancel: 'cancel',
		submit: 'OK'
	});
	
	$('.startEvent').editable('editEvent.php',{
		indicator: "saving...",
		tooltrip: "click to edit",
		cancel: 'cancel',
		submit: 'OK'
	});
	
	$('.placeEvent').editable('editEvent.php',{
		indicator: "saving...",
		tooltrip: "click to edit",
		cancel: 'cancel',
		submit: 'OK'
	});
	
	$('.categoryEvent').editable('editEvent.php',{
		indicator: "saving...",
		tooltrip: "click to edit",
		cancel: 'cancel',
		submit: 'OK'
	});
	$('.categoryType').editable('editCategory.php',{
    	indicator: 'Saving...',
    	tooltrip : 'Click to edit...',
    	cansel 	 : 'Cancel',
    	submit   : 'OK'
    });
    
     $('#newCategory').click(function(){
    	$.get("categoryForm.html",function(contactForm){
    		$('#categories').append(contactForm);
    		$(".color-picker").miniColors(
    		{
    			letterCase: 'uppercase'
    		});
    		$(".color-picker").miniColors('value', '#' + Math.floor(Math.random() * 16777215).toString(16));
    		
    		$('#formCategory').submit(function(){
				var form = $(this);
				$.post(form.attr('action'), form.serialize(), function(r){
					alert(r);
					$('#categoriesList').append(r);
				});
				return false;
			});
		});
    });
    
					$(".color-category").miniColors({
					letterCase: 'uppercase',
					close: function(hex, rgb) {
						$.post("editCategory.php",{id:"colour-"+$(this).parent().attr('id').replace("category-","") ,value:hex });
					}
					});
				
});