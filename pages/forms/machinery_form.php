<?php
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM machinery WHERE mac_id = '".$_POST['mac_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  $img_per = $rec_main['img'];
  $com_arr = get_company('1');
  $dep_arr = get_department('1',$rec_main['com_id']);
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-database icon-lg"></i> ทะเบียนเครื่องจักร </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ทะเบียนเครื่องจักร</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
      <div class="card">
        <div class="card-body">
        <form id="frm-input" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="mac_id" name="mac_id" value="<?=$_POST['mac_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">รหัสเครื่องจักร <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="mac_number" name="mac_number" value="<?=$rec_main['mac_number'];?>" checkinput-text="รหัสเครื่องจักร">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ชื่อเครื่องจักร <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="mac_name" name="mac_name" value="<?=$rec_main['mac_name'];?>" checkinput-text="ชื่อเครื่องจักร">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">รุ่น ตามผู้ขาย : </label>
                  <div class="col-sm-9">
					 <input type="text" class="form-control ClearData" id="mac_gen" name="mac_gen" value="<?=$rec_main['mac_gen'];?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ปีที่ซื้อ <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="mac_year" name="mac_year" value="<?=$rec_main['mac_year'];?>" checkinput-text="ปีที่ซื้อ">
                  </div>
                </div>
              </div>
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">วันที่ผลิต <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
					 <input type="text" class="form-control ClearData checkinput" id="mac_date" name="mac_date" value="<?=$rec_main['mac_date'];?>" checkinput-text="วันที่ผลิต">
                  </div>
                </div>
              </div>
			  <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">วันที่ซื้อ <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="date_shop" name="date_shop" value="<?=$rec_main['date_shop'];?>" checkinput-text="วันที่ซื้อ">
                  </div>
                </div>
              </div>
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">บริษัทผู้ผลิต : </label>
                  <div class="col-sm-9">
					 <input type="text" class="form-control ClearData" id="mac_com_main" name="mac_com_main" value="<?=$rec_main['mac_com_main'];?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ข้อกำหนด : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData" id="mac_comment" name="mac_comment" value="<?=$rec_main['mac_comment'];?>">
                  </div>
                </div>
              </div>
            </div>
			<div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ยี่ห้อเครื่องจักร : </label>
                  <div class="col-sm-9">
					 <input type="text" class="form-control ClearData" id="mac_brand" name="mac_brand" value="<?=$rec_main['mac_brand'];?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">บริษัท <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="COM_ID" name="COM_ID" onchange="search_option('COM_ID','DEP_ID','','dep','');" checkinput-text="บริษัท">
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
              <div class="col-md-6">
              <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">แผนก <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="DEP_ID" name="DEP_ID" checkinput-text="แผนก">
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
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">สถานะการใช้งาน : </label>
                  <div class="col-sm-4">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS1" value="1" checked> ใช้งาน </label>
                    </div>
                  </div>
                  <div class="col-sm-5">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="ACTVE_STATUS" id="ACTVE_STATUS2" value="2"> ไม่ใช้งาน </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-5">
					<div class="col-md-12" align="center">
						<?php include("test.php");?>
					</div>
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
                $("#frm-input").attr("action","process/machinery_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
</script>  