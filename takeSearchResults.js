$(document).ready(function(){
	$('#startDate').datetimepicker();
	$('#endDate').datetimepicker();
	
	$('#search_form').submit(function(){
	var searchForm = $(this);
	$.post(searchForm.attr('action'), searchForm.serialize(), function(r){
		$('#search_results').html(r);
	});
	return false;
});

			$.getJSON('categoriesJSON.php', function(data){
            var categoriesChooser = '';
            for(var i = 0; i < data.length; i++){
               categoriesChooser += '<option value="' + data[i].categoryid + '">' + data[i].type + '</option>';
            }
            $("select#categories").html(categoriesChooser);
            
        });	
});
