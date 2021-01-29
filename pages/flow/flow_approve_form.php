<?php
  $part = "../../";
  include ($part."include/include.php"); 
	//manu header
	if($_GET['step_flow']!=''){
	$ManuSub = " <i class=\"mdi mdi-hand-pointing-right icon-lg\"></i> ".$arr_manu_sub[$_GET['step_flow']]."";
	}
	$ManuHeader = "<i class=\"mdi mdi-settings icon-lg\"></i> ".$arr_manu_main[$_GET['form_folw']].$ManuSub;
	//manu header
	$Link = "?step_flow=".$_GET['step_flow']."&form_folw=".$_GET['form_folw'];
	if($_POST['proc']=='add'){
		$page_name = 'เพิ่มข้อมูล';
	}elseif($_POST['proc']=='edit'){
		$page_name = 'แก้ไขข้อมูล';
	}else{
		$page_name = $arr_manu_sub[$_GET['step_flow']];
	}
  $temp_code = (random(50)).date('dmyhis');
  $sql_main = "SELECT * FROM maintenance WHERE mai_id = '".$_POST['mai_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);

// # อุปกรณ์ที่เบิก # //
  $sql_temp = "SELECT temp_id,equ_id,mai_id,equ_sum FROM equipment_temp WHERE mai_id = '".$_POST['mai_id']."'";
  $query_temp = $db->query($sql_temp);
// # อุปกรณ์ที่เบิก # // 

// # array อุปกรณ์ที่เบิก # //
  $equ_arr = array();

  $sql_equ = "SELECT equ_id,equ_name FROM equipment GROUP BY equ_id,equ_name";
  $query_equ = $db->query($sql_equ);
  while($rec_equ = $db->db_fetch_array($query_equ)){
	  $equ_arr[trim($rec_equ['equ_id'])] = $rec_equ['equ_name'];
  }
// # array อุปกรณ์ที่เบิก # //


  $com_arr = get_company('1');
  $dep_arr = get_department('1');
  $dep_machinery = get_machinery('1');
  $per_arr = get_per('1');
  
  
  $tab_id 	= $_POST['mai_id'];
  $tab_name = "maintenance";
  
  // $com_arr = get_company('1');
  // $dep_arr = get_department('1',$rec_main['com_id']);
  // $dep_machinery = get_machinery('1',$rec_main['com_id'],$rec_main['dep_id']);
?>
<style>

	#grow input:checked {
	color: red;
	}

	.grow {
	-moz-transition: height .5s;
	-ms-transition: height .5s;
	-o-transition: height .5s;
	-webkit-transition: height .5s;
	transition: height .5s;
	height: 0;
	overflow: hidden;
	}
</style>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><?=$ManuHeader;?></h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $_POST['url_back'];?>">ระบบแจ้งซ่อม</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
	<div class="card">
		<div class="card-body">
            <div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<a href="#" onclick="growDiv('file_detail_main','detail_main')"><h4 class="card-title"> รายละเอียด </h4></a>
					</div>
					<hr>
					<div id="detail_main" class="grow col-md-12">
						<div class="row file_detail_main"> 
							<?php include('../all/file_detail_main.php');?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<a href="#" onclick="growDiv('file_detail_uplode','detail_uplode')"><h4 class="card-title"> รูปหรือวิดิโอ </h4></a>
					</div>
					<hr>
					<div id="detail_uplode" class="grow col-md-12">
						<div class="file_detail_uplode">
							<?php include('../all/file_detail_uplode.php');?>
						</div>
					</div>
				</div>
			</div>
			</div><br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<a href="#" onclick="growDiv('file_detail_assign','detail_assign')"><h4 class="card-title"> มอบหมายงาน </h4></a>
					</div>
					<hr>
					<div id="detail_assign" class="grow col-md-12">
						<div class="file_detail_assign">
							<?php include('../all/file_detail_assign.php');?>
						</div>
					</div>
				</div>
			</div><br>
			<?php
			if($_POST['proc']=='approve'){
			?>
			<div class="row">
			
				<div class="col-md-12">
					<div class="col-md-12">
						<a href="#" onclick="growDiv('file_detail_reply','detail_reply')"><h4 class="card-title"> แจ้งผลดำเนินการ </h4></a>
					</div>
					<hr>
					<div id="detail_reply" class="grow col-md-12">
						<div class="file_detail_reply">
							<?php include('../all/file_detail_reply.php');?>
						</div>
					</div>
                </div>
            </div>
			<?php
			}
			?>
			<br>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<h4 class="card-title"> อนุมัติ/ตรวจสอบ </h4>
					</div>
					<hr>
					<form id="frm-input" action="" method="post" enctype='multipart/form-data'>
						<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
						<input type="hidden" id="mai_id" name="mai_id" value="<?=$_POST['mai_id'];?>">
						<input type="hidden" id="frm_id" name="frm_id" value="<?=$_POST['frm_id'];?>">
						<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
						<input type="hidden" id="temp_code" name="temp_code" value="<?=$temp_code;?>">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
								<label class="col-sm-2 col-form-label" style="text-align:right" style=" vertical-align: middle;">ผลการตรวจสอบ <span style="color:red;" >*</span> : </label>
									<div class="col-sm-2">
										<div class="form-check form-check-success">
										<label class="form-check-label">
											<input type="radio" class="form-check-input" id="approve_status1" 	name="approve_status" value="Y" onClick="coloricon(this.id);">  
												ผ่าน <i class="input-helper"></i>
											</label>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-check form-check-warning">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" id="approve_status2"  name="approve_status" value="B" onClick="coloricon(this.id);"> 
												ไม่ผ่าน <i class="input-helper"></i>
											</label>
										</div>
									</div> 
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group row">
									<label class="col-sm-2 col-form-label" style="text-align:right">หมายเหตุ : </label>
									<div class="col-sm-5">
										<textarea class="form-control ClearData" id="remarks" name="remarks" rows="5"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group row">
								<div class="col-md-12" style="text-align:center">
								<button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
								<button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
								</div>
							</div>
						</div>
					</form> 
				</div>
			</div>
		</div>
	</div>
  <?php include "{$part}include/footer.php"; ?>
<script>
$(document).ready(function() { 
	$( "#minimize" ).trigger( "click" ); //ย่อ
}); 

function submit_chk(){
    var approve_status = $("input[id^='approve_status']:checked").val();
 
    if(approve_status=='B' && $('#remarks').val()==''){
        Swal.fire('กรุณาระบุหมายเหตุ','','warning');
    }else if(approve_status=='B' || approve_status=='Y' ){
        Swal.fire({
            title: 'ต้องการบันทึกข้อมูลใช่หรือไม่?',
            text: "",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#frm-input").attr("action","process/flow_proc.php").submit();
            }
        });
    }else{
        Swal.fire('กรุณาเลือกผลการตารวสอบ','','warning');
    }
}
function ClearData(){
	location.reload();
}
function growDiv(classname,idbtn) {
  var growDiv = document.getElementById(idbtn);
  if (growDiv.clientHeight) {
    growDiv.style.height = 0;
  } else {
    var wrapper = document.querySelector('.'+classname);
    growDiv.style.height = wrapper.clientHeight + "px";
  }
//   document.getElementById(idbtn).value = document.getElementById(idbtn).value == 'Read more' ? 'Read less' : 'Read more';
}
function add_temp(){
	var on_count = $('#equ_on').val();
	var on = parseInt(on_count)+1;
	url = "../all/get_html_equ.php";
	data = {on:on};
	$.post(url,data,function(msg){
		$('tbody').append(msg);
		$('#notdata').remove();
		$('#equ_on').val(on);
	});
}
function remove(on){
	var on_count = $('#equ_on').val();
	$('#tr_'+on).remove();
}
</script>

<!-- Red high = เครื่องจักรจอด
Yellow medium = เครื่องวิ่งได้ แต่งานเสียหาย
Green low = เครื่องวิ่งได้ งานไม่เสียหาย -->