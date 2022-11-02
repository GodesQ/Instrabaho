<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Skill;
use Yajra\DataTables\Facades\DataTables;

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
                        <a href="javascript:void(0)" class="edit datatable-btn datatable-btn-remove"><i class="fa fa-trash"></i></a>';
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

    public function update(Request $request) {
        $request->validate([
            'id' => 'required|exists:skills,id',
            'skill_name' => 'required|alpha'
        ]);

        Skill::where('id', $request->id)->update([
            'skill_name' => $request->skill_name
        ]);

        return back()->with('success', 'Skill Update Successfully');
    }
}
