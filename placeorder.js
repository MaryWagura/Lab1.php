$(document).ready(function(){
	$('#btn-place-order').click(function(event){
		event.preventDefault();
		var name_of_food= $('#name_of_food'). val();
		var number_of_units= $('#number_of_units').val();
		var unit_price= $('#unit_price').val();
		var order_status= $('#status').val();

		$.ajax({
			url:"https://localhost/btc3205/lab/api/v1/orders/index.php",
			type: "post",
			data: (name_of_food:name_of_food,number_of_units,number_of_units,unit_price:unit_price,order_status:order_status),
			headers: {
				'Authorization':'Basic qo9zHm7QeVC1RAfSjCjTA3ijfsBhgb6DYQ6P4dcBJcljlOhWwAlE4fYbK71YGMa'
			},
			success: function (data){
				alert(data['message']);
			},
			error: function ()
			{
				alert ("An error occured");
			}
		});
	});
	$('#btn-check-status').click(function(event) {
		event.preventDefault();

		var order_id = $('#order_id').val();

		$.ajax({
			url: "http://localhost/labs/api/v1/orders/index.php",
			type: "get",
			data: { order_id:order_id },
			headers: {'Authorization':'Basic m8Qgm3ceLycXH6aZoH9n6yRTkqtwBBi4IQcAo7gdr6Fd9DLquVnp6xGP4AUF6gol'},
			success: function (data) {
				alert(data['message']);
			},
			error: function() {
				alert("An error occurred");
			}
		});
	});
});
