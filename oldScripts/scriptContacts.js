$(document).ready(function(){

var currentContact;

$("#dialog-confirm").dialog({
	resizable:false,
	height: 130,
	modal: true,
	autoOpen: false,
	buttons: {'Delete item ' : function () {
		$.get("ajaxContact.php", {"action":"delete","id":currentContact.data('id')},
		function(msg){ currentContact.fadeOut('fast');})
		$(this).dialog('close');
	}, Cansel: function(){ $(this).dialog('close');}}
});

$('.contact').live('dblclick', function(){
	($this).find('a.edit').click();
});

$('.contact a').live('click',function(e) {
	currentContact = $(this).closest('.contact');
	currentContact.data('id',currentTODO.attr('id').replace('contact-',''));
	
	e.preventDefault();
});

$('.contact a.delete').live('click',function(){$("#dialog-confirm").dialog('open');});

$('.contact a.edit').live('click',function(){
	var container = currentContact.find('.name');
	
	if(!currentContact.data('origName')){
		currentContact.data('origName', container.text());
	} else{
		return false;
	}
	
	$('<input type="name">').val(container.text()).appendTo(container.empty());
	
	container.append('<div class="editContact">' + 
		'<a class="saveChanges" href="">Save</a> or <a class="discardChanges" href="">Cancel</a>' +
		'</div>');
});

$('.contact a.discardChanges').live('click', function(){
	currentContact.find('.name').text(currentContact.data('origName')).end().removeData('origText');
});

$('.todo a.saveChanges').live('click', function(){
	var name = currentContact.find("input[type=text]").val();
	
	$.get("ajaxContact.php", {'action':'edit','id':currentTODO.data('id'),'field':name, 'value':name});
	
	currentContact.removeData('origName').find(".name").text(name);
});

var timestamp;
$('#addButton').click(function(e){
	if(Date.now() - timestamp<5000) return false;
	
	$.get("ajaxContact.php",{'action':new, 'value':'Ivan'}, function(msg){
		$(msg).hide().appendTo('.ContactList').fadeIn();
	});
	
	timestamp = Date.now();
	
	e.preventDefault();
});
});