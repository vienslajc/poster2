<?php

add_action( 'admin_notices', 'indqa_check_create_log_folder' );

// create log folder
// return true if folder has been created or exists else false
function indqa_createLogFolder() {
	$error=false;
	if (!@is_dir (UBIC_LOGPATH)) {
		if (!@mkdir (UBIC_LOGPATH, 0777)) {
			$indqa_on_off=0;
			update_option('indqa_on_off', 0);
			$error=true;
		}
	}

	# check if log folder is writeable
	if (!@is_writable(UBIC_LOGPATH) ) {

		# trying to set permissions
		if (!@chmod(UBIC_LOGPATH, 0777)) {
			$indqa_on_off=0;
			update_option('indqa_on_off', 0);
			$error=true;
		}
	} else {
		# create empty index.html file to hide logs from browsing
		$emptyFile=UBIC_LOGPATH.'index.html';
		$fileWrite = fopen($emptyFile, 'a');
		fclose($fileWrite);
	}
	if ($error) return false; else return true;
}

# delete log folder
function indqa_deleteLogFolder() {
	# delete log folder and logs
	if (@is_dir(UBIC_LOGPATH)) {
		indqa_deltree(UBIC_LOGPATH);
	}
}

// try to create log folder and print success or error on admin panel
function indqa_check_create_log_folder() {
	# check for folder
	if (indqa_check_folder_error()) {
		if (!indqa_createLogFolder()) {
			print '<div id="message" class="error">'.__("Empty Plugin Template (UBIC) Error: Can't write to log folder ", EMU2_I18N_DOMAIN).UBIC_LOGPATH.__(" Permissions 777 needed.", EMU2_I18N_DOMAIN).'</div>';
		} else {
			print '<div id="message" class="updated">'.__("Empty Plugin Template (UBIC): Log folder created: ", EMU2_I18N_DOMAIN).UBIC_LOGPATH.'</div>';
		}
	}
}

function indqa_check_folder_error() {
	$error=false;
	# check if log folder is writeable
	if (!@is_writable(UBIC_LOGPATH) ) {
		# trying to set permissions
		if (!@chmod(UBIC_LOGPATH, 0777)) {
			// can't write to or create log folder
			// maybe you should switch you lugin to off now
			// $indqa_on_off=false;
			$error=true;
		}
	}
	return $error;
}

# deletes all files and folders and subfolders in given folder
function indqa_deltree($f) {
	if (@is_dir($f)) {
		foreach(glob($f.'/*') as $sf) {
			if (@is_dir($sf) && !is_link($sf)) {
				@indqa_deltree($sf);
			} else {
				@unlink($sf);
			}
		}
	}
	if (@is_dir($f)) rmdir($f);
	return true;
}


# write a message to the logfile
function indqa_writelog() {
	$numargs = func_num_args();
	$arg_list = func_get_args();
	if ($numargs >2) $linenumber=func_get_arg(2); else $linenumber="";
	if ($numargs >1) $functionname=func_get_arg(1); else $functionname="";
	if ($numargs >=1) $string=func_get_arg(0);
	if (!isset($string) or $string=="") return;

	$logFile=UBIC_LOGPATH.'/ops-'.date("Y-m").".log";
	$timeStamp = date("d/M/Y:H:i:s O");

	$fileWrite = fopen($logFile, 'a');

	//flock($fileWrite, LOCK_SH);
	if (indqa_debug()) {
		$logline="[$timeStamp] ".html_entity_decode($string)." $functionname $linenumber\r\n";	# for debug purposes
	} else {
		$logline="[$timeStamp] ".html_entity_decode($string)."\r\n";
	}
	fwrite($fileWrite, utf8_encode($logline));
	//flock($fileWrite, LOCK_UN);
	fclose($fileWrite);
}

?>