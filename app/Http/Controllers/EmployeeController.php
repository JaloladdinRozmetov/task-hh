<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::select('id','name','email','phone_number')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="/employees/'.$row->id.'" class="btn btn-primary btn-sm"><span class="fas fa-eye"></span></a>
                 <form action="/employees/'.$row->id.'" style="width:30px;margin:0" method="POST">'.csrf_field().'<button class="btn btn-danger btn-sm" type="submit"><span class="fas fa-trash"></span></button></form>
<a href="/employees/'.$row->id.'/edit" class="btn btn-secondary btn-sm"><span class="fas fa-pen"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('employee.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = Company::query()->get();

        return view('employee.create',compact('companies'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required | max:255',
            'email'=>'required | email | max:255',
            'phone_number'=>'required | max:15',
        ]);
        Employee::create($request->all());

        return view('employee.index')->with('success','Employee has created');
    }

    /**
     * @param Employee $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $employee = Employee::query()->with('company')->findOrFail($id);

     return view('employee.show',compact('employee'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $companies = Company::query()->get();
        $employee = Employee::query()->with('company')->findOrFail($id);

        return view('employee.edit',compact('employee','companies'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>'required | max:255',
            'email'=>'required | email | max:255',
            'phone_number'=>'required | max:255'
        ]);
        Employee::query()->where('id','=',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'company_id' => $request->company_id
        ]);

        return redirect('employees')->with('success','Employee has updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect('/employees');
    }
}
