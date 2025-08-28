<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\{CaptureLog,Student};
use Illuminate\Support\Facades\Storage;
use App\IdUtils\{IdStudent,EnrolStudent};
use Str;

class CaptureCtrl extends Controller
{

	public function index(Request $request): Response
    {
        return Inertia::render('Capture/Index', [
        	'ds'=>'s'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $path = $request->file('photo')->store('captures', 'public');
        $file = $request->file('photo');
        $path2 =  $file->store('', 'external'); 



		/*$probe=$request->photo->hashName(); 
		$status=null;
		$sid=null;
        if ($tq) { 
        	$r=explode('.', $probe);//.jpg expected always
        	$sid=$r[0];
        	$status=EnrolStudent::makeNewTemplate($sid);
        	//remove file from external disk
        	if (Storage::disk('external')->exists($path2)) {
		        Storage::disk('external')->delete($path2); 
		    }
        }*/

        return response()->json([
            'message' => 'Photo uploaded successfully',
            'url' => asset("storage/{$path}"), 
    		'path' => $path, // <--- include relative path for deletion
    		'extpath' => $path2,
    		//'status' => $status,
    		//'sid' => $sid
        ]);
    }

    public function enroll(Request $request){

        $request->validate([
            'path' => 'required|string',
        ]);

        $imagePath = $request->path;//storage_path('app/' . $path);
        $templateId= str_replace('-', '', Str::uuid()) ;
        $outPath = config('services.java_face_enroll.out_path');

        $cl=CaptureLog::create([
            'user_id'=>$request->user()->id,
            'subject_id'=>$templateId,
            'capture_path'=>$imagePath,
            //'status'
        ]);

        /*$service = new \App\Services\JavaFaceEnrollService2();
        $result = $service->enroll($imagePath,$templateId);
        */

        $service = new \App\Services\JavaFaceEnrollService3();
        $result = $service->enroll(
                $request->input('server')??null,
                $request->input('client_port')??null,$imagePath,$templateId);

        $c=CaptureLog::find($cl->id);
        
        $outputs=[];
        if ($result['success']) { 
            $c->status="success";

            try {
                $service2 = new \App\Services\JavaTemplateEnrollService();
                $output = $service2->enroll(
                    $request->input('server')??null,
                    $request->input('client_port')??null,
                    $templateId
                );


                if ($output['success']) { 
                    $c->status="success";
                }else{
                    $c->status="failed";
                }

                $outputs[]=$output;
                $c->notes=$outputs;
                $c->save();


                $record=Student::create([
                    'photo' => asset("storage/captures/{$imagePath}"),
                    'user_id'=>$request->user()->id,
                    'subject_id'=>$templateId,
                ]);


                return response()->json([
                    'status' => 'success',
                    'output' => $output,
                    'record'=>$record
                ]);
            } catch (\Exception $e) {

                $outputs[]=$e->getMessage();
                $c->notes=$outputs;
                $c->save();

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
                //], 500);
            }  

        }else{
            //$c->status="failed";
            $outputs[]=$result;
            $c->notes=$outputs;
            $c->save();
        }


        return response()->json($result);

    }

    public function destroy(Request $request)
	{
	    $request->validate([
	        'path' => 'required|string',
	    ]);

	    $relativePath = str_replace(asset('storage') . '/', '', $request->path);

	    if (Storage::disk('public')->exists($relativePath)) {
	        Storage::disk('public')->delete($relativePath);
	        return response()->json(['message' => 'Photo deleted']);
	    }

	    return response()->json(['message' => 'File not found'], 404);
	}


}