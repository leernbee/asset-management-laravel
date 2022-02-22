<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machine;
use App\License;
use App\Check;
use DB;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $machines = Machine::all();
        $machinesCount = $machines->count();

        $licenses = License::all();
        $licensesCount = $licenses->sum('seats');

        $checkouts = Check::whereAction('checkout')->whereActionDone(0)->get();
        $checkoutsCount = $checkouts->count();

        $installs = Check::whereAction('install')->whereActionDone(0)->get();
        $installsCount = $installs->count();

        $machines = Check::whereHasMorph('checkable', ['App\Machine'], function ($query) {
            $query->where('targetable_id', Auth::user()->id)
                ->where('action_done', 0)
                ->where('action', 'checkout');
        })->latest()->get();

        return view('dashboard', compact('machinesCount', 'licensesCount', 'checkoutsCount', 'installsCount', 'machines'));
    }

    public function chartMachineTypes()
    {
        $getData = DB::table('machines')
            ->join('machine_types', 'machines.machine_type_id', '=', 'machine_types.id')
            ->select('machine_types.name as label', DB::raw('count(*) as total'))
            ->groupBy('label')
            ->get();

        return response()
            ->json($getData);
    }

    public function chartSoftwareTypes()
    {
        $getData = DB::table('licenses')
            ->join('software_types', 'licenses.software_type_id', '=', 'software_types.id')
            ->select('software_types.name as label', DB::raw('count(*) as total'))
            ->groupBy('label')
            ->get();

        return response()
            ->json($getData);
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
