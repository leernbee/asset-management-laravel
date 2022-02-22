<?php

namespace App\Http\Controllers;

use App\License;
use App\SoftwareType;
use App\Machine;
use App\Check;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon;
use Redirect;
use Session;
use URL;

class LicenseController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:List licenses|Create licenses|Edit licenses|Delete licenses', ['only' => ['index', 'show']]);
        $this->middleware('permission:Create licenses', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit licenses', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete licenses', ['only' => ['destroy']]);
        $this->middleware('permission:Install/Uninstall licenses', ['only' => ['installview', 'uninstallview', 'install', 'uninstall']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $softwareList = SoftwareType::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id')->prepend('Show all Types', '');

        $type = $request->get('type') != '' ? $request->get('type') : '';
        $search = $request->get('search');
        $field = $request->get('field') != '' ? $request->get('field') : 'id';
        $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';

        if ($field == "name") {
            $data = License::orderBy('name', $sort);
        } else {
            $data = License::orderBy($field, $sort);
        }

        if ($type != '') {
            $data = $data
                ->whereSoftwareTypeId($type)
                ->Where(DB::raw("CONCAT(`name`, ' ', `vendor`)"), 'LIKE', "%" . $search . "%")
                ->paginate(5)
                ->withPath('?search=' . $search . '&type=' . $type . '&field=' . $field . '&sort=' . $sort);
        } else {
            $data = $data
                ->Where(DB::raw("CONCAT(`name`, ' ', `vendor`)"), 'LIKE', "%" . $search . "%")
                ->paginate(5)
                ->withPath('?search=' . $search . '&type=' . $type . '&field=' . $field . '&sort=' . $sort);
        }

        return view('licenses.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5)
            ->with('softwareList', $softwareList)->with('type', $type)
            ->withPath('?search=' . $search . '&type=' . $type . '&field=' . $field . '&sort=' . $sort);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $software_types = SoftwareType::pluck('name', 'id')->prepend('Select a Software Type', '');

        return view('licenses.create', compact('software_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'name' => 'required',
            'software_type_id' => 'required',
            'seats' => 'required|numeric',
            'version' => 'required'
        ]);

        $license = License::create($request->all());

        return redirect()->route('licenses.index')
            ->with('success', 'License created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function show(License $license)
    {
        //
        $installs = Check::whereHasMorph('checkable', ['App\License'], function ($query) use ($license) {
            $query->where('checkable_id', $license->id)
                ->where('action_done', 0)
                ->where('action', 'install');
        })->get();

        return view('licenses.show', compact('license', 'installs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function edit(License $license)
    {
        //
        $software_types = SoftwareType::pluck('name', 'id')->prepend('Select a Software Type', '');
        return view('licenses.edit', compact('license', 'software_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, License $license)
    {
        //
        request()->validate([
            'name' => 'required',
            'software_type_id' => 'required',
            'seats' => 'required|numeric',
            'version' => 'required'
        ]);

        $license->update($request->all());

        return redirect()->route('licenses.index')
            ->with('success', 'License updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy(License $license)
    {
        //
        $license->delete();

        return redirect()->route('licenses.index')
            ->with('success', 'License deleted successfully');
    }

    public function uninstallview($id)
    {
        Session::put('requestReferrer', URL::previous());

        $check = Check::find($id);

        return view('licenses.uninstall', compact('check'));
    }

    public function installview(License $license)
    {
        Session::put('requestReferrer', URL::previous());

        $machines = Machine::select(
            DB::raw("CONCAT(machine_tag,' - ',name) AS name"),
            'id'
        )
            ->pluck('name', 'id');

        return view('licenses.install', compact('license', 'machines'));
    }

    public function uninstall(Request $request)
    {
        $check = new Check;
        $check->user_id = Auth::user()->id;
        $check->action = 'uninstall';
        $check->action_date = Carbon\Carbon::now();
        $check->notes = $request->notes;

        $check->targetable_id = $request->machine_id;
        $check->targetable_type = 'App\Machine';

        $license = License::find($request->license_id);
        $license->seats = $license->seats + 1;
        $license->save();
        $license->checks()->save($check);

        $prev_check = Check::find($request->check_id);
        $prev_check->action_done = 1;
        $prev_check->save();

        return redirect(Session::get('requestReferrer'))
            ->with('success', 'License uninstall successfully');
    }

    public function install(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'install_date' => 'required',
            'machine_id' => 'required',
        ]);

        $check = new Check;
        $check->user_id = Auth::user()->id;
        $check->action = 'install';

        if ($request->install_date == Carbon\Carbon::now()->format('m-d-Y')) {
            $check->action_date = Carbon\Carbon::now();
        } else {
            $check->action_date = Carbon\Carbon::createFromFormat('m-d-Y', $request->install_date)->format('Y-m-d');
        }

        $check->notes = $request->notes;

        $check->targetable_id = $request->machine_id;
        $check->targetable_type = 'App\Machine';

        $license = License::find($request->license_id);
        $license->seats = $license->seats - 1;
        $license->save();
        $license->checks()->save($check);

        return redirect(Session::get('requestReferrer'))
            ->with('success', 'License install successfully');
    }
}
