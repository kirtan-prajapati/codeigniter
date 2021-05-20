<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:300,400,700">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(CSS_PATH.'custom.css'); ?>">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="<?php echo base_url(JS_PATH.'custom.js'); ?>"></script>
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Navbar w/ text</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
    <span class="navbar-text">
      <a href="#" id="pCart"><i class="fa fa-shopping-cart"></i> Cart <span class="badge">0</span></a>
    </span>
    <?php if(!empty(($this->session->userdata('logged_in')))){ ?>
    <span class="navbar-text">
      <a href="<?php echo base_url('User/logout') ?>" class="btn btn-primary">Logout</a>
    </span>
    <?php } ?>
  </div>
</nav>

<div class="shopping-container"></div>