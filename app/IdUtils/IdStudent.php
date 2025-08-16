<?php

namespace App\IdUtils;
use Str;
/**
 * IdStudent.php
 */
class IdStudent
{
	public $nerotech;
	
	function __construct()
	{
		# code...
		$this->nerotech='/var/www/html/alive/cdn/Bin/Java';
	}
	public static function fromFreshCapture($tee){
		$tempId=str_replace('-', '', Str::uuid()) ;

		$n=new IdStudent();

		/*this command verifies that the image supplied has the same face as subject id supplied */
		$tr2='cd '.$n->nerotech.'; java -jar identify-face.jar '.$request->employee_id.'.jpg '.$tee['nfile'];



		exec($tr2, $output, $retval);
		$tee['tr2']=$tr2;
		$tee['outputx']=$output;
		$tee['returnx']=$retval;

		$tee['vdate']=date('d/m/Y',time());


		$unsuccessful = array(); 
		foreach ($output as $value) { 
		  if (strpos($value, 'unsuccessful') !== false) { $unsuccessful[] = $value; } 
		  if (strpos($value, 'Failed') !== false) { $unsuccessful[] = $value; }  
		  if (strpos($value, 'Extraction failed') !== false) { $unsuccessful[] = $value; }   
		  if (strpos($value, 'OBJECT_NOT_FOUND') !== false) { $unsuccessful[] = $value; }   
		  if (strpos($value, 'Match not found') !== false) { $unsuccessful[] = $value; }   
		  //OBJECT_NOT_FOUND Match not found
		}
		$successful = array(); //successfull is identified with Matched keyword
		foreach ($output as $value) { 
		  if (strpos($value, 'Matched') !== false) { $successful[] = $value; } 
		}

		unlink($n->nerotech.$tee['nfile']));

		$tee['last_message']=$output[count($output)-1];

		if( empty($unsuccessful) ) { 
			//echo 'successful found.'; 

			if( empty($successful) ) { 
				//echo 'error found.'; 
				$tee['successful']="no";
				$tee['error']="yes";
			}else{
				/*try{
					Verified::create(['employee_id'=>$request->employee_id,'log'=>json_encode([$output,$retval])]);
				}catch(\Exception $e){

				}*/
				$tee['last_message']="Data verified and Confirmed";
				$tee['successful']="yes";
				$tee['error']="no";
			}
			
		}else {
				$tee['error']="yes";
				$tee['successful']="no";
		}

		return $tee;

	}
}