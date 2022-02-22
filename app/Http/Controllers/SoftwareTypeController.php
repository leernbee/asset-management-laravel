<?php

namespace App\Http\Controllers;

use App\SoftwareType;
use Illuminate\Http\Request;

class SoftwareTypeController extends Controller
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
        $software_types = SoftwareType::orderBy('id', 'asc')->paginate(10);
        return view('software-types.index', compact('software_types'))
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
        return view('software-types.create');
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

        $software_type = SoftwareType::create($request->all());

        $software_type->save();

        return redirect()->route('software-types.index')
            ->with('success', 'Software Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SoftwareType $softwareType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SoftwareType $softwareType)
    {
        //
        return view('software-types.edit', compact('softwareType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SoftwareType $softwareType)
    {
        //
        request()->validate([
            'name' => 'required'
        ]);

        $softwareType->update($request->all());

        $softwareType->save();

        return redirect()->route('software-types.index')
            ->with('success', 'Software Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoftwareType $softwareType)
    {
        //
        $softwareType->delete();

        return redirect()->route('software-types.index')
            ->with('success', 'Software Type deleted successfully');
    }
}
