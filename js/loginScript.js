	$(document).ready(function()
	{

		$(".tab").click(function()
	{
		var tabType = $(this).attr('id');

		if( tabType == 'signup')
	{
		$("#login").removeClass('select');
		$("#signup").addClass('select');
		$("#loginbox").slideUp();
		$("#signupbox").slideDown();
	}
	else
	{
		$("#signup").removeClass('select');
		$("#login").addClass('select');
		$("#signupbox").slideUp();
		$("#loginbox").slideDown();
	}

	});

});