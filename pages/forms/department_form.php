<?php
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM department WHERE dep_id = '".$_POST['dep_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  
  $com_arr = get_company('1');
  $dep_arr = get_department('1');
  $pos_arr = get_position('1');
  $perfix_arr = get_perfix();
  $lavel_arr = array('0'=>'ผู้ดูแลระบบ','1'=>'หัวหน้าพื้นที่','2'=>'ผู้ใช้งานทั่วไป');
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-settings icon-lg"></i> ตั้งค่าพื้นที่ </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ตั้งค่าพื้นที่</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
        <form id="frm-input" action="" method="post">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="dep_id" name="dep_id" value="<?=$_POST['dep_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" align="right">ชื่อพื้นที่ <span style="color:red;" >*</span> : </label>
										<div class="col-sm-7">
											<input type="text" class="form-control ClearData checkinput" id="dep_name" name="dep_name" value="<?=$rec_main['dep_name'];?>" checkinput-text="ชื่อพื้นที่">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label" align="right">สถานะการใช้งาน : </label>
										<div class="col-sm-2">
											<div class="form-check">
												<label class="form-check-label">
												<input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS1" value="1" <?=($rec_main['active_status']==1)?'checked':'';?>> ใช้งาน </label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-check">
												<label class="form-check-label">
												<input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS2" value="2" <?=($rec_main['active_status']==2)?'checked':'';?>> ไม่ใช้งาน </label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12" align="center">
								  <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
								  <button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
    </div>

  <?php include "{$part}include/footer.php"; ?>
  </div>
<script>
$(document).ready(function() { 
	$( "#minimize" ).trigger( "click" ); //ย่อ
});
function submit_chk(){
  var sum = 0;
  var ifsum = 0;
  $('.checkinput').each(function(){
      sum++;
  });
  $('.checkinput').each(function(){
    var text = $(this).attr('checkinput-text');
    if($(this).val()==''){
      Swal.fire('กรุณาระบุ'+text,'','warning');
      $(this).focus();
    }else{
      ifsum++;
    }
    if(sum==ifsum){
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
                $("#frm-input").attr("action","process/department_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
</script>  