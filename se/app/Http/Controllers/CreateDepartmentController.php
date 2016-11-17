<?php

namespace App\Http\Controllers;

use App\Model\Department;
use Request;

class CreateDepartmentController extends Controller
{
	public function create_department_form()
	{
		$create_dep_error = 0;
		return view('admin.createDepartment', compact('create_dep_error'));
	}
	public function create_department()
	{
		$input = Request::all();
		if($input['departmentName'] == '' or $input['location'] == ''){
			session()->flash('create_dep_error', 1);
			return redirect('createDepartment');
		}
		$new_department = new Department;
		if(count(Department::where('departmentName',$input['departmentName'])->get()) > 0){
			session()->flash('create_dep_error', 2);
			return redirect('createDepartment');
		}
		$new_department->departmentName = $input['departmentName'];
		$new_department->location = $input['location'];
		$new_department->save();
		return redirect('manageDepartment');
	}
}
