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
        $data = ServiceCategory::select('*');
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function($row) {
                    return date_format($row->created_at, 'F d, Y');
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="/admin/employer_packages/edit/'. $row->id .'" class="edit btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)" class="edit btn btn-danger"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
    }
    
}