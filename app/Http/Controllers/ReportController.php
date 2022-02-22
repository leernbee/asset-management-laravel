<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Check;
use App\Exports\ActivityExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:View reports', ['only' => ['activity', 'export']]);
    }
    //
    public function activity(Request $request)
    {
        // $field = $request->get('field') != '' ? $request->get('field') : 'id';
        // $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';


        // if ($field == "log_date") {
        //     $data = Check::orderBy('created_at', $sort);
        // } else {
        //     $data = Check::orderBy('created_at', 'desc');
        // }

        // $checks = $data->paginate(10)->withPath('?field=' . $field . '&sort=' . $sort);

        // return view('reports.activity', compact('checks'))
        //     ->withPath('?field=' . $field . '&sort=' . $sort);
        return view('reports.activity');
    }

    public function activityJson(Request $request)
    {
        if ($request->ajax()) {
            $data = Check::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('admin', function ($row) {

                    $data = $row->user->username;

                    return $data;
                })
                ->addColumn('action_date', function ($row) {

                    $data = $row->action_date->format('Y-m-d');

                    return $data;
                })
                ->addColumn('type', function ($row) {
                    $data = substr($row->checkable_type, 4);

                    return $data;
                })
                ->addColumn('item', function ($row) {
                    $data = $row->checkable->name;

                    return $data;
                })
                ->addColumn('target', function ($row) {
                    if ($row->targetable_type == 'App\User') {
                        $data = '<i class="fa fa-user"></i> ' . $row->targetable->first_name . ' ' . $row->targetable->last_name;
                    }
                    if ($row->targetable_type == 'App\Location') {
                        $data = '<i class="fa fa-map-marker"></i> ' .  $row->targetable->name;
                    }

                    if ($row->targetable_type == 'App\Machine') {
                        $data = '<i class="fa fa-desktop"></i> ' .  $row->targetable->name;
                    }

                    return $data;
                })
                ->rawColumns(['admin', 'action_date', 'type', 'item', 'target'])
                ->make(true);
        }
    }

    public function export()
    {
        return Excel::download(new ActivityExport, 'activity.xlsx');
    }
}
