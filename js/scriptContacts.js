$(document).ready(function(){
    
	$(".delete").click(function(){
	   
        var id = $(this).parent().parent().attr('id');
		$.ajax({
				type: "GET", 
				data: "id=" +id,
				url:"deleteContact2.php",
				success:function(msg){
					$('#'+id).remove();
					alert(msg);
				}
		});
		return false;
	});
    
    var formHTML = '<form id="addEvent" method="POST" action="addingContact.php"> <label>name:</label><input type="text" name="name" required="required" placeholder="e.g. Ivan" /><br/><label>family name:</label><input type="text" name="familyname" placeholder="e.g. Petrov" /><br/><label>email:</label><input type="email" name="email" placeholder="e.g ivan@petrov.bg" /><br/><label>birthdate:</label><input type="date" name="birthdate" /><br/><label>phone</label><input type="tel" name="phone"/><br/><label>note:<label><br/><textarea placeholder="Describe your contacts..." rows="10" cols="50" maxlength="200" name="note"></textarea><br/><input type="submit" name="submit" value="DONE" id="button" /><input type="reset" value="CLEAR" /><a href="" id="discardNewContact">Cansel</a></form>';
    $("#addContactButton").click(function(){
    	$('.contactList').append('<ul>' + formHTML +'</ul>');
		$('#addEvent').submit(function(){
		var form = $(this);
			$.post(form.attr('action'), form.serialize(), function(r){
				form.parent().remove();
				$('.contactList').append(r);
				$('.discardNewContact').click(function(){
    	$(this).parent().remove();
    });
    $('.contactName').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.familyname').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.email').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.birthdate').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.phone').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
			});
			return false;
		});
		return false;
    });
    
    $('.discardNewContact').click(function(){
    	$(this).parent().remove();
    });
    $('.contactName').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.familyname').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.email').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.birthdate').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.phone').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
    
    $('.note').editable('editContact.php',{
        indicator : 'Saving...',
         tooltip   : 'Click to edit…',
         cancel    : 'Cancel',
         submit    : 'OK'
    });
       
    function takeid(par){
        return par.parent().parent().attr('id');
    }
    
    $(".tab").click(function()
	{	
		var tabType = $(this).attr('id');
	});
});