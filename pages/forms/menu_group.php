<?php
  $part = "../../";
  include ($part."include/include.php"); 
  $page_name = 'ตั้งค่าสิทธิ์การใช้งาน';

//   $sql_main = "SELECT * FROM lavel_user WHERE lavel_id = '".$_POST['lavel_id']."'";
//   $query_main = $db->query($sql_main);
//   $rec_main = $db->db_fetch_array($query_main);
  
//   $com_arr = get_company('1');
//   $dep_arr = get_department('1');
//   $pos_arr = get_position('1');
//   $perfix_arr = get_perfix();
//   $lavel_arr = array('0'=>'ผู้ดูแลระบบ','1'=>'หัวหน้าแผนก','2'=>'ผู้ใช้งานทั่วไป');
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <div class="page-header">
        <h1><i class="mdi mdi-settings icon-lg"></i> ตั้งค่าระดับผู้ใช้งาน </h1>
      </div> 
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?=$_POST['url_back'];?>">ตั้งค่าสิทธิ์การใช้งาน</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?=$page_name;?></li>
        </ol>
      </nav>
    </div>
        <form id="frm-input" action="" method="post">
			<input type="hidden" id="proc" name="proc" value="<?=$_POST['proc'];?>">
			<input type="hidden" id="lavel_id" name="lavel_id" value="<?=$_POST['lavel_id'];?>">
			<input type="hidden" id="url_back" name="url_back" value="<?=$_POST['url_back'];?>">
			<div class="row">
				<div class="col-lg-12 grid-margin stretch-card">
					<div class="card">
						<div class="card-body" align="center">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        <th width="70%" style="text-align:center;"> ชื่อเมนู </th>
                                        <th width="10%" style="text-align:center;"> ใช้งาน/เพิ่ม </th>
                                        <th width="10%" style="text-align:center;"> แก้ไข </th>
                                        <th width="10%" style="text-align:center;"> ลบ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql_manu_main = "  SELECT
                                                            ms.manu_id,
                                                            ms.manu_name,
                                                            msg.add_status
                                                        FROM
                                                            manu_setting ms
                                                        LEFT JOIN
                                                        manu_set_groub msg ON msg.manu_id = ms.manu_id AND msg.lavel_id = '{$_POST['lavel_id']}'
                                                        WHERE
                                                            ms.manu_lavel = '1' 
                                                        ORDER BY
                                                            ms.manu_order ASC";
                                    $query_manu_main = $db->query($sql_manu_main);
                                    while($rec_manu_main = $db->db_fetch_array($query_manu_main)){
                                        $addmainchk = "";
                                        if($rec_manu_main['add_status']==1){
                                            $addmainchk = "checked";
                                         }
                                        $add_main = "";
                                        $add_main = "<input type=\"checkbox\" id=\"add_".$rec_manu_sub['manu_id']."\" value=\"1\" name=\"add[".$rec_manu_main['manu_id']."]\" class=\"form-check-input\" ".$addmainchk."><i class=\"input-helper\">";
                                ?>
                                    <tr class="table-success">
                                        <td><?php echo $rec_manu_main['manu_name'];?></td>
                                        <td align="center"><?php echo $add_main;?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                        $sql_manu_sub = "   SELECT
                                                                ms.manu_id,
                                                                ms.manu_name,
                                                                ms.manu_parent_id,
                                                                msg.add_status,
                                                                msg.edit_status,
                                                                msg.del_status
                                                            FROM
                                                                manu_setting ms
                                                            LEFT JOIN
                                                                manu_set_groub msg ON msg.manu_id = ms.manu_id AND msg.lavel_id = '{$_POST['lavel_id']}'
                                                            WHERE
                                                                ms.manu_lavel > '1' 
                                                                AND ms.manu_parent_id = '{$rec_manu_main['manu_id']}' 
                                                            ORDER BY
                                                                ms.manu_order ASC";
                                        $query_manu_sub = $db->query($sql_manu_sub);
                                        while($rec_manu_sub = $db->db_fetch_array($query_manu_sub)){
                                            $add    = "";
                                            $edit   = "";
                                            $del    = "";
                                            $addchk    = "";
                                            $editchk   = "";
                                            $delchk    = "";
                                            
                                            if($rec_manu_sub['add_status']==1){
                                               $addchk = "checked";
                                            }
                                            if($rec_manu_sub['edit_status']==1){
                                               $editchk = "checked";
                                            }
                                            if($rec_manu_sub['del_status']==1){
                                               $delchk = "checked";
                                            }


                                            $add    = "<input type=\"checkbox\" id=\"add_".$rec_manu_sub['manu_id']."\" value=\"1\" name=\"add[".$rec_manu_sub['manu_id']."]\" class=\"form-check-input\" ".$addchk."><i class=\"input-helper\">";
                                            if($rec_manu_sub['manu_parent_id']==31){
                                                $edit   = "<input type=\"checkbox\" value=\"1\" id=\"edit_".$rec_manu_sub['manu_id']."\" name=\"edit[".$rec_manu_sub['manu_id']."]\" class=\"form-check-input\" ".$editchk."><i class=\"input-helper\">";
                                                $del    = "<input type=\"checkbox\" value=\"1\" id=\"del_".$rec_manu_sub['manu_id']."\" name=\"del[".$rec_manu_sub['manu_id']."]\" class=\"form-check-input\" ".$delchk."><i class=\"input-helper\">";
                                            }   
                                    ?>
                                        <tr>
                                            <td style="padding-left: 38px;"><?php echo $rec_manu_sub['manu_name'];?></td>
                                            <td align="center"><?php echo $add;?></td>
                                            <td style="text-align:center;"><?php echo $edit;?></td>
                                            <td style="text-align:center;"><?php echo $del;?></td>
                                        </tr>
                                    <?php
                                            $add    = "";
                                            $edit   = "";
                                            $del    = "";
                                        }
                                        $add_main = "";
                                        $addmainchk = "";
                                    }
                                ?>
                                </tbody>
                            </table>
                            <br>
                            <button type="button" class="btn btn-outline-success btn-fw" style="margin-bottom:5px;" onClick="submit_chk();"><i class="mdi mdi-content-save"></i> บันทึก</button>
                            <button type="button" class="btn btn-outline-danger btn-fw" style="margin-bottom:5px;" onclick="ClearData();"><i class="mdi mdi-cached btn-icon-prepend"></i>ยกเลิก</button>
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
            $("#frm-input").attr("action","process/lavel_proc.php").submit();
        }
    });
}
function ClearData(){
	location.reload();
}
</script>  