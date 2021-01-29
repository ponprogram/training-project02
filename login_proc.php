<?php 
    session_start();
    ini_set('display_errors',0);
    header ('Content-type: text/html; charset=utf-8');
   
    $part = "";
    include ($part."include/function.php"); 

    $usename = $_POST['exampleInputUsername1'];
    $password = base64_encode($_POST['exampleInputPassword1']);
    $manusub_arr = array();
    $sql = "SELECT
                per.per_id,
                per.img,
                CONCAT(pf.perfix_name_th,per.f_name,' ',per.l_name) AS full_name,
                per.per_lavel,
                com.com_id,
                com.com_name,
                dep.dep_id,
                dep.dep_name,
                pos.pos_id,
                pos.pos_name,
                per.active_status
            FROM  profile per
            INNER JOIN company com ON com.com_id = per.com_id
            INNER JOIN department dep ON dep.dep_id = per.dep_id
            INNER JOIN m_position pos ON pos.pos_id = per.pos_id
            LEFT  JOIN perfix pf ON pf.perfix_id = per.perfix_id
            WHERE
                1=1
                AND per.username = '{$usename}' 
                AND per.password = '{$password}'";
    $query = $db->query($sql);
    $num = $db->db_num_rows($query);
    if($num>0){
            $rec = $db->db_fetch_array($query);
            if($rec['active_status']==1){
                $_SESSION['PER_ID']     = $rec['per_id'];
                $_SESSION['PER_NAME']   = $rec['full_name'];
                $_SESSION['PER_LAVEL']  = $rec['per_lavel'];
                $_SESSION['COM_ID']     = $rec['com_id'];
                $_SESSION['COM_NAME']   = $rec['com_name'];
                $_SESSION['DEP_ID']     = $rec['dep_id'];
                $_SESSION['DEP_NAME']   = $rec['dep_name'];
                $_SESSION['POS_ID']     = $rec['pos_id'];
                $_SESSION['POS_NAME']   = $rec['pos_name'];
                $_SESSION['IMG_PER']   	= $rec['img'];
                
                $sql_sub =  "SELECT
                                ms.manu_id,
                                msg.add_status,
                                msg.edit_status,
                                msg.del_status
                            FROM
                                manu_setting ms
                                JOIN manu_set_groub msg ON msg.manu_id = ms.manu_id
                            WHERE
                                1=1 
                                AND msg.lavel_id = '{$rec['per_lavel']}'
                            ORDER BY
                                ms.manu_order ASC";
                $query_sub = $db->query($sql_sub);
                while($rec_sub = $db->db_fetch_array($query_sub)){
                    $manusub_arr[$rec_sub['manu_id']]['ADD']    =   $rec_sub['add_status'];
                    $manusub_arr[$rec_sub['manu_id']]['EDIT']   =   $rec_sub['edit_status'];
                    $manusub_arr[$rec_sub['manu_id']]['DEL']    =   $rec_sub['del_status'];
                }

                $_SESSION['MANU_GROUB']   	= $manusub_arr;
                echo "<script>self.location.href='home.php';</script>";
            }else{
                unset($_SESSION);
                echo "  <script>
                            alert('ผู้ใช้งานนี้ถูกระงับการใช้งาน กรุณาติดต่อ Super Admin');
                            self.location.href='login.php';
                        </script>";
            }
    }else{
        // echo $sql;
        unset($_SESSION);
        echo "  <script>
                    alert('Usename หรือ Password ไม่ถูกต้อง');
                    self.location.href='login.php';
                </script>";
    }
?>
<>