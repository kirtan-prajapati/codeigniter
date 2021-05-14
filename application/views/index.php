<div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row">
    	<?php foreach ($productList as $key => $product) {
      		$imageURL = base_url(DEFAULT_PRODUCT_IMAGE);
      		if(!empty($product['image']) && file_exists(PRODUCT_IMAGE_PATH.$product['image'])){
      			$imageURL = base_url(PRODUCT_IMAGE_PATH.$product['image']);
      		}
    		?>
	        <div class="col-md-4 mt-2">
	            <div class="card">
	                <div class="card-body">
	                    <div class="card-img-actions"> <img src="<?php echo $imageURL; ?>" class="card-img img-fluid" width="96" height="350" alt=""> </div>
	                </div>
	                <div class="card-body bg-light text-center">
	                    <div class="mb-2">
	                        <h6 class="font-weight-semibold mb-2"> <a href="#" class="text-default mb-2" data-abc="true"><?php echo $product['name']; ?></a> </h6> <a href="#" class="text-muted" data-abc="true"><?php echo $product['code']; ?></a>
	                    </div>
	                    <h3 class="mb-0 font-weight-semibold"><?php echo $product['price']; ?></h3>
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
            $.ajax({
                url: '<?php echo base_url("home/addCart"); ?>',
                type: 'POST',
                dataType: 'json',
                data:{'product_id': product_id ,'quantity':1},
                success:function(data) {
                	if(data.status == 'success'){
                		updateShoppingCartMenu();
                	}
                }
            });
		});
	});

	function updateShoppingCartMenu(){
		$.ajax({
            url: '<?php echo base_url("home/updateShoppingCartMenu"); ?>',
            type: 'POST',
            dataType: 'json',
            success:function(data) {
            	$('.shopping-container').html(data.html);
            	$('#pCart .badge').text(data.count);
            }
        });
	}
</script>