<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use App\Models\ServiceCategory;

class ServiceCategoriesController extends Controller
{
    public function index() {
        return view('AdminScreens.service_categories.service_categories');
    }

    public function data_table(Request $request) {
        abort_if(!$request->ajax(), 404);
        $data = ServiceCategory::select('*')->latest('id');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date_format($row->created_at, 'F d, Y');
                })
                ->addColumn('action', function($row) {
                    $btn = '<button onclick="getCategory('.$row->id.')" class="edit datatable-btn datatable-btn-edit" data-toggle="modal" data-target="#inlineForm"><i class="fa fa-edit"></i></button>
                            <button id="'. $row->id .'" class="delete-category datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
    }

    public function edit(Request $request) {
        $category = ServiceCategory::where('id', $request->id)->first();
        return response()->json($category);
    }

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:services_categories,id',
            'category_name' => 'required'
        ]);

        ServiceCategory::where('id', $request->id)->update([
            'name' => $request->category_name
        ]);

        return back()->with('success', 'Category Update Successfully');
    }

    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required'
        ]);

        ServiceCategory::create([
            'name' => $request->category_name
        ]);

        return back()->with('success', 'Category Added Successfully');
    }

    public function destroy(Request $request) {
        abort_if(!$request->ajax(), 403);

        $delete = ServiceCategory::where('id', $request->id)->delete();

        if($delete) {
            return response()->json([
                'status' => 201,
                'message' => 'Deleted Successfully'
            ]);
        }
    }

}