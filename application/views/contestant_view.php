<!DOCTYPE html>
<html>
<head>
	<title>Contest</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/custom.css'); ?>">
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			list_table();

			$('#show_form_button').click(function() {
				clear_form();
				$('#hidden').val('create');
				$('#formDiv').show();
			});

			$('#cancel').click(function(event) {
				event.preventDefault();
				clear_form();
			});

			$('#save').click(function(event) {
				$('.help-block').empty();
				event.preventDefault();

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url('index.php/welcome/push_contestant/'); ?>',
					dataType: 'json',
					data: $('#form').serialize(),
					success: function(data) {
						clear_form();
						
						if(data.status) { //if success reload ajax table
			                list_table();
			            } else {
			                for (var i = 0; i < data.inputerror.length; i++) {
			                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
			                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
			                }
			            }
					},
					error: function (jqXHR, textStatus, errorThrown) {
			            alert('Error getting data from ajax');
			        }
				});
			});

			$('#photo').change(function() {//$('#photo')[0].files[0].name;
				var file_data = $('#photo').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax({
                    url: "<?php echo base_url('index.php/welcome/upload_image')?>/",
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (data) {
                    	$('#file_path').val(data);
                    },
                    error: function (response) {
                    	//do something
                    }
                });
			});
		});

		function editContestant(id) {
			$('.help-block').empty();
			$('#hidden').val('update');
			$('#formDiv').show();

			$.ajax({
		        url : "<?php echo base_url('index.php/welcome/read_contestant_by_id')?>/" + id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data) {

		        	$('#hiddenId').val(id);
		            $('#first_name').val(data.Firstname);
		            $('#last_name').val(data.Lastname);
		            $('#dob').val(data.DatOfBirth);
		            var date = (data.DateOfBirth).split(' ');
		            //alert(new Date("09-24-2011"));
		            date = new Date(date[0]).toISOString().substring(0, 10);
		            $('#dob').val(date);

		            if(data.IsActive == 1) {
		            	$('#is_active').prop('checked', true);
		            } else {
		            	$('#is_active').prop('checked', false);
		            }

		            if(data.Gender == 'male') {
			            $('#male').prop('checked', true);
			        } else {
			        	$('#female').prop('checked', true);
			        }
		            //$('input[name=gender][value=' + data.Gender + ']').prop('checked',true)

		            $('#district').val(data.DistrictId);
		            $('#address').val(data.Address);
		            $('#file_path').val(data.PhotoUrl);
		        },
		        error: function (jqXHR, textStatus, errorThrown) {
		            alert('Error getting data from ajax.');
		        }
		    });
		}

		function deleteContestant(id) {
			if(confirm('You sure you wanna delete it ?')) {
				$.ajax({
					url: "<?php echo base_url('index.php/welcome/delete_contestant') ?>/" + id,
					type: 'POST',
					dataType: 'json',
					success: function(data) {
						list_table();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error deleting data.');
					}
				});
			}
		}


		function list_table() {
			$.ajax({
				url: '<?php echo base_url('index.php/welcome/read_contestant') ?>',
				dataType: 'json',
				success: function(data) {
					$('.tbody').html(data);
				},
				error: function (jqXHR, textStatus, errorThrown) {
		            alert('Error getting data from ajax');
		        }
			});
		}

		function clear_form() {
			$('#form').find("input[type=text], textarea").val("");
			$('#district').val('0');
			$('#dob').val('');
			$('input[name=gender]').prop('checked', false);
		}
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

	<div class="container">
		<div class="col-md-6" style="padding: 10px">
			<table>
				<thead>
					<tr>
						<th>Full Name</th>
						<th>Date of Birth</th>
						<th>District</th>
						<th>Gender</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
				</thead>

				<tbody class="tbody">
					
				</tbody>
			</table> <br>
			<button id="show_form_button">New</button>
		</div>

		<div class="col-md-1">&nbsp;</div>

		<div class="col-md-5" id="formDiv" style="display: none; padding: 10px">
			<form action="#" id="form" accept-charset="utf-8" enctype="multipart/form-data">
				<table>
					<tr>
						<td class="left">First Name: </td>
						<td class="left"><input type="text" name="first_name" id="first_name"><span class="help-block"></span></td>
					</tr>
					<tr>
						<td class="left">Last Name: </td>
						<td class="left"><input type="text" name="last_name" id="last_name"><span class="help-block"></span></td>
					</tr>
					<tr>
						<td class="left">Date of Birth: </td>
						<td class="left"><input type="date" name="dob" id="dob"><span class="help-block"></span></td>
					</tr>
					<tr>
						<td class="left">Is Active: </td>
						<td class="left">
							<input type="checkbox" name="is_active" id="is_active" value="1">
						</td>
					</tr>
					<tr>
						<td class="left">District: </td>
						<td class="left">
							<select name="district" id="district">
								<option selected="selected" value="0">Select District</option>
								<?php foreach($districts as $value) { ?>
									<option name="<?php echo $value->Name; ?>" value="<?php echo $value->Id; ?>"><?php echo $value->Name; ?></option>
								<?php } ?>
							</select>
							<span class="help-block"></span>
						</td>
					</tr>
					<tr>
						<td class="left">Gender: </td>
						<td class="left">
							<input type="radio" name="gender" id="male" value="male">
							<label for="male">Male</label>
							<input type="radio" name="gender" id="female" value="female">
							<label for="female">Female</label>
							<input type="hidden" name="genderr">
							<span class="help-block"></span>
						</td>
					</tr>
					<tr>
						<td class="left">Photo: </td>
						<td class="left">
							<input type="hidden" name="file_path" id="file_path">
							<input type="file" name="file" id="photo"><span class="help-block"></span>
						</td>
					</tr>
					<tr>
						<td class="left">Address: </td>
						<td class="left"><textarea rows="5" cols="27" name="address" id="address"></textarea><span class="help-block"></span></td>
					</tr>
				</table> <br>
				<input type="hidden" name="hiddenId" id="hiddenId">
				<input type="hidden" name="hidden" id="hidden">
				<input type="submit" value="Save" id="save">
				<button id="cancel">Cancel</button>
			</form>
		</div>
	</div>

</body>
</html>