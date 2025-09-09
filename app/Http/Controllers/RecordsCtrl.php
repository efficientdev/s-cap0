<?php
//RecordsCtrl.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\{CaptureLog,Student,StatesAndLgas,School,ClassList};
use Illuminate\Support\Facades\Storage;
use App\IdUtils\{IdStudent,EnrolStudent};
use Str;

class RecordsCtrl extends Controller
{

	public function index(Request $request): Response
    {
    	$data['reports']=Student::where('user_id',$request->user()->id)
	    	//->where('status','success')
	    	->latest()
	    	->paginate(200);
	    $data['sl']=StatesAndLgas::get()->keyBy('id');
        return Inertia::render('Record/Index', $data);
    }

	public function show(Request $request,$id): Response
    {
    	$data['report']=Student::where('user_id',$request->user()->id)
    		->where('id',$id)
	    	//->where('status','success')
	    	->first();
	    $data['sl']=StatesAndLgas::get()->keyBy('id');

        $data['schools']=School::get()->keyBy('id');
        $data['classes']=ClassList::get()->keyBy('id');



        return Inertia::render('Record/Show', $data);
    }

	public function edit(Request $request,$id): Response
    {
	    $data['sl']=StatesAndLgas::get()->keyBy('id');

        $data['schools']=School::get()->keyBy('id');
        $data['classes']=ClassList::get()->keyBy('id');
	    
    	$data['report']=Student::where('user_id',$request->user()->id)
    		->where('id',$id)
	    	//->where('status','success')
	    	->first();
        return Inertia::render('Record/Edit', $data);
    }

	public function update(Request $request,$id)
    {

       
        $validator = Validator::make($request->all(), [ 
            'first_name'            => 'required',
            'middle_name'           => 'required',  
            'last_name'           => 'required',  
            'state_id'            => 'required',
            'lga_id'           => 'required',  
            'school_id'           => 'required',  
            'class_list_id'           => 'required',  
        ]);

    	$meta=$request->all();
    	$data['report']=Student::where('user_id',$request->user()->id)
    		->where('id',$id)
	    	//->where('status','success')
	    	->first();
	    	$data['report']->meta=$meta;
	    	$data['report']->save();

        //return Inertia::render('Record/Edit', $data);
        return back()->with('success', 'Record Updated successfully.'); 
    }

    public function destroy(Student $record)
    {
        $record->delete();
        return back()->with('success', 'Record deleted successfully.');
    }



}