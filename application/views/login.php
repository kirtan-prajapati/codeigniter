<div class="container">
	<h1>Login</h1>
	<form method="post" action="<?php echo base_url('user/loginCheck'); ?>" autocomplete="off">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?php echo set_value('email'); ?>">
    <?php echo form_error('email', '<div class="error">', '</div>'); ?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password'); ?>">
    <?php echo form_error('password', '<div class="error">', '</div>'); ?>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>