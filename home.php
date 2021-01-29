<?php 
	$part = "";
	include ($part."include/include.php"); 
?>
	<!-- partial -->
	<div class="main-panel">
	  <div class="content-wrapper">
		<div class="row" id="proBanner">
		  <div class="col-12">
			</span>
		  </div>
		</div>
		<div class="page-header">
		  <h3 class="page-title">
			<span class="page-title-icon bg-gradient-primary text-white mr-2">
			  <i class="mdi mdi-home"></i>
			</span> Dashboard </h3>
		</div>
		<!-- <div class="row">
		  <div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-danger card-img-holder text-white">
			  <div class="card-body">
				<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-info card-img-holder text-white">
			  <div class="card-body">
				<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 stretch-card grid-margin">
			<div class="card bg-gradient-success card-img-holder text-white">
			  <div class="card-body">
				<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
			  </div>
			</div>
		  </div>
		</div> -->
		<div class="row">
		  <div class="col-md-12 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<div class="row">
					<?php
						$sql_manu_main = "SELECT
											ms.manu_id,
											ms.manu_name,
											ms.manu_icon,
											ms.class_home,
											ms.class_active
										FROM
											manu_setting ms
											JOIN manu_set_groub msg ON msg.manu_id = ms.manu_id
										WHERE
											ms.manu_lavel = '1' 
											AND msg.lavel_id = '{$_SESSION['PER_LAVEL']}'
										ORDER BY
											ms.manu_order ASC";
						$query_manu_main = $db->query($sql_manu_main);
						while($rec_manu_main = $db->db_fetch_array($query_manu_main)){
					?>
					<div class="col-md-6 stretch-card grid-margin" data-toggle="collapse" href="#general-<?php echo $rec_manu_main['class_active'];?>" aria-expanded="false" aria-controls="general-<?php echo $rec_manu_main['class_active'];?>">
						<div class="card bg-gradient-<?php echo $rec_manu_main['class_home'];?> card-img-holder text-white">
							<div class="card-body">
								<i class="<?php echo $rec_manu_main['manu_icon'];?> icon-lg"></i> <h2><?php echo $rec_manu_main['manu_name'];?></h2>
								<img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
							</div>
						</div>
					</div>
					<?php
						}
					?>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-- <div class="row">
		  <div class="col-md-12 grid-margin stretch-card">
			<div class="card">
			  <div class="card-body">
				<div class="clearfix">
				  <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
				</div>
				<canvas id="visit-sale-chart" class="mt-4"></canvas>
			  </div>
			</div>
		  </div>
		</div> -->
	  <!-- content-wrapper ends -->
	  <!-- partial:partials/_footer.html -->  
	</div><?php include "{$part}include/footer.php"; ?>
  </div>
