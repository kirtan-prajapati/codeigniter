<div class="container">
  <h1><?php echo $title; ?></h1>
  <form method="POST" action="<?php echo base_url('admin/product/update'); ?>" enctype='multipart/form-data'>
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>" >
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name='name' placeholder="Name" value="<?php echo $product['name']; ?>">
      <?php echo form_error('name', '<div class="text-warning">', '</div>'); ?>
    </div>
    <div class="form-group">
      <label for="code">Code</label>
      <input type="text" class="form-control" id="code" name='code'  placeholder="Code" value="<?php echo $product['code']; ?>">
      <?php echo form_error('code', '<div class="text-warning">', '</div>'); ?>
    </div>
    <div class="form-group">
      <label for="price">Price</label>
      <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="<?php echo $product['price']; ?>">
      <?php echo form_error('price', '<div class="text-warning">', '</div>'); ?>
    </div>
    <div class="form-group">
      <label for="images">Images</label>
      <input type="file" multiple class="form-control" name="images[]" id="images" placeholder="Another input">
    </div>
    <div class="row">
      <div class="col-md-1">
        <button type="button" class="btn btn-default removeImages">Delete</button>
      </div>
      <div class="col-md-11">
        <div class="row">
        	<?php foreach ($productImages as $pro) {
      		$imageURL = base_url(DEFAULT_PRODUCT_IMAGE);
      		if(!empty($pro['image']) && file_exists(PRODUCT_IMAGE_PATH.$pro['image'])){
      			$imageURL = base_url(PRODUCT_IMAGE_PATH.$pro['image']);
      		}
        	?>
        		<div class="col-sm-2 imgBox <?php echo 'img_box_'.$pro['id']; ?>">
              <div class="form-check">
                <input class="form-check-input position-static" type="checkbox" name="rem[]" value="<?php echo $pro['id']; ?>">
              </div>
              <input type="file" id="img_<?php echo $pro['id']; ?>" data-id="<?php echo $pro['id']; ?>" class="d-none" onchange="updateImage(this, <?php echo $pro['id']; ?>)" >
        			<img src="<?php echo $imageURL; ?>" class="img-thumbnail changeImage" data-id="<?php echo $pro['id']; ?>">
        		</div>
        	<?php } ?>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label for="images">Description</label>
      <textarea class="form-control" placeholder="Description" name="description"><?php echo $product['description']; ?></textarea>
      <?php echo form_error('description', '<div class="text-warning">', '</div>'); ?>
    </div>

    <hr>
    <label for="price">Add Attributes</label>

    <div class="row attributeSection">
      <div class="col-sm-5">
        <div class="form-group">
          <input type="text" class="form-control" name="attribute_name[]" placeholder="Attribute Name">
        </div>
      </div>
      <div class="col-sm-5">
        <div class="form-group">
          <input type="text" class="form-control" name="attribute_value[]" placeholder="Attribute Value">
        </div>
      </div>
      <div class="col-sm-2">
        <button type="button" class="add_attr" class="btn btn-default" data-clone="attributeSection">Add Attributes</button>
      </div>
    </div>

    <div class="form-group">
    	<input type="submit" class="btn btn-primary" name='submit' value="Submit"/>
    </div>
  </form>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
    $(document).on('click','button.add_attr', function(){
      var cloneClassName = $(this).attr('data-clone');
      var clonetest = $('.'+cloneClassName).clone().insertAfter('.attributeSection');
      $(this).parents('.attributeSection').removeClass('attributeSection').addClass('removeAttributeSection');
      $(this).removeClass('add_attr').addClass('remove_attr').text('Remove');
      $('.'+cloneClassName).find('input').val('');
    });

    $(document).on('click','button.remove_attr', function(){
        var attrSection = $(this).parents('.removeAttributeSection');
        let attrElement = attrSection.find('input[name="attribute_id[]"]');
        if(attrElement.length > 0){
            var currentEle = $(this);
            let attrId = attrElement.val();
            $.ajax({
                url: '<?php echo base_url("admin/product/removeAttr"); ?>',
                type: 'POST',
                dataType: 'json',
                data:{'attribute_id': attrId, 'product_id': "<?php echo $product['id']; ?>"},
                success:function(data) {
                    attrSection.remove();
                }
            })
            console.log(attrId)
        }else{
          attrSection.remove();
        }
    });

    productAttr = '<?php echo json_encode($productAttributes); ?>';
    productAttr = jQuery.parseJSON(productAttr);
    $.each(productAttr, function(index, item){
      $('button.add_attr').trigger('click');
      $($('input[name="attribute_name[]"]')[index]).val(item.name);
      $($('input[name="attribute_value[]"]')[index]).val(item.value);
      $('<input type="hidden" name="attribute_id[]" value="'+item.attribute_id+'">').insertAfter($($('input[name="attribute_value[]"]')[index]));
    });

    $(document).on('click','.changeImage',function(){
        var idSelector = '#img_'+$(this).data('id');
        $(idSelector).trigger('click');
    });


    $(document).on('click','.removeImages',function(){
        var checkedImages = $('input:checkbox[name="rem[]"]:checked');
        if(checkedImages.length > 0){
            var ids = [];
            $.each(checkedImages, function(index,item){
                ids.push($(item).val());
            });
            $.ajax({
                url: '<?php echo base_url("admin/product/deleteImages"); ?>',
                type: 'POST',
                dataType: 'json',
                data:{'ids': ids, 'product_id': "<?php echo $product['id']; ?>"},
                success:function(data) {
                    $.each(ids, function(index,item){
                      $('.imgBox.img_box_'+item).remove();
                    });
                }
            })
        }else{
            alert('First you need to select images');
        }
    });

  });

  function updateImage(element,id){
    var fd = new FormData();
    var files = $(element)[0].files;
    if(files.length > 0 ){
      $(element).parents('.imgBox').find('.changeImage').attr('src','https://wpamelia.com/wp-content/uploads/2018/11/ezgif-2-6d0b072c3d3f.gif');
      fd.append('file',files[0]);
      fd.append('id',id);
      fd.append('product_id',"<?php echo $product['id']; ?>");

      $.ajax({
        url: '<?php echo base_url("admin/product/changeImage"); ?>',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
          if(response.status == 'success'){
            $(element).parents('.imgBox').find('.changeImage').attr("src",response.image); 
            //$(".preview img").show(); // Display image element
          }else{
            //alert('file not uploaded');
          }
        },
      });
    }
  }
</script>