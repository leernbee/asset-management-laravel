<?php

namespace App\Http\Controllers;

use App\Machine;
use Illuminate\Http\Request;
use App\MachineType;
use App\Status;
use App\OperatingSystem;
use App\Check;
use App\Location;
use App\User;
use DB;
use Carbon;
use Auth;

class MachineController extends Controller
{
  function __construct()
  {
    $this->middleware(['auth', 'verified']);
    $this->middleware('permission:List machines|Create machines|Edit machines|Delete machines', ['only' => ['index', 'show']]);
    $this->middleware('permission:Create machines', ['only' => ['create', 'store']]);
    $this->middleware('permission:Edit machines', ['only' => ['edit', 'update']]);
    $this->middleware('permission:Delete machines', ['only' => ['destroy']]);
    $this->middleware('permission:Checkout/Checkin machines', ['only' => ['checkoutview', 'checkinview', 'checkout', 'checkin']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //
    $statusList = Status::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->pluck('name', 'id')->prepend('Show all Status', '');

    $status = $request->get('status') != '' ? $request->get('status') : '';
    $search = $request->get('search');
    $field = $request->get('field') != '' ? $request->get('field') : 'id';
    $sort = $request->get('sort') != '' ? $request->get('sort') : 'asc';

    if ($field == "name") {
      $data = Machine::orderBy('name', $sort);
    } else {
      $data = Machine::orderBy($field, $sort);
    }

    if ($status != '') {
      $data = $data
        ->whereStatusId($status)
        ->Where(DB::raw("CONCAT(`name`, ' ', `serial`, ' ', `machine_tag`)"), 'LIKE', "%" . $search . "%")
        ->paginate(10)
        ->withPath('?search=' . $search . '&status=' . $status . '&field=' . $field . '&sort=' . $sort);
    } else {
      $data = $data
        ->Where(DB::raw("CONCAT(`name`, ' ', `serial`, ' ', `machine_tag`)"), 'LIKE', "%" . $search . "%")
        ->paginate(10)
        ->withPath('?search=' . $search . '&status=' . $status . '&field=' . $field . '&sort=' . $sort);
    }

    return view('machines.index', compact('data'))
      ->with('i', (request()->input('page', 1) - 1) * 10)
      ->with('statusList', $statusList)->with('status', $status)
      ->withPath('?search=' . $search . '&status=' . $status . '&field=' . $field . '&sort=' . $sort);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $machine_types = MachineType::pluck('name', 'id')->prepend('Select a Machine Type', '');
    $operating_systems = OperatingSystem::pluck('name', 'id')->prepend('Select an Operating System', '');
    $statuses = Status::pluck('name', 'id')->prepend('Select a Status', '');
    $locations = Location::pluck('name', 'id')->prepend('Select a Location', '');

    return view('machines.create', compact('machine_types', 'operating_systems', 'statuses', 'locations'));
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
      'machine_tag' => 'required|unique:machines',
      'serial' => 'required',
      'meta_name.*'  => 'required',
      'meta_value.*'  => 'required',
      'machine_type_id' => 'required',
      'operating_system_id' => 'required',
      'status_id' => 'required',
      'location_id' => 'required'
    ]);

    $machine = Machine::create($request->all());

    if ($request->has('meta_name')) {
      $meta_name = $request->meta_name;
      $meta_value = $request->meta_value;

      for ($count = 0; $count < count($meta_name); $count++) {
        $machine->setMeta($meta_name[$count], $meta_value[$count]);
      }
    }

    $machine->save();

    return redirect()->route('machines.index')
      ->with('success', 'Machine created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Machine  $machine
   * @return \Illuminate\Http\Response
   */
  public function show(Machine $machine)
  {
    //
    $metas = $machine->getMeta()->toArray();
    $installs = Check::whereHasMorph('checkable', ['App\License'], function ($query) use ($machine) {
      $query->where('targetable_id', $machine->id)
        ->where('action_done', 0)
        ->where('action', 'install');
    })->get();

    $checkout = Check::whereHasMorph('checkable', ['App\Machine'], function ($query) use ($machine) {
      $query->where('checkable_id', $machine->id)
        ->where('action_done', 0)
        ->where('action', 'checkout');
    })->latest()->first();

    return view('machines.show', compact('machine', 'metas', 'installs', 'checkout'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Machine  $machine
   * @return \Illuminate\Http\Response
   */
  public function edit(Machine $machine)
  {
    //
    $metas = $machine->getMeta()->toArray();

    $machine_types = MachineType::pluck('name', 'id');
    $operating_systems = OperatingSystem::pluck('name', 'id');
    $statuses = Status::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');

    return view('machines.edit', compact('machine', 'metas', 'machine_types', 'operating_systems', 'statuses', 'locations'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Machine  $machine
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Machine $machine)
  {
    //
    request()->validate([
      'name' => 'required',
      'machine_tag' => 'required|unique:machines,machine_tag,' . $machine->id,
      'serial' => 'required',
      'meta_name.*'  => 'required',
      'meta_value.*'  => 'required',
      'machine_type_id' => 'required',
      'operating_system_id' => 'required',
      'status_id' => 'required',
      'location_id' => 'required'
    ]);


    $machine->update($request->all());

    $old_metas = $machine->getMeta();

    foreach ($old_metas as $key => $old_meta) {
      $machine->unsetMeta($key);
    }

    if ($request->has('meta_name')) {
      $meta_name = $request->meta_name;
      $meta_value = $request->meta_value;

      for ($count = 0; $count < count($meta_name); $count++) {
        $machine->setMeta($meta_name[$count], $meta_value[$count]);
      }
    }

    $machine->save();

    return redirect()->route('machines.index')
      ->with('success', 'Machine updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Machine  $machine
   * @return \Illuminate\Http\Response
   */
  public function destroy(Machine $machine)
  {
    //
    $machine->delete();

    return redirect()->route('machines.index')
      ->with('success', 'Machine deleted successfully');
  }

  public function checkinview(Machine $machine)
  {
    $locations = Location::pluck('name', 'id');
    $statuses = Status::pluck('name', 'id');

    return view('machines.checkin', compact('machine', 'locations', 'statuses'));
  }

  public function checkoutview(Machine $machine)
  {
    $locations = Location::pluck('name', 'id');
    $users = User::select(
      DB::raw("CONCAT(first_name,' ',last_name) AS name"),
      'id'
    )->pluck('name', 'id');

    return view('machines.checkout', compact('machine', 'locations', 'users'));
  }

  public function checkout(Request $request)
  {

    if ($request->location_id == null && $request->user_id == null) {
      $this->validate($request, [
        'checkout_date' => 'required',
        'location_id' => 'required',
        'user_id' => 'required'
      ]);
    } else {
      $this->validate($request, [
        'checkout_date' => 'required'
      ]);
    }

    $check = new Check;
    $check->user_id = Auth::user()->id;
    $check->action = 'checkout';

    if ($request->checkout_date == Carbon\Carbon::now()->format('m-d-Y')) {
      $check->action_date = Carbon\Carbon::now();
    } else {
      $check->action_date = Carbon\Carbon::createFromFormat('m-d-Y', $request->checkout_date)->format('Y-m-d');
    }

    $check->notes = $request->notes;

    if ($request->user_id !== null) {
      $check->targetable_id = $request->user_id;
      $check->targetable_type = 'App\User';
    }

    if ($request->location_id !== null) {
      $check->targetable_id = $request->location_id;
      $check->targetable_type = 'App\Location';
    }

    $machine = Machine::find($request->machine_id);
    $machine->checks()->save($check);

    return redirect()->route('machines.index')
      ->with('success', 'Machine checkout successfully');
  }

  public function checkin(Request $request)
  {
    //dd($request);
    $this->validate($request, [
      'checkin_date' => 'required',
      'location_id' => 'required',
      'status' => 'required'
    ]);

    $check = new Check;
    $check->user_id = Auth::user()->id;
    $check->action = 'checkin';

    if ($request->checkin_date == Carbon\Carbon::now()->format('m-d-Y')) {
      $check->action_date = Carbon\Carbon::now();
    } else {
      $check->action_date = Carbon\Carbon::createFromFormat('m-d-Y', $request->checkin_date)->format('Y-m-d');
    }

    $check->notes = $request->notes;

    $check->targetable_id = $request->location_id;
    $check->targetable_type = 'App\Location';

    $machine = Machine::find($request->machine_id);
    $machine->checks()->save($check);

    $machine->status_id = $request->status;
    $machine->save();

    $prev_check = Check::whereAction('checkout')->whereCheckableId($request->machine_id)->latest()->first();
    $prev_check->action_done = 1;
    $prev_check->save();

    return redirect()->route('machines.index')
      ->with('success', 'Machine checkin successfully');
  }
}
