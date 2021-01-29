<?php
  session_start();
  ini_set('display_errors',0);
  include ($part."include/function.php"); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="character_set">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Technic Gravure</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=$part;?>assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=$part;?>assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?=$part;?>assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?=$part;?>assets/images/favicon.png" />

    <script src="<?=$part;?>js/jquery-3.5.1.min.js"></script>
    <script src="<?=$part;?>js/sweetalert2019.js"></script>
    <link href="<?=$part;?>select2/dist/css/select2.css" rel="stylesheet"/>
    <script src="<?=$part;?>select2/dist/js/select2.js" defer></script>
    <script src="<?=$part;?>include/function.js" defer></script>
	
	
	

	<style>
		.datepicker {
			/* Appended to body, abs-pos off the page */
			position: absolute;
			display: none;
			top: -9999em;
			left: -9999em;
		}
		iframe{
			overflow:hidden;
		}
	</style>

  </head>
  <script>
		$(document).ready(function() { 
			$(".select2").select2(); 
			$(".selectbox").select2(); 
			// $('.datepicker').datepicker();
		});
		// $(".custom-file-input").on("change", function() {
			// var fileName = $(this).val().split("\\").pop();
			// $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		// });
  </script>
  <?php
	if($Show_Header!=1){
  ?>
	  <body>
		<div class="container-scroller">
		  <!-- partial:partials/_navbar.html -->
		  <?php 
			include "{$part}include/header.php";
		  ?>
		  <!-- partial -->
		  <div class="container-fluid page-body-wrapper">
			<!-- partial:partials/_sidebar.html -->
	<?php 
			include "{$part}include/manu.php"; 
	}
		?>