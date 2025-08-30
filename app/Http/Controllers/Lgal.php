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
use App\Models\{CaptureLog,StatesAndLgas,LgaList};
use Illuminate\Support\Facades\Storage;
use App\IdUtils\{IdStudent,EnrolStudent};
use Str;

class Lgal extends Controller
{

	public function index(){
		//StatesAndLgas

		$fs=$this->thislist();
		for ($i=2; $i <= count($fs); $i++) {  

			LgaList::updateOrCreate([
				'lga_name'=>$fs[$i]['B'],
				'abbreviations'=>$fs[$i]['C']
			],[]);
 
		}
	}
	protected function thislist(){

        return  array (
  1 => 
  array (
    'A' => 'lga_id',
    'B' => 'lga_name',
    'C' => 'abbreviations',
  ),
  2 => 
  array (
    'A' => '1',
    'B' => 'Akoko Edo',
    'C' => 'AKK',
  ),
  3 => 
  array (
    'A' => '2',
    'B' => 'Egor',
    'C' => 'EGR',
  ),
  4 => 
  array (
    'A' => '3',
    'B' => 'Esan Central',
    'C' => 'ESC',
  ),
  5 => 
  array (
    'A' => '4',
    'B' => 'Esan North East',
    'C' => 'ENE',
  ),
  6 => 
  array (
    'A' => '5',
    'B' => 'Esan South East',
    'C' => 'ESE',
  ),
  7 => 
  array (
    'A' => '6',
    'B' => 'Esan West',
    'C' => 'ESW',
  ),
  8 => 
  array (
    'A' => '7',
    'B' => 'Etsako Central',
    'C' => 'ETC',
  ),
  9 => 
  array (
    'A' => '8',
    'B' => 'Etsako East',
    'C' => 'ETE',
  ),
  10 => 
  array (
    'A' => '9',
    'B' => 'Etsako West',
    'C' => 'ETW',
  ),
  11 => 
  array (
    'A' => '10',
    'B' => 'Igueben',
    'C' => 'IGU',
  ),
  12 => 
  array (
    'A' => '11',
    'B' => 'Ikpoba Okha',
    'C' => 'IKP',
  ),
  13 => 
  array (
    'A' => '12',
    'B' => 'Oredo',
    'C' => 'ORD',
  ),
  14 => 
  array (
    'A' => '13',
    'B' => 'Orhionmwon',
    'C' => 'ORH',
  ),
  15 => 
  array (
    'A' => '14',
    'B' => 'Ovia North East',
    'C' => 'ONE',
  ),
  16 => 
  array (
    'A' => '15',
    'B' => 'Ovia South West',
    'C' => 'OSW',
  ),
  17 => 
  array (
    'A' => '16',
    'B' => 'Owan East',
    'C' => 'OWE',
  ),
  18 => 
  array (
    'A' => '17',
    'B' => 'Owan West',
    'C' => 'OWW',
  ),
  19 => 
  array (
    'A' => '18',
    'B' => 'Uhunmwonde',
    'C' => 'UHU',
  ),
);
	}
}