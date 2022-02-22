<?php

namespace App\Http\Controllers;

use App\MachineType;
use Illuminate\Http\Request;

class MachineTypeController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:Administer settings');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $machine_types = MachineType::orderBy('id', 'asc')->paginate(10);
        return view('machine-types.index', compact('machine_types'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('machine-types.create');
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
            'name' => 'required'
        ]);

        $machine_type = MachineType::create($request->all());

        $machine_type->save();

        return redirect()->route('machine-types.index')
            ->with('success', 'Machine Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MachineType  $machineType
     * @return \Illuminate\Http\Response
     */
    public function show(MachineType $machineType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MachineType  $machineType
     * @return \Illuminate\Http\Response
     */
    public function edit(MachineType $machineType)
    {
        //
        return view('machine-types.edit', compact('machineType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MachineType  $machineType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MachineType $machineType)
    {
        //
        request()->validate([
            'name' => 'required'
        ]);

        $machineType->update($request->all());

        $machineType->save();

        return redirect()->route('machine-types.index')
            ->with('success', 'Machine Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MachineType  $machineType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MachineType $machineType)
    {
        //
        $machineType->delete();

        return redirect()->route('machine-types.index')
            ->with('success', 'Machine Type deleted successfully');
    }
}
