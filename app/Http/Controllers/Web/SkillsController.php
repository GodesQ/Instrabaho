<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Skill;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Skill\StoreSkillRequest;
use App\Http\Requests\Skill\UpdateSkillRequest;

class SkillsController extends Controller
{
    public function index() {
        return view('AdminScreens.skills.skills');
    }

    public function data_table(Request $request) {
        if($request->ajax()) {
            $data = Skill::select('*')->latest('id');

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function($row) {
                return date_format($row->created_at, 'F d, Y');
            })
            ->addColumn('action', function($row) {
                $btn = '<button onclick="getSkill('.$row->id.')" class="edit-skill-btn datatable-btn datatable-btn-edit" data-toggle="modal" data-target="#inlineForm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button id="'.$row->id.'" class="delete-skill datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
        }
    }

    public function edit(Request $request) {
        $skill = Skill::where('id', $request->id)->first();
        return response()->json($skill);
    }

    public function update(UpdateSkillRequest $request) {
        $save = Skill::where('id', $request->id)->update(array_diff($request->validated(), [$request->id]));
        if($save) return back()->with('success', 'Skill Update Successfully');
    }

    public function store(StoreSkillRequest $request, Skill $skill) {
        // $save = $skill->create($request->validated());



        if($save) return back()->with('success', 'Skill Added Successfully');
    }

    public function destroy(Request $request) {
        abort_if(!$request->ajax(), 403);

        $delete = Skill::where('id', $request->id)->delete();
        if($delete) {
            return response()->json([
                'status' => 201,
                'message' => 'Deleted Successfully'
            ]);
        }
    }
}
