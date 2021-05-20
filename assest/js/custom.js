$(document).ready(function(){
	$(document).on('click','.removeCartItem', function(){
		var rowid = $(this).data('rowid');
		var action = $(this).data('action');

        $.ajax({
            url: action,
            type: 'POST',
            dataType: 'json',
            data:{'rowid':rowid},
            success:function(data) {
            	if(data.status == 'success'){
            		updateShoppingCartMenu();
            	}
            }
        });
	});
});