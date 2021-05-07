
<div class="container">
<h1>Add Product</h1>
<form method="POST" action="<?php echo base_url('admin/product/store'); ?>" enctype='multipart/form-data'>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name='name' placeholder="Name">
  </div>
  <div class="form-group">
    <label for="code">Code</label>
    <input type="text" class="form-control" id="code" name='code'  placeholder="Code">
  </div>
  <div class="form-group">
    <label for="price">Price</label>
    <input type="text" class="form-control" id="price" name="price" placeholder="Price">
  </div>
  <div class="form-group">
    <label for="images">Images</label>
    <input type="file" multiple class="form-control" name="images[]" id="images" placeholder="Another input">
  </div>
  <div class="form-group">
    <label for="images">Description</label>
    <textarea class="form-control" placeholder="Description" name="description"></textarea>
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
      $(this).parents('.removeAttributeSection').remove();
    });
  });
</script>