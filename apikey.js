$(document).ready(function()
{
	$('#api-key-btn').click(function(event)
	{
		var confirm_key = confrim("You are about to generate a new API key");
		if(!confirm_key)
		{
			return;
		}
		$.ajax({
			url: "apikey.php",
			type: "post",
			success: function(data)
			{
				if (data['sucess']==1)
				{
					$('#api_key').val(data['message']);
				}else
				{
					alert("something went wrong. Try again");
				}
			}
		});
	});
});