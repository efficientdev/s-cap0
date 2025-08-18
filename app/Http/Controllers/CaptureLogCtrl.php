<?php
//CaptureLogCtrl.php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\CaptureLog;
use Illuminate\Support\Facades\Storage;
use App\IdUtils\{IdStudent,EnrolStudent};

class CaptureLogCtrl extends Controller
{

	public function index(Request $request){
		$data['report']=CaptureLog::where('user_id',$request->user()->id)->latest()->paginate(20);
		return Inertia::render('CLog/Index', $data);
	}

}