<?php

namespace App\Http\Controllers;

use App\Model\Department;
use Request;

class ManageDepartmentController extends Controller
{
    public function display_all_department()
    {
    	$input = Request::all();
    	$departments = Department::all();
    	if(count($input) == 0 or $input['dep_name'] == ''){
    		$departmentName = 'ทั้งหมด';
    		for($i = 0; $i < count($departments); $i++){
	    		$departments[$i]['index'] = $i + 1; 
	    	}
	    	return view('admin.manageDepartment', compact('departments', 'departmentName'));
    	}
    	$departmentName = strtolower($input['dep_name']);
    	$matched_departments = [];
    	for($i = 0; $i < count($departments); $i++){
    		$dep_db = strtolower($departments[$i]['departmentName']);
    		if(strpos($dep_db, $departmentName) !== False){
    			array_push($matched_departments, $departments[$i]);
    		}
	    }
	    for($i = 0; $i < count($matched_departments); $i++){
	    	$matched_departments[$i]['index'] = $i + 1; 
	    }
	    $departments = $matched_departments;
        $departmentName = $input['dep_name'];
    	return view('admin.manageDepartment', compact('departments', 'departmentName'));
    }
    public function edit_department()
    {
        $input = Request::all();
        if($input['operation'] == 'change_name'){
            if(count(Department::where('departmentName',$input['new_name'])->get()) > 0){
                session()->flash('edit_dep_error', 1);
                return redirect('manageDepartment');
            }
            $target_dep = Department::where('departmentName', $input['old_name'])->first();
            $target_dep->departmentName = $input['new_name'];
            $target_dep->save();
        }
        else if($input['operation'] == 'delete'){
            $target_dep = Department::where('departmentName', $input['name'])->first();
            $doc = $target_dep->doctor;
            $nur = $target_dep->nurse;
            if(sizeof($doc) > 0 or sizeof($nur) > 0){
                session()->flash('edit_dep_error', 2);
                return redirect('manageDepartment');
            }

            $target_dep->delete();
        }
        return redirect('manageDepartment');
    }
}
