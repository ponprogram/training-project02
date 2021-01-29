<?php
	$Show_Header = 1;
	$part = "../../";
	include ($part."include/include.php"); 
	
	$arr_type = array();
	// $sqlSelectFile = "SELECT temp_id,file_name_default,file_name_new,file_type FROM file_uplode WHERE temp_code = 'E7yXK8pc2m3R7TQFB4NsUN30GNRey2JsjhpjfRRD7j9tpqkzA7091020102412'";
	if($_GET['tab_id']!=''){
		$whFile = "AND (temp_code = '".$_GET['temp_code']."') OR (tab_id='".$_GET['tab_id']."' AND tab_name = '".$_GET['tab_name']."')";
	}else{
		$whFile = "AND temp_code = '".$_GET['temp_code']."'";
	}
	$sqlSelectFile = "SELECT temp_id,file_name_default,file_name_new,file_type FROM file_uplode WHERE 1=1 {$whFile}";
	$querySelectFile = $db->query($sqlSelectFile);
	while($recSelectFile = $db->db_fetch_array($querySelectFile)){
		$arr_type[$recSelectFile['temp_id']]['file_type'] 			= explode('/',$recSelectFile['file_type']);
		$arr_type[$recSelectFile['temp_id']]['file_name_default'] 	= $recSelectFile['file_name_default'];
		$arr_type[$recSelectFile['temp_id']]['file_name_new']		= $recSelectFile['file_name_new'];
	} 
 ?>
<form id="frm_uplode_file" action="" method="post" enctype='multipart/form-data'>
	<input type="hidden" id="temp_code" name="temp_code" value="<?=$_GET['temp_code'];?>">
	<input type="hidden" id="tab_id" name="tab_id" value="<?=$_GET['tab_id'];?>">
	<input type="hidden" id="tab_name" name="tab_name" value="<?=$_GET['tab_name'];?>">
	<input type="hidden" id="temp_proc" name="temp_proc" value="">
	<input type="hidden" id="temp_id"   name="temp_id"   value="">
	<div class="row">
		<div class="col-md-6">
			<div class="row">
				<label class="col-sm-3" align="right">รูปหรือวิดิโอ : </label>
				<div class="col-sm-9">
					<input type="file" name="file_upload[]" id="file_upload" class="custom-file-input" multiple>
					<label class="custom-file-label" for="file_upload" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" ></label>
				</div>
			</div> 
			<br>
			<!-- <div class="row">
				<label class="col-sm-3" align="right"></label>
				<div class="col-sm-9">
					<button class="btn btn-gradient-success btn-fw" type="button" onclick="save_file();">Uplode</button>
					<button class="btn btn-gradient-warning  btn-fw" type="button" onclick="location.reload(true)">Reset</button>
				</div>
				
			</div> -->
		</div>
	</div>
	<?php
		$cut_no = 1;
		foreach($arr_type as $temp_id=>$valfile){
			$div_e = '';
			if($cut_no==2){
				$div_s = '<div class="row">';
				$div_e = '</div>';
				$cut_no = 0;
			}else{
				echo '<div class="row">';
			}
			if($valfile['file_type'][0]=='video'){
			?>
				<div class="col-sm-6">
					<div class="col-sm-12">
						<button type="button" class="btn btn-danger btn-sm" onclick="del_file('<?php echo $temp_id;?>');">Delete</button>
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
						<button type="button" class="btn btn-danger btn-sm" onclick="del_file('<?php echo $temp_id;?>');">Delete</button>
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
				<div class="col-sm-6">
				<button type="button" class="btn btn-danger btn-sm" onclick="del_file('<?php echo $temp_id;?>');">Delete</button>
				<a href="<?php echo $part;?>file_uplode/<?=$valfile['file_name_new'];?>"><?php echo $valfile['file_name_default'];?></a>
				</div>
			<?php	
			}
			$cut_no++;
		}
	
	?>
</form>
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
<script>
$("#file_upload").on("change",function(){
    var _files = $(this)[0].files;
    var _listFileName = "";
    if(_files.length>0){
        var _fileName = [];
        $.each(_files,function(k,v){
            _fileName[k] = v.name;
        });
        _listFileName = _fileName.join(",");
    }
    $(this).next("label").text(_listFileName);
    if(_listFileName != ''){
        save_file(); 
    }
});
function save_file(){
	$('#temp_proc').val('add');
	$('#frm_uplode_file').attr('action','../all/uplode_file_proc.php').submit();
}
function del_file(temp_id){
	$('#temp_proc').val('del');
	$('#temp_id').val(temp_id);
	$('#frm_uplode_file').attr('action','../all/uplode_file_proc.php').submit();
}
</script>