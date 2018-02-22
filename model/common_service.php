<?php
//db connection
require_once('model/connection.php');

class CommonService
{	
	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}
	

	###	user login function to check valid or invalid
	###	Created : 17/09/2016
	###	Modified : 11/11/2016
	public function do_login($email, $password)
	{
		// Valiable declaration
		$log_data = $user_account_id = $login_status = null;
		
		try {
			
			$random = rand(0,99999);
			$stmt = $this->conn->prepare("SELECT * FROM vw_users WHERE email=:email AND password=:password");
			$stmt->execute(array(':email'=>$email, ':password'=>$password));
			$result_row=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1) {
				if ($result_row['account_status'] == 'active') {
					$expiry_row = $this->check_expiry($result_row['user_account_id']);
					$expiry_row = $expiry_row[0];
					if ($expiry_row == 'valid') {
						
						$cookies = $result_row['firstname']."|".$result_row['user_account_id']."|".$random."|".$result_row['user_type_id'];
						setcookie(Config::COOKIE_NAME, $cookies, time()+86400);
						$log_data = "successfully logged";
						$user_account_id = $result_row['user_account_id'];
						$login_status =  $cookies;
						
					} else if ($expiry_row == 'wrong') {
						
						$log_data = "Oops!!! your license not yet been registered";
						$login_status =  'wrong';						
						
					} else {
						
						$log_data = "Oops!!! your account was expired";
						$login_status =  'failure';						
						
					}						
				} else {
					
					$log_data = "Oops!!! your account was locked";
					$login_status =  'locked';
					
				}					
			}
			else {
				$log_data = "emailid/password wrong";
				$login_status = false;	
			}
			
		}
		catch (PDOException $e) {
			$login_status =  'error';
			$log_data = "|user login exception|".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($user_account_id, $log_data, $login_status);
	}
	
	
	
	###	log data function to insert the activity on the app
	###	Created : 17/09/2016
	###	Modified : 13/11/2016
	public function data_logger_db($user_account_id, $log_data, $date_time)
	{
		try {
			$db_values = array($user_account_id,''.$log_data.'',''.$date_time.'');	
			$stmt = $this->conn->prepare("INSERT INTO logs (user_account_id,activity,date_stamp) VALUES (?,?,?)");
			$stmt->execute($db_values);
			$log_data = "successfully logged";
			$log_data_status = 'success';
			return true;
		}
		catch (PDOException $e) {
			$log_data_status =  'error';
			$log_data = "|insert logs exception|".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($user_account_id, $log_data, $log_data_status);
	}
	
  
	###	select the data based on the table and where condition
	###	Created : 17/09/2016
	###	Modified : 13/11/2016
	public function do_select_db($table, $clm, $ac)
	{
		try { 
			$log_data = null;
			$stmt = $this->conn->prepare("SELECT * FROM ".$table." WHERE ".$clm."=:".$clm."");
			$stmt->execute(array(':'.$clm=>$ac));
			if ($stmt->rowCount() == 1) {
				$result_row=$stmt->fetch(PDO::FETCH_ASSOC);
				$select_status = $result_row;
				$log_data = "successfully selected";
			}
			else if ($stmt->rowCount() == 0) {
				$select_status = 'wrong';
			}
			
		}
		catch (PDOException $e) {
			$select_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $select_status);
	}
	
  
	###	select the user data expiary details
	###	Created : 27/11/2016
	###	Modified : 27/11/2016
	public function check_expiry($user_account_id)
	{
		try {
			$select_status = $log_data = null;
			$stmt = $this->conn->prepare("SELECT * FROM vw_users_expiry WHERE user_account_id =:user_account_id order by valid_to desc limit 1");
			$stmt->execute(array(':user_account_id'=>$user_account_id));
			if ($stmt->rowCount() == 1) {
				$result_row=$stmt->fetch(PDO::FETCH_ASSOC);
				if($result_row != 'wrong' && (strtotime($result_row['valid_to']) > strtotime(date('Y-m-d H:i:s')))) {
					$select_status = 'valid';
				}
				else {
					$select_status = 'invalid';
				}
			}
			else if ($stmt->rowCount() == 0) {
				$select_status = 'expiry';
			}
		}
		catch (PDOException $e) {
			$select_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($select_status, $log_data);
	}
	

	###	add new data into db for new submition 
	###	Created : 17/09/2016
	###	Modified : 14/11/2016
	public function do_add_db($get_array, $do, $all_array)
	{
		try {
			//variable declaration
			$get_array_keys = $get_array_keyss = $insert_status = $insert_id = null;
			$table_name = $all_array[0];

			$i = 0;
			foreach ($all_array[3] as $get_array_key => $get_array_val) {
				//removing submit button and do parameter
				if($do.'_submit' == $all_array[3][$i][2]) {
					unset($all_array[3][$i][2]);
					unset($get_array_val[2]);
				}
				else {
				
					$str_find = strpos($all_array[3][$i][2],"[]");
					
					// File Checking 
					if($all_array[3][$i][0] == 'file') {
						$file_values = $_FILES[$all_array[3][$i][2]]['name'];
						$_REQUEST[$get_array_key] = $file_values;
						$file_names[] = $all_array[3][$i][2];
					}
					// Date Format Checking 
					else if ($all_array[3][$i][5] == 'Cal') {
						$_REQUEST[$get_array_key] = $this->date_format_func($get_array[$get_array_val[2]], "Y-m-d H:i:s");
					}
					
					// Serialize when the data is array
					else if (!empty($str_find) && $str_find >= 0) {
						$get_array_val[2] = str_replace("[]","",$get_array_val[2]);
						$_REQUEST[$get_array_key] = serialize($get_array[$get_array_val[2]]);
					}
					else {
						if ($all_array[3][$i][0] != 'head') {
							$_REQUEST[$get_array_key] = $get_array[$get_array_val[2]];
						}	
					}
					// Removing the "head" line for db
					if ($all_array[3][$i][0] != 'head') {
						// forming the data for insert query 
						$form_values[] = $_REQUEST[$get_array_key];
						$get_array_keys.= $get_array_val[2].",";
						$get_array_keyss.= "?,";
					}	
				}
				$i++;
			}
			//removing the , from the insert statement
			$form_columns = trim($get_array_keys,",");
			$db_columns = trim($get_array_keyss,",");
			$stmt = $this->conn->prepare("INSERT INTO ".$table_name." (".$form_columns.") VALUES (".$db_columns.")");
			$stmt->execute($form_values);
			$insert_id = $this->conn->lastInsertId();
			
			// Move files into upload directory
			if (isset($_FILES)) {
				foreach($file_names as $files) {
					$this->file_uploads($files,CONFIG::UPLOADS_PATH, $insert_id);
				}
			}
			if ($stmt->rowCount() == 1) {
				$log_data = "new record added successfully";
				$insert_status = 'success';
			}
		}
		catch (PDOException $e) {
			$insert_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $insert_id, $insert_status);
	}


	###	update data into db based on the $ac data once submitted
	###	Created : 22/09/2016
	###	Modified : 11/11/2016
	public function do_update_db($get_array, $do, $all_array)
	{
		try {
			$get_array_keys = $get_array_keyss = $update_status = $update_id = $log_data = null;
			$ac = isset($get_array['ac'])?$get_array['ac']:NULL;
			$clm = isset($get_array['clm'])?$get_array['clm']:NULL;
			$table_name = $all_array[0];
			
			$i = 0;
			foreach ($all_array[3] as $get_array_key => $get_array_val) {
				//removing submit button and do parameter
				if($do.'_submit' == $all_array[3][$i][2]) {
					unset($all_array[3][$i][2]);
					unset($get_array_val[2]);
				}
				else {
					$str_find = strpos($all_array[3][$i][2],"[]");
					
					// File upload script 
					if ($all_array[3][$i][0] == 'file') {
						$file_values = $_FILES[$all_array[3][$i][2]]['name'];
						
						if (!empty($file_values)) {
							$_REQUEST[$get_array_key] = $file_values;
							$file_names[] = $all_array[3][$i][2];
							if (@file_exists('./'.CONFIG::UPLOADS_PATH."/".$ac."_".$all_array[3][$i][3])) {
								@unlink('./'.CONFIG::UPLOADS_PATH."/".$ac."_".$all_array[3][$i][3]);
							}
							$this->file_uploads($all_array[3][$i][2],CONFIG::UPLOADS_PATH, $ac);
						}
						else {
							$_REQUEST[$get_array_key] = $get_array_val[3];
						}
					}
					// Date Format Checking 
					else if ($all_array[3][$i][5] == 'Cal') {
						$_REQUEST[$get_array_key] = $this->date_format_func($get_array[$get_array_val[2]], "Y-m-d H:i:s");
					}
					// Serialize when the data is array
					else if (!empty($str_find) && $str_find >= 0) {
						$get_array_val[2] = str_replace("[]","",$get_array_val[2]);
						$_REQUEST[$get_array_key] = serialize($get_array[$get_array_val[2]]);
					}
					else {
						if ($all_array[3][$i][0] != 'head') {
							$_REQUEST[$get_array_key] = $get_array[$get_array_val[2]];
						}
					}
					// Removing the "head" line for db
					if ($all_array[3][$i][0] != 'head') {
						// Assigning values to each parameter 
						$form_values[] = $_REQUEST[$get_array_key];
						$all_array[3][$i][2] = str_replace("[]","",$get_array_val[2]);
						$get_array_keys.= $all_array[3][$i][2]."=?,";
					}	
				}
				$i++;
			}
			// Add where condition value
			array_push($form_values, $ac); 
			$form_columns = trim($get_array_keys,",");
			//echo "Update ".$table_name." SET ".$form_columns." WHERE ".$clm."=?";
			$stmt = $this->conn->prepare("Update ".$table_name." SET ".$form_columns." WHERE ".$clm."=?");
			$stmt->execute($form_values);
			if($stmt->rowCount() == 1) {
				$log_data = "updated successfully";
				$update_status = 'success';
			}
		}
		catch (PDOException $e) {
			$update_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $ac, $update_status);
	}

	
	/**
	
		update data into db based on the $ac data once submitted
		Created : 18/09/2016
		Modified : 16/11/2016
		
	**/
	public function list_data_db($get_query, $do)
	{
		try {
			//variable declaration
			$where_query_array = $result_row = $list_status = null;
			
			$table_name = $get_query[0];
			$order_by = " order by ".$get_query[1];
			$list_head = $get_query[2];
			$search_fields = $get_query[3];
			$list_fields = $get_query[4];
			$edit_column = $get_query[5];
			$search_submit = "search_".$do;
			
			// when search area get submitted
			if (isset($_REQUEST[$search_submit])) {
				$search_count = count($search_fields);
				$where_query_array = "Where ";
				$q = 1;

				foreach ($search_fields as $search_val) {
					
					$q == $search_count? $and = " " : $and = " and ";
					if ($search_val[0] == 'date') {
						if (!empty($_REQUEST[$search_val[2]])) {
							$date_values = explode(" - ",$_REQUEST[$search_val[2]]);
							$date_values[0] = str_replace("/","-",$date_values[0]);
							$date_values[1] = str_replace("/","-",$date_values[1]);
							$date_values[0] = date("Y-m-d H:i:s",strtotime($date_values[0].":00"));
							$date_values[1] = date("Y-m-d H:i:s",strtotime($date_values[1].":00"));
							$where_query_array.= "".$search_val[2]." between '".$date_values[0]."' and '".$date_values[1]."' ".$and."";
						}	
					}
					else {
						/*
							avoid empty values into where condition
						*/
						if (!empty($_REQUEST[$search_val[2]])) {
							$where_query_array.= "".$search_val[2]." =  '".$_REQUEST[$search_val[2]]."' ".$and."";
						}
					}	
					$q++;
				}
			}

			// Setting if no values in the search area
			if($where_query_array == "Where "){
				$where_query_array = null;
			}
			else{
				$Final_Where = substr($where_query_array, -4);
				if($Final_Where == 'and '){
					$where_query_array = substr($where_query_array,0, -4);
				}
			}
			// select statement after making the where query
			$stmt = $this->conn->prepare("SELECT * FROM ".$table_name." ".$where_query_array." ".$order_by."");
			$stmt->execute();
			if ($stmt->execute()) {
				$result_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$log_data = "listed successfully";	
			}	
			else {
				$log_data = "listed unsuccessfully";	
			}	
			
		}	
		catch (PDOException $e) {
			$list_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($order_by, $list_head, $search_fields, $list_fields, $result_row, $edit_column, $list_status, $log_data, $where_query_array);
	}

	/**
		update data into db based on the $ac data once submitted
		Created : 18/09/2016
		Modified : 16/11/2016
		
	**/
	public function list_user_data_db($user_account_id, $get_query, $do)
	{
		try {
			//variable declaration
			$where_query_array = $result_row = $list_status = null;
			
			$table_name = $get_query[0];
			$order_by = " order by ".$get_query[1];
			$list_head = $get_query[2];
			$search_fields = $get_query[3];
			$list_fields = $get_query[4];
			$edit_column = $get_query[5];
			$search_submit = "search_".$do;
			
			// when search area get submitted
			if (isset($_REQUEST[$search_submit])) {
				$search_count = count($search_fields);
				$where_query_array = "Where ";
				$q = 0;
				
				foreach ($search_fields as $search_val) {
				
					($q == $search_count-1? $and = " " : $and = "and");
					if ($search_val[0] == 'date') {
						$date_values = explode(" - ",$_REQUEST[$search_val[2]]);
						$date_values[0] = str_replace("/","-",$date_values[0]);
						$date_values[1] = str_replace("/","-",$date_values[1]);
						$date_values[0] = date("Y-m-d H:i:s",strtotime($date_values[0].":00"));
						$date_values[1] = date("Y-m-d H:i:s",strtotime($date_values[1].":00"));
						$where_query_array.= trim("".$search_val[2]." between '".$date_values[0]."' and '".$date_values[1]."' ".$and."");
					}
					else {
						/*
							avoid empty values into where condition
						*/
						if (!empty($_REQUEST[$search_val[2]])) {
							$where_query_array.= " ".$search_val[2]." =  '".$_REQUEST[$search_val[2]]."' ".$and."";
						}
					}	
					$q++;
				}
			}

			// select statement after making the where query
			
			
			//echo "SELECT * FROM user_account ua left join user_master um on (ua.id = um.user_account_id) left join user_expiry ue on ua.id = (select id from user_expiry where user_account_id  = ".$user_account_id." order by id desc limit 1) ue.user_account_id";
			//exit;
			$group_by = " group by user_account_id";
			$stmt = $this->conn->prepare("SELECT * FROM `vw_users_expiry` ".$where_query_array." ".$group_by."");
			$stmt->execute();
			if ($stmt->execute()) {
				$result_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$log_data = "listed successfully";	
			}	
			else {
				$log_data = "listed unsuccessfully";	
			}	
			
		}	
		catch (PDOException $e) {
			$list_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($order_by, $list_head, $search_fields, $list_fields, $result_row, $edit_column, $list_status, $log_data, $where_query_array);
	}
	
	
	/**
	
		delete the data based on the data
		Created : 18/09/2016
		Modified : 11/11/2016
		
	**/	
	public function delete_data_db($table_name, $edit_column, $edit_value, $file_names)
	{
		try {
			$delete_status = $log_data = null;
			$stmt = $this->conn->prepare("SELECT * FROM ".$table_name." WHERE ".$edit_column." = '".$edit_value."'");
			$stmt->execute();
			if ($stmt->rowCount() == 0) {
				$delete_status = 'wrong';
			}
			$result_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			//Remove files if already exist in the upload directory
			if (count($result_row) == 1) {
				if (count($file_names) >= 1) {
					foreach ($file_names as $files) {
						if (file_exists('./'.CONFIG::UPLOADS_PATH."/".$edit_value."_".$result_row[0][$files])) {
							unlink('./'.CONFIG::UPLOADS_PATH."/".$edit_value."_".$result_row[0][$files]);
						}
					}					
				}	
				
				$stmt = $this->conn->prepare("DELETE FROM ".$table_name." WHERE ".$edit_column." = '".$edit_value."'");
				$delete_row = $stmt->execute();
				if ($stmt->rowCount() == 1) {
					$log_data = "deleted successfully";
					$delete_status = 'success';
				}
			}
		}	
		catch (PDOException $e) {
			$delete_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $edit_value, $delete_status);
	}
	
	
	###	For the array purpose alone
	###	Created : 18/09/2016
	###	Modified : 20/11/2016
	public function array_func_db($column1, $column2, $table_name, $where)
	{
		$arrayfunc_status = $log_data = $result_row = null;
		if (!empty($where))
			$where = " where ".$where."";
			
		try {
			$stmt = $this->conn->prepare("SELECT ".$column1.", ".$column2." FROM ".$table_name." ".$where."");
			$stmt->execute();
			if ($stmt->rowCount() >= 1) {
				$result_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result_rows as $key => $val){
					$result_row[$val[$column1]] = $val[$column2];
				}
			}
			else {
				$result_row = null;
			}			
		}
		catch (PDOException $e) {
			$utype_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return $result_row;
		exit;
	}
	


	###	file uploads
	###	Created : 18/09/2016
	###	Modified : 11/11/2016
	static function file_uploads( $field_name , $path_to_files, $insert_id) {

		$moved_file_status = $file_status = null;
		try {
			$img_info = $_FILES[$field_name];
			$img_name = $img_info['name'];
			$img_type = $img_info['type'];
			$img_tmp_name = $img_info['tmp_name'];
			$img_size = $img_info['size'];
			if(file_exists($path_to_files) == '')
				mkdir($path_to_files, 0777);

			$moved_file_status = move_uploaded_file($img_tmp_name, "./".$path_to_files."/".$insert_id."_".$img_name);
			if ($moved_file_status) {
				$file_status = "success";
				return true;
			}	
		}
		catch (PDOException $e) {
			$file_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $file_status);
			
	}


	###	Date Format Function
	###	Created : 20/09/2016
	###	Modified : 14/11/2016
	public function date_format_func($date,$format)
	{
		$date = str_replace("/","-",$date);
		$date_output = date($format,strtotime($date));
		return $date_output;
	}
	
	/**
	
		Date valid Function
		Created : 17/12/2016
		Modified : 17/12/2016
		
	**/	
	public function date_valid_func($date) {
		
		$date_value = null;
		// Checking date has value or not
		if (isset($date) && !empty($date) && strlen($date) == 10) {
			$date_explode = explode("/",$date);
			if (count($date_explode) == 3) {
				$date_value+=strlen($date_explode[0]);
				$date_value+=strlen($date_explode[1]);
				$date_value+=strlen($date_explode[2]);
				if ($date_value === 8) {
					 $date_value = 'date';
				} else {
					$date_value = null;
				}
			}
			return $date_value;
		}
	}
	

	###	Date Format Function
	###	Created : 20/09/2016
	###	Modified : 14/11/2016
	public function acl_project_screen($user_account_id, $user_type_id, $screen_name)
	{
		$screen_count = $screen_status = $log_data = $result_rows = $write_access =  null;
		try {
			$stmt = $this->conn->prepare("SELECT * FROM vw_user_project_screen where user_account_id = ".$user_account_id." and screen_name = '".$screen_name."' and screen_id != 'NULL'");
			$stmt->execute();
			$screen_count = $stmt->rowCount();
			if ($screen_count == 1) {
				$result_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$write_access = $result_rows[0]['write_access'];
			} else {
				$write_access = 0;
			}	
		}
		catch (PDOException $e) {
			$screen_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($screen_count, $screen_status, $log_data, $write_access);
	}
	
	
	/**
		Get profile information
		Created : 26/11/2016
		Modified : 26/11/2016
	**/	
	public function user_profile($user_account_id)
	{
		$user_status = $record_count = $log_data = $result_rows = null;
		try {
			$stmt = $this->conn->prepare("SELECT * FROM vw_users where user_account_id = ".$user_account_id."");
			$stmt->execute();
			$record_count = $stmt->rowCount();
			if ($record_count >= 1) {
				$result_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
		}
		catch (PDOException $e) {
			$user_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($record_count, $user_status, $log_data, $result_rows);
	}

	
	
	/**
	
		Get profile information
		Created : 26/11/2016
		Modified : 26/11/2016
		
	**/
	public function db_check_exist($table, $where)
	{
		$record_count = null;
		try {
			if (isset($where) && !empty($where)) {
				$where = "where ".$where." ";	
			}
			
			$stmt = $this->conn->prepare("SELECT * FROM ".$table." ".$where."");
			$stmt->execute();
			$record_count = $stmt->rowCount();
		}
		catch (PDOException $e) {
			$user_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return $record_count;
	}

	
	
	
	/**
		add new ADD USER DATA into db for multiple tables
		Created : 17/12/2016
		Modified : 17/12/2016
	**/	
	public function do_add_user_db($get_array, $do, $all_array)
	{
		try {
			//variable declaration
			$insert_status = $account_insert_id = $master_insert_id = $expiry_insert_id = $user_account_values  = $user_master_values  = $user_expiry_values = $insert_id = null;
			$date_stamp = date("Y-m-d H:i:s");
			
			// User Account data Insert
			$stmt = $this->conn->prepare("INSERT INTO user_account (firstname, lastname, gender, mobile, address, date_stamp) VALUES (?,?,?,?,?,?)");
			$user_account_values = array($get_array['firstname'], $get_array['lastname'], $get_array['gender'], $get_array['mobile'], $get_array['address'], $date_stamp);
			$stmt->execute($user_account_values);
			$account_insert_id = $this->conn->lastInsertId();
			
			// User master data Insert
			if (isset($account_insert_id)) {
				$stmt = $this->conn->prepare("INSERT INTO user_master (user_account_id, user_type_id, email, password, date_stamp) VALUES (?,?,?,?,?)");
				$user_master_values = array($account_insert_id, $get_array['user_type_id'], $get_array['email'], md5($get_array['password']), $date_stamp);
				$stmt->execute($user_master_values);
				$master_insert_id = $this->conn->lastInsertId();
			}
			// User Expirty data Insert
			if (isset($master_insert_id)) {
				// Change date format
				$get_array['valid_from'] = $this->date_format_func($get_array['valid_from'], "Y-m-d H:i:s");
				$get_array['valid_to'] = $this->date_format_func($get_array['valid_to'], "Y-m-d H:i:s");
				$stmt = $this->conn->prepare("INSERT INTO user_expiry (user_account_id, valid_from, valid_to, date_stamp) VALUES (?,?,?,?,?)");
				$user_expiry_values = array($account_insert_id, $get_array['valid_from'], $get_array['valid_to'], $date_stamp);
				$stmt->execute($user_expiry_values);
				$expiry_insert_id = $this->conn->lastInsertId();
			}	
			if ($stmt->rowCount() == 1) {
				$log_data = "new user record added successfully";
				$insert_status = 'success';
				$insert_id = $account_insert_id."".$master_insert_id."|".$expiry_insert_id;
			}
		}
		catch (PDOException $e) {
			$insert_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $insert_id, $insert_status);
	}

	
	/**
		update data into db based on the $ac data once submitted
		Created : 22/09/2016
		Modified : 11/11/2016
	**/	
	public function do_user_update_db($get_array, $do, $all_array)
	{
		try {

			//variable declaration
			$insert_status = $account_update_count = $master_update_count = $expiry_update_count = $user_account_values  = $user_master_values  = $user_expiry_values = $update_id = null;
			$date_stamp = date("Y-m-d H:i:s");
			$user_account_values = array($get_array['firstname'], $get_array['lastname'], $get_array['gender'], $get_array['mobile'], $get_array['address'], $get_array['ac']);

			// User Account data update			
			$stmt = $this->conn->prepare("UPDATE user_account SET firstname=?, lastname=?, gender=?, mobile=?, address=? WHERE id=?");
			$stmt->execute($user_account_values);
			$account_update_count = $stmt->rowCount();
			
			// User master data update
			if (isset($account_update_count)) {
				$stmt = $this->conn->prepare("UPDATE user_master SET user_type_id=?, email=? WHERE user_account_id=?");
				$user_master_values = array($get_array['user_type_id'], $get_array['email'], $get_array['ac']);
				$stmt->execute($user_master_values);
				$master_update_count = $stmt->rowCount();
			}
			// User Expirty data update
			if (isset($master_update_count)) {
				// Change date format
				$get_array['valid_from'] = $this->date_format_func($get_array['valid_from'], "Y-m-d H:i:s");
				$get_array['valid_to'] = $this->date_format_func($get_array['valid_to'], "Y-m-d H:i:s");
				$db_valid_to = $this->date_format_func($all_array[3][10][3], "Y-m-d H:i:s");
				
				// Checking if no update made on valid_from and valid_to
				if ($db_valid_to < $get_array['valid_to']) {
					$stmt = $this->conn->prepare("INSERT INTO user_expiry (user_account_id, valid_from, valid_to, date_stamp) VALUES (?,?,?,?)");
					$user_expiry_values = array($get_array['ac'], $get_array['valid_from'], $get_array['valid_to'], $date_stamp);
					$stmt->execute($user_expiry_values);
					$expiry_update_count = $stmt->rowCount();
				}
				else {
					// Expiry date will update if date has been modified
					$stmt = $this->conn->prepare("UPDATE user_expiry SET valid_from=?, valid_to=? WHERE user_account_id=? and valid_to=? ");
					$user_expiry_values = array($get_array['valid_from'], $get_array['valid_to'], $get_array['ac'], $db_valid_to);
					$stmt->execute($user_expiry_values);
					$expiry_update_count = $stmt->rowCount();
				}
			}
			if ($account_update_count == 1 || $master_update_count == 1 || $expiry_update_count == 1) {
				$log_data = "User record updated successfully";
				$insert_status = 'success';
				$update_id = $account_update_id."".$master_update_id."|".$expiry_update_id;
			}

		}
		catch (PDOException $e) {
			$update_status =  'error';
			$log_data = "".$e->getMessage()."".CONFIG::NEWLINE_ERROR."|";
		}
		return array($log_data, $ac, $update_status);
	}

	
	
	
			
}
?>