<?php
  $Show_Header = '';
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM profile WHERE per_id = '".$_POST['per_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  $img_per = $rec_main['img'];
  $com_arr = get_company('1');
  $dep_arr = get_department('1',$rec_main['com_id']);
  $pos_arr = get_position('1',$rec_main['com_id'],$rec_main['dep_id']);
  $perfix_arr = get_perfix();
  $lavel_arr = get_lavel('1'); 
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-account-box icon-lg"></i> ข้อมูลบุคลากร </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ข้อมูลบุคลากร</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
      <div class="card">
        <div class="card-body">
        <form id="frm-input" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="per_id" name="per_id" value="<?=$_POST['per_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
          <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">คำนำหน้า <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="perfix_id" name="perfix_id"  checkinput-text="คำนำหน้า">
                      <option value="">---เลือก---</option>
                      <?php
                        foreach($perfix_arr as $key_fix=>$val_fix){ ?>
                          <option value="<?=$key_fix;?>" <?=($key_fix==$rec_main['perfix_id'])?'selected':'';?>><?=$val_fix?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">E-Mail : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData" id="email" name="email" value="<?=$rec_main['email'];?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ชื่อ <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="Fname" name="Fname" value="<?=$rec_main['f_name'];?>"  checkinput-text="ชื่อ">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">นามสกุล <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="Lname" name="Lname" value="<?=$rec_main['l_name'];?>"  checkinput-text="นามสกุล">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ที่อยู่ : </label>
                  <div class="col-sm-9">
                    <textarea class="form-control ClearData" id="address" name="address" rows="5"><?=$rec_main['address'];?></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">เบอร์โทร : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData" id="phone_number" name="phone_number" value="<?=$rec_main['phone_number'];?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">บริษัท <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="COM_ID" name="COM_ID" onchange="search_option('COM_ID','DEP_ID','POS_ID','dep','---เลือก---');"  checkinput-text="บริษัท">
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
                    <select class="form-control select2 ClearData checkinput" id="DEP_ID" name="DEP_ID" onchange="search_option('COM_ID','DEP_ID','POS_ID','pos','---เลือก---');"  checkinput-text="แผนก">
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
                  <label class="col-sm-3 col-form-label" align="right">ตำแหน่ง <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="POS_ID" name="POS_ID"  checkinput-text="ตำแหน่ง">
                      <option value="">---เลือก---</option>
                      <?php
                        foreach($pos_arr as $key_pos=>$val_pos){ ?>
                          <option value="<?=$key_pos;?>" <?=($key_pos==$rec_main['pos_id'])?'selected':'';?>><?=$val_pos;?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" align="right">ระดับผู้ใช้งาน <span style="color:red;" >*</span> : </label>
                  <div class="col-sm-9">
                    <select class="form-control select2 ClearData checkinput" id="per_lavel" name="per_lavel"  checkinput-text="ระดับผู้ใช้งาน">
                      <option value="">---เลือก---</option>
					  <?php
						foreach($lavel_arr as $key_lavel=>$val_lavel){ ?>
							<option value="<?=$key_lavel?>" <?=($key_lavel==$rec_main['per_lavel'])?'selected':'';?>><?=$val_lavel?></option>
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
					<div class="row">
					  <div class="col-md-12">
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
					  <div class="col-md-12">
						<div class="form-group row">
						  <label class="col-sm-3 col-form-label" align="right">Username <span style="color:red;" >*</span> : </label>
						  <div class="col-sm-9">
                            <?php
                                $textType = '';
                                if($_SESSION['PER_LAVEL']!=1){
                                    $textType = 'readonly';
                                }
                            ?>
							<input type="text" class="form-control ClearData checkinput" id="username" name="username" value="<?=$rec_main['username'];?>"  checkinput-text="Username" <?php echo $textType;?>>
						  </div>
						</div>
					  </div>
					</div>
					<div class="row">
					  <div class="col-md-12">
						<div class="form-group row">
						  <label class="col-sm-3 col-form-label" align="right">Password <span style="color:red;" >*</span> : </label>
						  <div class="col-sm-9">
							<input type="password" class="form-control ClearData checkinput" id="password" name="password" value="<?=base64_decode($rec_main['password']);?>"  checkinput-text="Password">
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<div class="col-md-1">
				</div>
				<div class="col-md-5">
					<div class="col-md-6">
						<?php include("test.php");?>
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
    </div>
  
  <?php include "{$part}include/footer.php"; ?></div>
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
                $("#frm-input").attr("action","process/profile_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
</script>  