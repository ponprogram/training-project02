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
  
  
  $tab_id 	= $_POST['mai_id'];
  $tab_name = "maintenance";

	if($_SESSION['PER_LAVEL']!=1 && $rec_main['dep_id']==''){
		$rec_main['com_id']	=	$_SESSION['COM_ID'];
		echo "	<script>
					$(function(){
						search_option('COM_ID','DEP_ID','','dep','---เลือก---');
					});
				</script>";
		
	}
  
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
			<input type="hidden" id="flow_type" name="flow_type" value="<?=$_GET['form_folw'];?>">
			<input type="hidden" id="next_step" name="next_step" value="">
			<div class="col-md-12">
				<div class="form-group row">
					<div class="col-md-12" align="center">
					<button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
					<button type="button" class="btn btn-outline-info btn-fw" style="margin-bottom:5px;" onClick="submit_chk(1);"><i class="mdi mdi-content-save"></i> บันทึกและส่ง</button>
					<button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<!--<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label class="col-sm-3 col-form-label" align="right">วันที่บันทึก : </label>
								<div class="col-sm-9">
									<input type="text" class="form-control ClearData " id="Fname" name="Fname" value="">
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
								<div class="input-append date" id="dp3" data-date="12-02-2012" data-date-format="dd-mm-yyyy">
									<input class="datepicker" size="16" type="text" value="12-02-2012">
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
							</div>
						</div>
					</div>-->
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
							  <label class="col-sm-3 col-form-label" align="right">สถานที่ <span style="color:red;" >*</span> : </label>
							  <div class="col-sm-9">
								<select class="form-control select2 ClearData checkinput" id="COM_ID" name="COM_ID" onchange="search_option('COM_ID','DEP_ID','','dep','---เลือก---');" checkinput-text="สถานที่">
								  <option value="">---เลือก---</option>
								  <?php
									foreach($com_arr as $key_com=>$val_com){ ?>
									  <option value="<?=$key_com;?>" <?=($key_com==$rec_main['com_id'])?'selected':'';?>><?=$val_com?></option>
								  <?php
									}
								  ?>
								</select>
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
					  <div class="col-md-12">
					  <div class="form-group row">
						  <label class="col-sm-3 col-form-label" align="right">พื้นที่ <span style="color:red;" >*</span> : </label>
						  <div class="col-sm-9">
							<select class="form-control select2 ClearData checkinput" id="DEP_ID" name="DEP_ID" onchange="search_option('COM_ID','DEP_ID','','get_machinery','---เลือก---','MAC_ID');" checkinput-text="พื้นที่">
								<option value="">---เลือก---</option>
								<?php
									foreach($dep_arr as $key_dep=>$val_dep){ ?>
										<option value="<?=$key_dep;?>" <?=($key_dep==$rec_main['dep_id'])?'selected':'';?>><?=$val_dep;?></option>
								<?php
								}
							  ?>
							</select>
						  </div>
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-12">
					  <div class="form-group row">
						  <label class="col-sm-3 col-form-label" align="right">รหัสเครื่องจักร <span style="color:red;" >*</span> : </label>
						  <div class="col-sm-9">
							<select class="form-control select2 ClearData checkinput" id="MAC_ID" name="MAC_ID" onchange="get_machineryIMG('COM_ID','DEP_ID','MAC_ID','img_show','<?=$part;?>');" checkinput-text="รหัสเครื่องจักร">
								<option value="">---เลือก---</option>
								<?php
									foreach($dep_machinery as $key_mac=>$val_mac){ ?>
										<option value="<?=$key_mac;?>" <?=($key_mac==$rec_main['mac_id'])?'selected':'';?>><?=$val_mac;?></option>
								<?php
								}
							  ?>
							</select>
						  </div>
						</div>
					  </div>
					</div> 
					<div class="row">
					  <div class="col-md-12">
						<div class="form-group row">
						  <label class="col-sm-3 col-form-label" align="right">อาการ <span style="color:red;" >*</span> : </label>
						  <div class="col-sm-9">
							<textarea class="form-control ClearData checkinput " id="DETAIL" name="DETAIL" rows="5" checkinput-text="อาการ"><?=$rec_main['mai_detail'];?></textarea>
						  </div>
						</div>
					  </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
							  <label class="col-sm-3 col-form-label" align="right" style=" vertical-align: middle;">ระดับความรุนแรง : </label>
								<div class="col-sm-3">
									<div class="form-check form-check-success">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" id="severity_low" 	  color-icon="green"	name="severity" value="L" onClick="coloricon(this.id);" <?php echo ($rec_main['severity']=='L')?'checked':'';?>>  
											Low <i class="input-helper"></i>
										</label>
									</div>
									<div class="form-check form-check-warning">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" id="severity_medium" color-icon="yellow"	name="severity" value="M" onClick="coloricon(this.id);"<?php echo ($rec_main['severity']=='M')?'checked':'';?>> 
											Medium <i class="input-helper"></i>
										</label>
									</div>
									<div class="form-check form-check-danger">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" id="severity_high"   color-icon="red"	name="severity" value="H" onClick="coloricon(this.id);"<?php echo ($rec_main['severity']=='H')?'checked':'';?>> 
											High <i class="input-helper"></i>
										</label>
									</div>
								</div> 
								<div class="col-sm-3" style="background-color: #D2CCCC;" align="center">
									<i id="severity_icon" style="font-size:110px; color: #FFFFFF;" class="mdi mdi-security icon-lg"></i> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-sm-12 col-form-label" align="center"><h1>รูปเครื่องจักร </h1></label>
					<div class="col-md-12" align="center">
						<img id="img_show" src="../../file_uplode/no-image.a4eb045.jpg" width="500">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<iframe width="100%" class="col-md-12 iframereload" id="uplode_file_form"  src="../all/uplode_file_form.php?temp_code=<?=$temp_code;?>&tab_name=<?=$tab_name;?>&tab_id=<?=$tab_id;?>" style="height:1200px; width:100%; border:none;""></iframe>
				</div>
			</div>
            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12" align="center">
                  <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
				  <button type="button" class="btn btn-outline-info btn-fw" style="margin-bottom:5px;" onClick="submit_chk(1);"><i class="mdi mdi-content-save"></i> บันทึกและส่ง</button>
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
function submit_chk(type){
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
                if(type==1){
                    $('#next_step').val('Y');
                }
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