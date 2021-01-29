<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="<?=($_SESSION['IMG_PER']!='')?$part.'file_uplode/'.$_SESSION['IMG_PER']:$part.'assets/images/user.png';?>" alt="profile">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2"><?=$_SESSION['PER_NAME'];?></span>
                  <span class="text-secondary text-small"><?=$_SESSION['POS_NAME'];?></span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=$part;?>home.php">
                <span class="menu-title">เมนูหลัก</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <?php
                $sql_manu_main = "SELECT
                                    ms.manu_id,
                                    ms.manu_name,
                                    ms.manu_icon,
                                    ms.class_active,
                                    ms.manu_number
                                  FROM
                                    manu_setting ms
                                    JOIN manu_set_groub msg ON msg.manu_id = ms.manu_id
                                  WHERE
                                    ms.manu_lavel = '1' 
                                    AND msg.lavel_id = '{$_SESSION['PER_LAVEL']}'
                                  ORDER BY
                                    ms.manu_order ASC";
                $query_manu_main = $db->query($sql_manu_main);
                while($rec_manu_main = $db->db_fetch_array($query_manu_main)){
            ?>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-<?php echo $rec_manu_main['class_active'];?>" aria-expanded="false" aria-controls="general-<?php echo $rec_manu_main['class_active'];?>">
                <span class="menu-title"><?php echo ' [ '.$rec_manu_main['manu_number'].' ] '.$rec_manu_main['manu_name'];?></span>
                <i class="menu-arrow"></i>
                <i class="<?php echo $rec_manu_main['manu_icon'];?>"></i>
              </a>
              <div class="collapse" id="general-<?php echo $rec_manu_main['class_active'];?>">
                <ul class="nav flex-column sub-menu">
              <?php
                  $sql_manu_sub = "SELECT
                                    ms.manu_id,
                                    ms.manu_name,
                                    ms.manu_url,
                                    ms.manu_path,
                                    ms.manu_number
                                  FROM
                                    manu_setting ms
                                  JOIN
                                    manu_set_groub msg ON msg.manu_id = ms.manu_id
                                  WHERE
                                    ms.manu_lavel > '1' 
                                    AND ms.manu_parent_id = '{$rec_manu_main['manu_id']}' 
                                    AND msg.lavel_id = '{$_SESSION['PER_LAVEL']}'
                                  ORDER BY
                                    ms.manu_order ASC";
                  $query_manu_sub = $db->query($sql_manu_sub);
                  while($rec_manu_sub = $db->db_fetch_array($query_manu_sub)){
                    if($rec_manu_sub['manu_url']!=''){
                      $url = $part.$rec_manu_sub['manu_path'].$rec_manu_sub['manu_url'].'&manu_sub_id='.$rec_manu_sub['manu_id'];
                    }else{
                      $url = '#!';
                    }
                    
                    echo "<li class=\"nav-item\"> <a class=\"nav-link\" href=\"".$url."\">"."[ ".$rec_manu_sub['manu_number']." ] ".$rec_manu_sub['manu_name']."</a></li>";

                  }
            ?>
                </ul>
              </div>
            </li>
            <?php
                }
            ?>
            <!--<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-flow1" aria-expanded="false" aria-controls="general-flow1">
                <span class="menu-title">ระบบแจ้งซ่อม</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-exit-to-app menu-icon"></i>
              </a>
              <div class="collapse" id="general-flow1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_dis.php?step_flow=1&form_folw=1"> บันทึกข้อมูล </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_assign_dis.php?step_flow=2&form_folw=1"> มอบหมายงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_reply_dis.php?step_flow=3&form_folw=1"> รายงานผลดำเนินงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/flow/flow_approve_dis.php?step_flow=4&form_folw=1"> อนุมัติ/ตรวจสอบ </a></li>
                </ul>
              </div>
            </li>
             <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-flow2" aria-expanded="false" aria-controls="general-flow2">
                <span class="menu-title">ระบบทะเบียน PM</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-exit-to-app menu-icon"></i>
              </a>
              <div class="collapse" id="general-flow2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="#"> บันทึกข้อมูล </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> มอบหมายงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> รายงานผลดำเนินงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> อนุมัติ/ตรวจสอบ </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-flow3" aria-expanded="false" aria-controls="general-flow3">
                <span class="menu-title">ระบบทะเบียน PO</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-exit-to-app menu-icon"></i>
              </a>
              <div class="collapse" id="general-flow3">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="#"> บันทึกข้อมูล </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> มอบหมายงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> รายงานผลดำเนินงาน </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> อนุมัติ/ตรวจสอบ </a></li>
                </ul>
              </div>
            </li>

			      <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-report" aria-expanded="false" aria-controls="general-report">
                <span class="menu-title">รายงาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-printer menu-icon"></i>
              </a>
              <div class="collapse" id="general-report">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 1 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 2 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#!"> รายงาน 3 </a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">ตั้งค่าพื้นฐาน</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/profile_dis.php"> ข้อมูลบุคลากร </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/company_dis.php"> ตั้งค่าบริษัท </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/department_dis.php"> ตั้งค่าแผนก  </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/position_dis.php"> ตั้งค่าตำแหน่ง </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/perfix_dis.php"> ตั้งค่าคำนำหน้า </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/lavel_dis.php"> ตั้งค่าระดับผู้ใช้งาน </a></li>
				          <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/machinery_dis.php"> ตั้งค่าทะเบียนเครื่องจักร </a></li>
                  <li class="nav-item"> <a class="nav-link" href="<?=$part;?>pages/forms/equipment_dis.php"> ตั้งค่าทะเบียนอุปกรณ์ </a></li>
                </ul>
              </div>
            </li> -->




            <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-test">
                <span class="menu-title">ระบบ</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-exit-to-app menu-icon"></i>
              </a>
              <div class="collapse" id="general-test">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="#"> เมนูที่ 1 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> เมนูที่ 2 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> เมนูที่ 3 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="#"> เมนูที่ 4 </a></li>
                </ul>
              </div>
            </li> -->
          </ul>
        </nav>