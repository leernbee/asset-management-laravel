<?php

namespace App\Http\Controllers;

use App\OperatingSystem;
use Illuminate\Http\Request;

class OperatingSystemController extends Controller
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
        $operating_systems = OperatingSystem::orderBy('id', 'asc')->paginate(10);
        return view('operating-systems.index', compact('operating_systems'))
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
        return view('operating-systems.create');
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

        $operating_system = OperatingSystem::create($request->all());

        $operating_system->save();

        return redirect()->route('operating-systems.index')
            ->with('success', 'Operating System created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OperatingSystem  $operatingSystem
     * @return \Illuminate\Http\Response
     */
    public function show(OperatingSystem $operatingSystem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OperatingSystem  $operatingSystem
     * @return \Illuminate\Http\Response
     */
    public function edit(OperatingSystem $operatingSystem)
    {
        //
        return view('operating-systems.edit', compact('operatingSystem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OperatingSystem  $operatingSystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OperatingSystem $operatingSystem)
    {
        //
        request()->validate([
            'name' => 'required'
        ]);

        $operatingSystem->update($request->all());

        $operatingSystem->save();

        return redirect()->route('operating-systems.index')
            ->with('success', 'Operating System updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OperatingSystem  $operatingSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(OperatingSystem $operatingSystem)
    {
        //
        $operatingSystem->delete();

        return redirect()->route('operating-systems.index')
            ->with('success', 'Operating System deleted successfully');
    }
}
