<?php
include('config.php');
ini_set('memory_limit', MEM_LIMIT);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING );
function _log($type, $msg){
	$log_file = fopen(LOG_FILE,'a');
	fwrite($log_file, json_encode(array('res'=>$type,'time'=>date("Y-m-d H:i:s"),'log'=>$msg))."\n");
	fclose($log_file);
}			
function IsNullOrEmptyString($str){
	if (strlen($str) == 0 || !isset($str) || trim($str) === '' || $str === null) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function IsNullOrEmptyArray($arr){
	if (count($arr) == 0 || !isset($arr) || empty($arr) || in_array("", $arr, true)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

while(true){
	$command = "asterisk -rx 'core show channels concise'";
	if(!IsNullOrEmptyArray(unserialize(TRUNKS_TO_FETCH))){
		$trunks_to_fetch_str = '';
		foreach(unserialize(TRUNKS_TO_FETCH) as $trunk){
			$trunks_to_fetch_str .= " -e $trunk";
		}
		$command .= " | grep $trunks_to_fetch_str";
	}
	if(!IsNullOrEmptyArray(unserialize(TRUNKS_TO_EXCLUDE))){
		$trunks_to_exclude_str = '';
		foreach(unserialize(TRUNKS_TO_EXCLUDE) as $trunk){
			$trunks_to_exclude_str .= " -v $trunk";
		}
		$command .= " | grep $trunks_to_exclude_str";
	}
	if(!IsNullOrEmptyArray(unserialize(EXTENSIONS_TO_FETCH))){
		$extensions_to_ftech_str = '';
		foreach(unserialize(EXTENSIONS_TO_FETCH) as $extension){
			$extensions_to_ftech_str .= "$extension,";
		}
		$extensions_to_ftech_str = rtrim($extensions_to_ftech_str,',');
		$command .= " | grep $extensions_to_ftech_str";
	}

	$sql_statement = "TRUNCATE `call_stream`;";
	$stream = shell_exec($command);

		if($stream != '' ){
			$data = explode("&", preg_replace('/\s+/', ' ', str_replace(array("\r", "\n"), '&', str_replace('/\s+/g', '', $stream))));
			for ($i = 0; $i < count($data); $i++) {
				$sql_statement .= "INSERT INTO `call_stream` (`id`, `channel`, `context`, `extension`, `priority`, `state`, `application`, `data`, `caller_id`, `account_code`, `peer_account`, `ama_flags`, `duration`, `bridged_to`, `unique_id`, `updated_at`) VALUES (NULL, ";
				$col = explode('!', $data[$i]);
				for ($x = 0; $x < count($col); $x++) {
					if(IsNullOrEmptyString($col[$x])){
						$sql_statement .= "NULL,";
					} else {
						$sql_statement .= "'".str_replace("/","-",str_replace(",","-",$col[$x]))."',";
					}
				}
				$sql_statement .= "'".date("Y-m-d H:i:s")."');";
			}
			$conn = mysqli_connect(SRV,USR,PWD,DB);
			$update_query = mysqli_multi_query($conn,$sql_statement); 
			if(!$update_query){_log('error', 'error inserting new stream => '.mysqli_error($conn)); _log('info', $sql_statement);}
			mysqli_close($conn);
		}else{
			// empty stream
			_log('info', 'empty stream');
		}

	usleep(FETCHING_PERIOD);
}
?>
