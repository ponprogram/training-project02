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
  $sql_main = "SELECT
				*
				FROM
				maintenance_from mf
				JOIN maintenance m on m.mai_id=mf.mai_id	
				WHERE
				mf.frm_id = '".$_POST['frm_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);

  	$detail_type1 = '';
  	$detail_type2 = '';
  	$detail_type3 = '';

	if($rec_main['frm_type']==1){
		$detail_type1 = 'checked';
	}else if($rec_main['frm_type']==2){
		$detail_type2 = 'checked';
	}else if($rec_main['frm_type']==3){
		$detail_type3 = 'checked';
	}

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
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ระบบแจ้งซ่อม</a></li>
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
						<div class="row file_detail_uplode">
							<?php include('../all/file_detail_uplode.php');?>
						</div>
					</div>
				</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<a href="#" onclick="growDiv('file_detail_assign','detail_assign')"><h4 class="card-title"> มอบหมายงาน </h4></a>
					</div>
					<hr>
					<div id="detail_assign" class="grow col-md-12">
						<div class="row file_detail_assign">
							<?php include('../all/file_detail_assign.php');?>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h4 class="card-title"> แจ้งผลดำเนินการ </h4>
                    </div>
                    <hr>
                    <form id="frm-input" action="" method="post" enctype='multipart/form-data'>
                        <input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
                        <input type="hidden" id="mai_id" name="mai_id" value="<?=$_POST['mai_id'];?>">
                        <input type="hidden" id="frm_id" name="frm_id" value="<?=$_POST['frm_id'];?>">
                        <input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
                        <input type="hidden" id="temp_code" name="temp_code" value="<?=$temp_code;?>">
                        <input type="hidden" id="next_step" name="next_step" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="text-align:right">อาการตามจริง <span style="color:red;" >*</span> : </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control ClearData checkinput" id="DETAIL" name="DETAIL" rows="5" checkinput-text="อาการตามจริง"><?php echo $rec_main['frm_detail'];?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="text-align:right">ระยะเวลาการดำเนินการ <span style="color:red;" >*</span> : </label>
                                    <div class="col-sm-2" style="text-align:left;">
                                        <input type="text" class="form-control checkinput" id="hour_work" name="hour_work" value="<?php echo $rec_main['frm_hour'];?>" checkinput-text="ระยะเวลาการดำเนินการ">
                                    </div>
                                    <div class="col-sm-2">
                                        ชั่วโมง
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="text-align:right" style=" vertical-align: middle;">ลักษณะอาการ : </label>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-success">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="detail_type1" 	 name="detail_type" value="1" onClick="coloricon(this.id);" <?php echo $detail_type1;?>>  
                                                อายุการใช้งาน <i class="input-helper"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-warning">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="detail_type2"   name="detail_type" value="2" onClick="coloricon(this.id);" <?php echo $detail_type2;?>> 
                                                การใช้งานผิดลักษณะ <i class="input-helper"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-danger">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" id="detail_type3"   name="detail_type" value="3" onClick="coloricon(this.id);" <?php echo $detail_type3;?>> 
                                                ดัดแปลงอุปกรณ์ <i class="input-helper"></i>
                                            </label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="text-align:right">อะไหลที่ใช้ : </label>
                                    <div class="col-sm-8">
                                        <button type="button" class="btn btn-gradient-success btn-rounded btn-fw" onClick="add_temp();"><i class="mdi mdi-import"></i> เพิ่มอะไหล</button>
                                        </p>
                                        <table class="table .table-hover table-bordered" id="equ_temp_id">
                                            <thead>
                                                <tr class="table-info">
                                                    <th width='10%' style="text-align: center;">ลำดับ</th>
                                                    <th width='60%' style="text-align: center;">ชื่ออะไหล</th>
                                                    <th width='20%' style="text-align: center;">จำนวน</th>
                                                    <th width='10%' style="text-align: center;">จัดการ</th>
                                                </tr>               
                                            <tbody>
                                            <?php
                                                $i=0;
                                                $num_temp = $db->db_num_rows($query_temp);
                                                if($num_temp>0){
                                                    $i=1;
                                                    while($rec_temp = $db->db_fetch_array($query_temp)){ ?>
                                                        <tr id="tr_<?=$i;?>" on-count="<?=$i;?>">
                                                            <td style="text-align: center;"><?=$i;?></td>
                                                            <td style="text-align: center;">
                                                                <select class="form-control select2" id="equ_id_<?=$_POST['on'];?>" name="equ_id[]">
                                                                    <option value="">---เลือก---</option>
                                                                    <?php
                                                                        foreach($equ_arr as $key_equ=>$val_equ){ ?>
                                                                            <option value="<?=$key_equ;?>" <?php echo ($key_equ==$rec_temp['equ_id'])?'selected':'';?> ><?=$val_equ;?></option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <input type="text" class="form-control" id="equ_sum_<?=$_POST['on'];?>" name="equ_sum[]" value="<?php echo $rec_temp['equ_sum'];?>">
                                                            </td>
                                                            <td style="text-align: center;"><button type="button" class="btn btn-gradient-danger  btn-md" onClick="remove('<?=$i;?>');"><i class="mdi mdi-delete icon-lg"></i> ลบ</button></td>
                                                        </tr>
                                            <?php
                                                    $i++;
                                                    }
                                                }else{
                                            ?>
                                                <tr id="notdata">
                                                    <td style="text-align: center;" colspan="4">ไม่พบข้อมูล</td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="equ_on" name="equ_on" value="<?=$i;?>">
                                    </div>
                        
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-12" style="text-align:center">
                                <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
                                <button type="button" class="btn btn-outline-info btn-fw" style="margin-bottom:5px;" onClick="submit_chk(1);"><i class="mdi mdi-content-save"></i> บันทึกและส่ง</button>
                                <button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
  <?php include "{$part}include/footer.php"; ?>
</div>
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
function submit_chk(type){
  var sum = 0;
  var ifsum = 0;
  $('.checkinput').each(function(){
      sum++;
  });
  $('.checkinput').each(function(){
    var text = $(this).attr('checkinput-text');
    if(type!=1){
        $("#frm-input").attr("action","process/flow_proc.php").submit();
    }else{
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
                    if(type==1){
                        $('#next_step').val('Y');
                    }
                    $("#frm-input").attr("action","process/flow_proc.php").submit();
                }
            });
        }
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
		$('#equ_temp_id').append(msg);
		// $('tbody').append(msg);
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