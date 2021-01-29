<?php
  $Show_Header = '';
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = 'แก้ไขข้อมูล';
  $_POST['proc'] = 'edit';
  $sql_main = "SELECT * FROM profile WHERE per_id = '".$_SESSION['PER_ID']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  $img_per = $rec_main['img'];
  $com_arr = get_company('1');
  $dep_arr = get_department('1',$rec_main['com_id']);
  $pos_arr = get_position('1',$rec_main['com_id'],$rec_main['dep_id']);
  $perfix_arr = get_perfix();
  $lavel_arr = array('0'=>'ผู้ดูแลระบบ','1'=>'หัวหน้าแผนก','2'=>'ผู้ใช้งานทั่วไป');
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi mdi-account-circle icon-lg"></i> แก้ไขข้อมูลส่วนตัว </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$part;?>home.php">เมนูหลัก</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
      <div class="card">
        <div class="card-body">
        <form id="frm-input" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="editmain">
			<input type="hidden" id="per_id" name="per_id" value="<?=$_SESSION['PER_ID'];?>">
			<input type="hidden" id="url_back" name="url_back" value="../../home.php">
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
                  <label class="col-sm-3 col-form-label" align="right">E-Mail : </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control ClearData" id="email" name="email" value="<?=$rec_main['email'];?>">
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
                <div class="row">
                  <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label" align="right">Username <span style="color:red;" >*</span> : </label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control ClearData checkinput" id="username" name="username" value="<?=$rec_main['username'];?>"  checkinput-text="Username" readonly>
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
                  <?php include($part."pages/forms/test.php");?>
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

  <?php include "{$part}include/footer.php"; ?>  </div>
<script>    
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
                $("#frm-input").attr("action","<?php echo $part;?>pages/forms/process/profile_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
</script>  