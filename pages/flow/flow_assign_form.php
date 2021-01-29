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
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  $temp_code = (random(50)).date('dmyhis');
  $sql_main = "SELECT * FROM maintenance WHERE mai_id = '".$_POST['mai_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);

  $com_arr = get_company('1');
  $dep_arr = get_department('1');
  $dep_machinery = get_machinery('1');
  $per_arr = array();
  $sql_per = "SELECT
                per.per_id,
                CONCAT( pf.perfix_name_th, per.f_name, ' ', per.l_name ) AS fullname 
              FROM
                profile per
                LEFT JOIN perfix pf ON pf.perfix_id = per.perfix_id 
              WHERE
                1 = 1 
                AND per.per_lavel = '3' 
              ORDER BY
                per.per_id ASC";
  $query_per = $db->query($sql_per);
  while($rec_per = $db->db_fetch_array($query_per)){
      $per_arr[trim($rec_per['per_id'])] = $rec_per['fullname'];
  }
  
  $tab_id 	= $_POST['mai_id'];
  $tab_name = "maintenance";
  
  // $com_arr = get_company('1');
  // $dep_arr = get_department('1',$rec_main['com_id']);
  // $dep_machinery = get_machinery('1',$rec_main['com_id'],$rec_main['dep_id']);
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><?=$ManuHeader;?></h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ระบบแจ้งซ่อม</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
      <div class="card">
        <div class="card-body">
        <form id="frm-input" action="" method="post" enctype='multipart/form-data'>
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="mai_id" name="mai_id" value="<?=$_POST['mai_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
			<input type="hidden" id="temp_code" name="temp_code" value="<?=$temp_code;?>">
			<div class="col-md-12">
				<h4 class="card-title"> รายละเอียด </h4>
			</div>
			<hr>
			<div class="row">
				<?php include('../all/file_detail_main.php');?>
			</div>
			
			<div class="col-md-12">
				<h4 class="card-title"> รูปหรือวิดิโอ </h4>
			</div>
			<hr>
			<div class="row">
				<?php include('../all/file_detail_uplode.php');?>
			</div>
			
			<div class="col-md-12">
				<h4 class="card-title"> มอบหมายงาน </h4>
			</div>
			<hr>
			<div class="col-md-12">
				<div class="form-group row" >
					<div class="col-sm-4 col-md-2" align="right">
						<label class="col-form-label">ผู้ซ่อม <span style="color:red;" >*</span> :</label>
					</div>
					<div class="col-sm-6 col-md-6">
						<select class="form-control select2 ClearData checkinput" id="per_id" name="per_id" checkinput-text="ผู้ซ่อม">
							<option value="">---เลือกผู้ซ่อม---</option>
							<?php
							foreach($per_arr as $key_per=>$val_per){ ?>
							<option value="<?=$key_per;?>"><?=$val_per;?></option>
							<?php
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row" >
					<div class="col-sm-4 col-md-2" align="right">
						<label class="col-form-label">ภายในกี่วัน <span style="color:red;" >*</span> :</label>
					</div>
					<div class="col-sm-2 col-md-2">
						<input type="text" class="form-control ClearData checkinput" id="limid_date" name="limid_date" value="" checkinput-text="ภายในกี่วัน">
					</div>
					<div class="col-sm-4 col-md-1">
						<label class="col-form-label">วัน</label>
					</div>
					<!-- <div class="col-sm-4 col-md-2">
                        <div class="form-check form-check-success">
                            <label class="form-check-label">
                            <input type="checkbox" name="outsource" class="form-check-input" value="Y"> Outsource <i class="input-helper"></i></label>
                        </div>
					</div> -->
				</div>
				<div class="form-group row" >
					<div class="col-sm-4 col-md-2" align="right">
					</div>
					<div class="col-sm-2 col-md-6">
            <table class="table table-striped table-bordered">
              <thead>
                  <tr class="table-info">
                      <th width="5%" style="text-align: center;"> ลำดับ </th>
                      <th width="10%" style="text-align: center;"> รายชื่อช่าง </th>
                      <th width="10%" style="text-align: center;"><?=get_severityimg('');?></th>
                      <th width="10%" style="text-align: center;"><?=get_severityimg('L');?></th>
                      <th width="10%" style="text-align: center;"><?=get_severityimg('M');?></th>
                      <th width="10%" style="text-align: center;"><?=get_severityimg('H');?></th>
                      <th width="10%" style="text-align: center;">รวม</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  $sql_sub = "SELECT
                                per.per_id,
                                CONCAT( pf.perfix_name_th, per.f_name, ' ', per.l_name ) AS fullname,
                                (SELECT COUNT(*) FROM maintenance_from mf JOIN maintenance m ON m.mai_id = mf.mai_id WHERE mf.frm_status = 'N' AND mf.per_id = per.per_id AND m.severity = 'L') AS numL,
                                (SELECT COUNT(*) FROM maintenance_from mf JOIN maintenance m ON m.mai_id = mf.mai_id WHERE mf.frm_status = 'N' AND mf.per_id = per.per_id AND m.severity = 'M') AS numM,
                                (SELECT COUNT(*) FROM maintenance_from mf JOIN maintenance m ON m.mai_id = mf.mai_id WHERE mf.frm_status = 'N' AND mf.per_id = per.per_id AND m.severity = 'H') AS numH,
                                (SELECT COUNT(*) FROM maintenance_from mf JOIN maintenance m ON m.mai_id = mf.mai_id WHERE mf.frm_status = 'N' AND mf.per_id = per.per_id AND m.severity = '')  AS numN
                              FROM
                                profile per
                                LEFT JOIN perfix pf ON pf.perfix_id = per.perfix_id 
                              WHERE
                                1 = 1 
                                AND per.per_lavel = '3' 
                              ORDER BY
                                per.per_id ASC";
                  $query_sub = $db->query($sql_sub);
                  if($db->db_num_rows($query_sub)){
                    $no = $s_page+1;
                    while($rec_sub = $db->db_fetch_array($query_sub)){
                      ?>
                      <tr>
                          <td style="text-align: center;"><?=$no;?></td>
                          <td style="text-align: left;"><?=$rec_sub['fullname'];?></td>
                          <td style="text-align: center;"><?=($rec_sub['numN']>0)?$rec_sub['numN']:'-';?></td>
                          <td style="text-align: center;"><?=($rec_sub['numL']>0)?$rec_sub['numL']:'-';?></td>
                          <td style="text-align: center;"><?=($rec_sub['numM']>0)?$rec_sub['numM']:'-';?></td>
                          <td style="text-align: center;"><?=($rec_sub['numH']>0)?$rec_sub['numH']:'-';?></td>
                          <td style="text-align: center;"><?=$rec_sub['numN']+$rec_sub['numL']+$rec_sub['numM']+$rec_sub['numH'];?></td>
                      </tr>
                      <?php
                        $no++;
                    }
                  }
                  ?>
              </tbody>
              </table>
						
					</div>
				</div>
			</div>
            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12" align="center">
                  <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
                  <button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
  <?php include "{$part}include/footer.php"; ?>
<script>
$(document).ready(function() { 
	$( "#minimize" ).trigger( "click" ); //ย่อ
}); 
$(function(){
	var color = $('[id^=severity_]:checked').attr('color-icon');
	if(color!=''){
		document.getElementById("severity_icon").style.color = color;
	}
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
                $("#frm-input").attr("action","process/flow_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
function coloricon(ID){
	var color = $('#'+ID).attr('color-icon');
	
	document.getElementById("severity_icon").style.color = color;
}

</script>