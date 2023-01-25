<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::select('id', 'name', 'email', 'image')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/company/' . $row->id . '" class="btn btn-primary btn-sm"><span class="fas fa-eye"></span></a>
                 <form action="/company/' . $row->id . '" style="width:30px;margin:0" method="POST">' . csrf_field() . '<button class="btn btn-danger btn-sm" type="submit"><span class="fas fa-trash"></span></button></form>
<a href="/company/' . $row->id . '/edit" class="btn btn-secondary btn-sm"><span class="fas fa-pen"></span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('company.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required | max:255',
            'coordinate_x'=>'required | max:255',
            'coordinate_y'=>'required | max:255',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);
        $image = $request->file('image');
        $input['file'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/storage/image');
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['file']);
        $destinationPath = public_path('/uploads');
        $image->move($destinationPath, $input['file']);

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'coordinate_x' => $request->coordinate_x,
            'coordinate_y' => $request->coordinate_y,
            'image' => $input['file'],
        ]);

        return view('company.index')->with('success','Company has created');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $company = Company::query()->with('employees')->findOrFail($id);

        return view('company.show',compact('company'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $company = Company::query()->findOrFail($id);

        return view('company.edit',compact('company'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,$id)
    {
        Company::query()->where('id','=',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'coordinate_x' => $request->coordinate_x,
            'coordinate_y' => $request->coordinate_y,
        ]);

        return redirect('company')->with('success','Employee has updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $employee = Company::findOrFail($id);
        $employee->delete();

        return redirect('/company');
    }
}
