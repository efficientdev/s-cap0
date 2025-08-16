<?php

namespace App\IdUtils;
use Str;
/**
 * EnrolStudent.php
 */
class EnrolStudent
{
	public $nerotech;
	
	function __construct()
	{
		# code... /var/www/html/alive/cdn
		$this->nerotech='/var/www/html/alive/cdn/Bin/Java/';
	
	}
	function addToPath($x){
		return $this->nerotech.$x;
	}
	public static function enrolTemplate($sid){
		//if makeNewTemplate was successful
	}
	public static function makeNewTemplate($sid){
		$n=new EnrolStudent();

		try {
			
			/*
			$tr2='cd '.$n->nerotech.'; java -jar enroll-face-from-image.jar '.$sid.'.jpg '.$sid;

			//exec($tr2, $output, $retval);
			$tee['tr2']=$tr2;
			$tee['outputx']=$output;
			$tee['returnx']=$retval;
			*/

			//shell_exec($tr.' > '.$tee['cwd'].'/log.txt &');

			/*$tr="cd /home/alivedig/nb13/Neurotec_Biometric_13_1_SDK/Bin/Java/ && java -jar  enroll-face-from-image.jar  ".escapeshellarg($file)."  ".escapeshellarg($ofi); 
			//echo $tr;
			*/

			$tr="java -jar ".$n->nerotech."enroll-face-from-image.jar  ".escapeshellarg($n->addToPath($sid.".jpg"))."  ".escapeshellarg($n->addToPath($sid));

			$output=null;
			$retval=null; 

			exec($tr, $output, $retval); 

			$tee['tr']=$tr;
			$tee['output']=$output;
			$tee['return']=$retval;

		} catch (\Exception $e) {
			$tee['output']=$e->getMessage();
		}
		return $tee??[];
	}
}