<?php 
//StateCtrl.php 

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\{CaptureLog,StatesAndLgas,StateList};
use Illuminate\Support\Facades\Storage;
use App\IdUtils\{IdStudent,EnrolStudent};
use Str;

class Statel extends Controller
{

	public function index(){
		//StatesAndLgas

		$fs=$this->thislist();
		for ($i=2; $i <= count($fs); $i++) {  

			StateList::updateOrCreate([
				'name'=>$fs[$i]['B'],
				'abbreviation'=>$fs[$i]['C']
			],[]);
 
		}
	}
	protected function thislist(){

        return   array (
  1 => 
  array (
    'A' => 'state_id',
    'B' => 'name',
    'C' => 'abbreviation',
  ),
  2 => 
  array (
    'A' => '1',
    'B' => 'Abia',
    'C' => 'AB',
  ),
  3 => 
  array (
    'A' => '2',
    'B' => 'Adamawa',
    'C' => 'AD',
  ),
  4 => 
  array (
    'A' => '3',
    'B' => 'AkwaIbom',
    'C' => 'AK',
  ),
  5 => 
  array (
    'A' => '4',
    'B' => 'Anambra',
    'C' => 'AN',
  ),
  6 => 
  array (
    'A' => '5',
    'B' => 'Bauchi',
    'C' => 'BC',
  ),
  7 => 
  array (
    'A' => '6',
    'B' => 'Bayelsa',
    'C' => 'BY',
  ),
  8 => 
  array (
    'A' => '7',
    'B' => 'Benue',
    'C' => 'BN',
  ),
  9 => 
  array (
    'A' => '8',
    'B' => 'Borno',
    'C' => 'BR',
  ),
  10 => 
  array (
    'A' => '9',
    'B' => 'Cross River',
    'C' => 'CR',
  ),
  11 => 
  array (
    'A' => '10',
    'B' => 'Delta',
    'C' => 'DT',
  ),
  12 => 
  array (
    'A' => '11',
    'B' => 'Ebonyi',
    'C' => 'EB',
  ),
  13 => 
  array (
    'A' => '12',
    'B' => 'Edo',
    'C' => 'ED',
  ),
  14 => 
  array (
    'A' => '13',
    'B' => 'Ekiti',
    'C' => 'EK',
  ),
  15 => 
  array (
    'A' => '14',
    'B' => 'Enugu',
    'C' => 'EN',
  ),
  16 => 
  array (
    'A' => '15',
    'B' => 'Abuja',
    'C' => 'FC',
  ),
  17 => 
  array (
    'A' => '16',
    'B' => 'Gombe',
    'C' => 'GO',
  ),
  18 => 
  array (
    'A' => '17',
    'B' => 'Imo',
    'C' => 'IM',
  ),
  19 => 
  array (
    'A' => '18',
    'B' => 'Jigawa',
    'C' => 'JG',
  ),
  20 => 
  array (
    'A' => '19',
    'B' => 'Kaduna',
    'C' => 'KN',
  ),
  21 => 
  array (
    'A' => '20',
    'B' => 'Kano',
    'C' => 'KA',
  ),
  22 => 
  array (
    'A' => '21',
    'B' => 'Katsina',
    'C' => 'KT',
  ),
  23 => 
  array (
    'A' => '22',
    'B' => 'Kebbi',
    'C' => 'KB',
  ),
  24 => 
  array (
    'A' => '23',
    'B' => 'Kogi',
    'C' => 'KO',
  ),
  25 => 
  array (
    'A' => '24',
    'B' => 'Kwara',
    'C' => 'KW',
  ),
  26 => 
  array (
    'A' => '25',
    'B' => 'Lagos',
    'C' => 'LA',
  ),
  27 => 
  array (
    'A' => '26',
    'B' => 'Nasarawa',
    'C' => 'NA',
  ),
  28 => 
  array (
    'A' => '27',
    'B' => 'Niger',
    'C' => 'NG',
  ),
  29 => 
  array (
    'A' => '28',
    'B' => 'Ogun',
    'C' => 'OG',
  ),
  30 => 
  array (
    'A' => '29',
    'B' => 'Ondo',
    'C' => 'ON',
  ),
  31 => 
  array (
    'A' => '30',
    'B' => 'Osun',
    'C' => 'OS',
  ),
  32 => 
  array (
    'A' => '31',
    'B' => 'Oyo',
    'C' => 'OY',
  ),
  33 => 
  array (
    'A' => '32',
    'B' => 'Plateau',
    'C' => 'PL',
  ),
  34 => 
  array (
    'A' => '33',
    'B' => 'Rivers',
    'C' => 'RV',
  ),
  35 => 
  array (
    'A' => '34',
    'B' => 'Sokoto',
    'C' => 'SK',
  ),
  36 => 
  array (
    'A' => '35',
    'B' => 'Taraba',
    'C' => 'TR',
  ),
  37 => 
  array (
    'A' => '36',
    'B' => 'Yobe',
    'C' => 'YO',
  ),
  38 => 
  array (
    'A' => '37',
    'B' => 'Zamfara',
    'C' => 'ZM',
  ),
);
	}
}