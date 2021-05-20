<div class="container">
	<?php
		if($this->session->flashdata('messageAlert')){
			$messageAlert = $this->session->flashdata('messageAlert');
			$alertClass = ($messageAlert['status'] == 'success')?'success':'danger';
			echo '<div class="alert alert-'.$alertClass.'" role="alert">'.$messageAlert['message'].'</div>';
		}
	?>
	<h1>Product List</h1>
	<div class="row">
		<div class="col-sm-12">
			<a href="<?php echo base_url('admin/product/add'); ?>" class="btn btn-primary">Add Product</a>
		</div>
	</div>
	<br>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<table class="table productsTable">
			  <thead>
			    <tr>
			      <th scope="col">#Code</th>
			      <th scope="col">Name</th>
			      <th scope="col">Image</th>
			      <th scope="col">Price</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach ($productList as $product) { ?>
				    <tr>
						<th scope="row"><?php echo $product['code']; ?></th>
						<td><?php echo $product['name']; ?></td>
						<td>
							<div class="text-center">
								<?php
									$imageURL = base_url(DEFAULT_PRODUCT_IMAGE);
									if(!empty($product['image']) && file_exists(PRODUCT_IMAGE_PATH.$product['image'])){
										$imageURL = base_url(PRODUCT_IMAGE_PATH.$product['image']);
									}
								?>
								<img src="<?php echo $imageURL; ?>" class="rounded" alt="<?php echo $product['name']; ?>" width="70" height="70">
							</div>
						</td>
						<td><?php echo $product['price']; ?></td>
						<td>
							<a href="<?php echo base_url('admin/product/edit/').$product['id']; ?>"><ion-icon name="create-outline"></ion-icon></a>
							<a href="<?php echo base_url('admin/product/delete/').base64_encode($product['id']); ?>"><ion-icon name="trash-outline"></ion-icon></a>
						</td>
				    </tr>
			  	<?php } ?>
			  </tbody>
			</table>
		</div>
	</div>

</div>

<script type="text/javascript">
	$(document).ready( function () {
	    $('table.productsTable').DataTable();
	} );
</script>