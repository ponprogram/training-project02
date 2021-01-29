<?php
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = ($_POST['proc']=='add')?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
  
  $sql_main = "SELECT * FROM equipment WHERE equ_id = '".$_POST['equ_id']."'";
  $query_main = $db->query($sql_main);
  $rec_main = $db->db_fetch_array($query_main);
  $img_per = $rec_main['img'];
  $type_arr = array(
					"1"=>"อะไหล่ไฟฟ้า",
					"2"=>"สิ้นเปลืองไฟฟ้า",
					"3"=>"อะไหล่ เครื่องกล",
					"4"=>"สิ้นเปลือง เครื่องกล",
					"5"=>"อะไหล่ ลม",
					"6"=>"สิ้นเปลือง ลม"
				  );
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-calendar icon-lg"></i>  ตั้งค่าการแจ้งเตือน  </h1>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>"> ตั้งค่าการแจ้งเตือน </a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
      <div class="card">
        <div class="card-body">
        <form id="frm-input" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="equ_id" name="equ_id" value="<?=$_POST['equ_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" align="right">ชนิดอุปกรณ์ <span style="color:red;" >*</span> : </label>
                        <div class="col-sm-9">
                        <select class="form-control select2 ClearData checkinput" id="equ_type" name="equ_type" checkinput-text="ชนิดอุปกรณ์">
                            <option value="">---เลือก---</option>
                            <?php
                            foreach($type_arr as $key=>$val){ ?>
                                <option value="<?=$key;?>" <?=($key==$rec_main['equ_type'])?'selected':'';?>><?=$val;?></option>
                            <?php
                            }
                            ?>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" align="right">ชื่ออุปกรณ์ <span style="color:red;" >*</span> : </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control ClearData checkinput" id="equ_name" name="equ_name" value="<?=$rec_main['equ_name'];?>" checkinput-text="ชื่ออุปกรณ์">
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
                $("#frm-input").attr("action","process/equipment_proc.php").submit();
            }
        });
    }
  });
}
function ClearData(){
	location.reload();
}
</script>  