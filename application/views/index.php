<div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row">
    	<?php foreach ($productList as $key => $product) {
      		$imageURL = base_url(DEFAULT_PRODUCT_IMAGE);
      		if(!empty($product['image']) && file_exists(PRODUCT_IMAGE_PATH.$product['image'])){
      			$imageURL = base_url(PRODUCT_IMAGE_PATH.$product['image']);
      		}
    		?>
	        <div class="col-md-4 mt-2 productBox">
	            <div class="card">
	                <div class="card-body">
	                    <div class="card-img-actions"> <img src="<?php echo $imageURL; ?>" class="card-img img-fluid" width="96" height="350" alt=""> </div>
	                </div>
	                <div class="card-body bg-light text-center">
	                    <div class="mb-2">
	                        <h6 class="font-weight-semibold mb-2"> <a href="#" class="text-default mb-2" data-abc="true"><?php echo $product['name']; ?></a> </h6> <a href="#" class="text-muted" data-abc="true"><?php echo $product['code']; ?></a>
	                    </div>
	                    <h3 class="mb-0 font-weight-semibold"><?php echo $product['price']; ?></h3>

						<div class="qty mb-2 mt-1 plusMinusField" data-productid="<?php echo $product['id']; ?>">
							<span class="minus bg-dark">-</span>
							<input type="number" class="count" name="qty" value="<?php echo (!empty($cartItem[$product['id']]))?$cartItem[$product['id']]['qty']:'1'; ?>" data-rowid="<?php echo (!empty($cartItem[$product['id']]))?$cartItem[$product['id']]['rowid']:'0'; ?>">
							<span class="plus bg-dark">+</span>
						</div>

	                    <button type="button" class="btn bg-cart addToCart" data-id="<?php echo $product['id']; ?>"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>
	                </div>
	            </div>
	        </div>
	    <?php } ?>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		updateShoppingCartMenu();
		$("#pCart").on("click", function () {
			$(".shopping-cart").fadeToggle("fast");
		});
		$(document).on('click','.addToCart',function(){
			var product_id = $(this).data('id');
			var quantity = 1;
			addToCart(product_id,quantity);
		});

		$('.productBox .count').prop('disabled', true);
		$(document).on('click','.plus',function(){
			var counterEle = $(this).parents('.productBox').find('.count');
			$(counterEle).val(parseInt($(counterEle).val()) + 1 );
			var product_id = $(this).parents('.plusMinusField').data('productid');
			var qty = $(counterEle).val();
			var rowid = $(counterEle).data('rowid');
			addToCart(product_id,qty,rowid);
		});
		$(document).on('click','.minus',function(){
			var counterEle = $(this).parents('.productBox').find('.count');
			$(counterEle).val(parseInt($(counterEle).val()) - 1 );
			if ($(counterEle).val() == 0) {
				$(counterEle).val(1);
			}
			var product_id = $(this).parents('.plusMinusField').data('productid');
			var qty = $(counterEle).val();
			var rowid = $(counterEle).data('rowid');
			addToCart(product_id,qty,rowid);
		});
	});

	function addToCart(product_id,quantity,rowid){
        $.ajax({
            url: '<?php echo base_url("home/addCart"); ?>',
            type: 'POST',
            dataType: 'json',
            data:{'product_id': product_id ,'quantity':quantity, 'rowid':rowid},
            success:function(data) {
            	if(data.status == 'success'){
            		updateShoppingCartMenu();
            	}
            }
        });
	}

	function updateShoppingCartMenu(){
        var isVisible = $('.shopping-container .shopping-cart:visible').length;
		$.ajax({
            url: '<?php echo base_url("home/updateShoppingCartMenu"); ?>',
            type: 'POST',
            dataType: 'json',
            success:function(data) {
            	$('.shopping-container').html(data.html);
            	$('#pCart .badge').text(data.count);
                if(isVisible){
                    $('.shopping-container .shopping-cart').show();
                }
            }
        });
	}
</script>


<style type="text/css">
	
/* Start Plus Minus Field */
.qty .count {
    color: #000;
    display: inline-block;
    vertical-align: top;
    font-size: 25px;
    font-weight: 700;
    line-height: 30px;
    padding: 0 2px
    ;min-width: 35px;
    text-align: center;
}
.qty .plus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    }
.qty .minus {
    cursor: pointer;
    display: inline-block;
    vertical-align: top;
    color: white;
    width: 30px;
    height: 30px;
    font: 30px/1 Arial,sans-serif;
    text-align: center;
    border-radius: 50%;
    background-clip: padding-box;
}
div {
    text-align: center;
}
.minus:hover{
    background-color: #717fe0 !important;
}
.plus:hover{
    background-color: #717fe0 !important;
}
/*Prevent text selection*/
span{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}
input{  
    border: 0;
    width: 2%;
}
nput::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input:disabled{
    background-color:white;
}
/* End Plus Minus Field */
</style>