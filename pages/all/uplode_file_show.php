<?php
	// $Show_Header = 1;
	// $part = "../../";
	// include ($part."include/include.php"); 
	$arr_type = array();
	
	// $sqlSelectFile = "SELECT temp_id,file_name_default,file_name_new,file_type FROM file_uplode WHERE temp_code = 'E7yXK8pc2m3R7TQFB4NsUN30GNRey2JsjhpjfRRD7j9tpqkzA7091020102412'";
	echo $sqlSelectFile = "SELECT temp_id,file_name_default,file_name_new,file_type FROM file_uplode WHERE temp_code = '".$_GET['temp_code']."'";
	$querySelectFile = $db->query($sqlSelectFile);
	while($recSelectFile = $db->db_fetch_array($querySelectFile)){
		$arr_type[$recSelectFile['temp_id']]['file_type'] 			= explode('/',$recSelectFile['file_type']);
		$arr_type[$recSelectFile['temp_id']]['file_name_default'] 	= $recSelectFile['file_name_default'];
		$arr_type[$recSelectFile['temp_id']]['file_name_new']		= $recSelectFile['file_name_new'];
	} 
	$cut_no = 1;
	foreach($arr_type as $temp_id=>$valfile){
		$div_e = '';
		if($cut_no==2){
			$div_s = '<div class="row">';
			$div_e = '</div>';
			$cut_no = 1;
		}else{
			echo '<div class="row">';
		}
		if($valfile['file_type'][0]=='video'){
		?>
			<div class="col-sm-6">
				<div class="col-sm-12">
					<label class="col-form-label" align="right"><?php echo $valfile['file_name_default'];?></label>
				</div>
				<div class="col-sm-12" align="center">
					<video width="420" controls>
					  <source src="<?php echo $part;?>file_uplode/<?php echo $valfile['file_name_new'];?>" type="<?php echo ($valfile['file_type'][0].'/'.$valfile['file_type'][1]);?>">
					</video>
				</div>
			</div>
		<?php
			echo $div_e;
		}else if($valfile['file_type'][0]=='image'){
		?>
			<div class="col-sm-6">
				<div class="col-sm-12">
					<label class="col-form-label" align="right"><?php echo $valfile['file_name_default'];?></label>
				</div>
				<div class="col-sm-12" align="center">
					<img id="img_show" src="<?php echo $part;?>file_uplode/<?=$valfile['file_name_new'];?>" width="420">
				</div>
			</div>
		<?php
			echo $div_e;
		}else{
		?>
			<a href="<?php echo $part;?>file_uplode/<?=$valfile['file_name_new'];?>"><?php echo $valfile['file_name_default'];?></a>
		<?php	
		}
		$cut_no++;
	}
?>