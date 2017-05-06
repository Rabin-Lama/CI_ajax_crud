<!DOCTYPE html>
<html>
<head>
	<title>Gallery</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/gallery.css'); ?>">
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	<script>
		$(document).ready(function() {
			$('.main a').click(function() {
				$('.main a').removeClass('current');
				$(this).parent().addClass('current');
			});
		});
	</script>
</head>

<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li><a href="<?php echo base_url('index.php/welcome/contestant'); ?>">Contestant</a></li>
	        <li><a href="<?php echo base_url('index.php/welcome/gallery'); ?>">Photo Gallery</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="container main">
		<ul id="gallery">
			<?php
				foreach($contestants as $value) {
					if($value->IsActive == 1) {
			?>

						<li class="col-md-3">
							<a href="#" id="image"><img src="<?php echo base_url($value->PhotoUrl); ?>" class="img img-responsive"></a>
						</li>
			<?php
					}
				}
			?>
		</ul>
	</div>

</body>
</html>