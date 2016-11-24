<?php 
ini_set('max_execution_time', 300);
$verifyStatus = 74;
$limit = 180;
//================ Start DB Connection ====================
// =======Local Data=======
    $host_add="localhost";
    $db_name="biostar";
    $user_name="root";
    $password="";

	if(!$conn = mysql_pconnect($host_add, $user_name, $password)){ die('Could not connect: ' . mysql_error());}
	
    if(!$db_select = mysql_select_db($db_name)){
		die('DB not selected');
	}
// ==========================
//================== End DB Connection ======================

	$sql = "SELECT nEventLogIdn,nDateTime,nUserID, STATUS
			FROM tb_event_log
			WHERE  nEventIdn = $verifyStatus AND STATUS = 0
			ORDER BY nEventLogIdn ASC
			LIMIT 0, $limit";

	$q = mysql_query($sql);
	
    $count = mysql_num_rows($q);
////////////////////////--------------------------------------

	if(!empty($count)){
        $date =  date('YmdHis');
		while($row = mysql_fetch_array($q)){

			//to send data
            $send = "nEventLogIdn: ".$row['nEventLogIdn'].", nDateTime: ".$row['nDateTime'].", UserID: ".$row['nUserID'];
            mysql_query("INSERT INTO tb_zz_send_receive_log(comment, status) values ('$send','0')");
            
            //sending data and taking response
		$response =  send_to_server($row['nEventLogIdn'], $row['nDateTime'], $row['nUserID']);
            mysql_query("INSERT INTO tb_zz_send_receive_log(comment, status) values ('$response','1')");

            if($response == 'S'){
				//update query
				$nEventLogIdn = $row['nEventLogIdn'];
				$update = "	UPDATE tb_event_log
							SET status = 1
							WHERE nEventLogIdn = $nEventLogIdn";
		mysql_query($update);
                if(!mysql_query($update)){
                    echo "Some error Happen.";
                }
			}
		}
	}
// ========================

//function to hit in server ============================================
	function send_to_server( $nEventLogIdn, $nDateTime, $userID ){
		//clients url will be here
		//$url = "http://localhost/frm_att_data/toServer.php?";
		//$url = "http://202.161.188.108/school/schoobee/wh/app/web_api/attendance/recive_device_attendance.php?";
		$url = "http://202.161.188.108/school/schoobee/nababidhan/app/web_api/attendance/recive_device_attendance.php?";

        $val = "CHECKINOUT_ID=$nEventLogIdn&CARD_NO=$userID&CHECK_TIME=$nDateTime";

		$server_url = $url.$val;

		//curl start
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $server_url,
		CURLOPT_USERAGENT => ''
		));
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
?>