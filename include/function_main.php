<?php
    include ("config_db.php"); 
    class sql_main extends dbh {
        function query($sql){
            $result_sql = mysqli_query($this->connect(),$sql);
            if($result_sql) {  //เขียนดักแค่ว่า query มีข้อมูลหรือเปล่า?
                return $result_sql;
            }else{
                mysqli_error($this->connect());
            }
        }
        function db_num_rows($query){
            $result_num_row = mysqli_num_rows($query);
            return $result_num_row;
        }
    
        function db_fetch_array($query){
            $result_data = mysqli_fetch_array($query);
            return $result_data;
        }
		function db_insert($tb_name,$fields,$pk_id=''){
			try{
				$fieldlist = array();
				$valuelist = array();
				while(list($key, $val) = each($fields)){
					array_push($fieldlist,$key);
					switch (strtolower($val)) {
						case 'null':break;
						case '$set$':
							$f = "field_key";
							$val = "'".($$f?implode(',',$$f):'')."'";
						break;
						default:
							$val = "'$val'";
						break;
					}
					if(empty($funcs[$key]))
						array_push($valuelist,$val);
					else
						array_push($valuelist,$funcs[$key]($val));
				}
				$fieldlist = implode(",",$fieldlist);
				
				$valuelist = implode(",",$valuelist);
				$sql = "INSERT INTO $tb_name($fieldlist) VALUES ($valuelist)"; 
				$query_id = $this->query($sql);
				if($pk_id!=''){
					// return mysqli_insert_id($this->connect());
					$query = $this->query("SELECT MAX({$pk_id}) AS bid FROM {$tb_name}");
					$rs =  $this->db_fetch_array($query);
					return $rs['bid'];
				}
				
			}
			catch(Exception $e){
					echo $e->getMessage();
			}

		}//insert
		function db_update($table,$fields,$cond){
			try{
				$valuelist = array();
				while(list($key, $val) = each($fields)){
					switch (strtolower($val)) {
						case 'null':
							break;
						case '$set$':
							$f = "field_$key";
							$val = "'".($$f?implode(',',$$f):'')."'";
							break;
						default:
							$val = "'$val'";
							break;
					}
					array_push($valuelist,$key.'='.$val);
					if (!empty($funcs)){
						if(!empty($funcs[$key]))array_push($valuelist,$key.'='.$funcs[$key]($val));
					}
				}
				$valuelist = implode(",",$valuelist);
					$sql = "UPDATE $table SET $valuelist  where  1=1  and ".$cond; 
				$this->query($sql);
			}
			catch(Exception $e){
					echo $e->getMessage();
			}

		}//update
		
		function db_delete($table , $cond){	
			$sql = "DELETE FROM ".$table;		
			if( $cond)	{
				$sql .= " where  1=1 and ".$cond;
			}
			$this->query($sql);	
		}//db_delete
    }
?>