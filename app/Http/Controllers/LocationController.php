<?php

namespace App\Http\Controllers;

use App\Location;
use App\User;
use Illuminate\Http\Request;
use DB;
use PragmaRX\Countries\Package\Countries;

class LocationController extends Controller
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
        $locations = Location::orderBy('id', 'asc')->paginate(10);
        return view('locations.index', compact('locations'))
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
        $locations = Location::pluck('name', 'id');
        $users = User::select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"),
            'id'
        )->pluck('name', 'id');
        $all = new Countries();
        $countries = $all->all()->pluck('name.common', 'name.common');

        return view('locations.create', compact('locations', 'users', 'countries'));
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

        $location = Location::create($request->all());

        $location->save();

        return redirect()->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
        $locations = Location::where('id', '!=', $location->id)->pluck('name', 'id');
        $users = User::select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"),
            'id'
        )->pluck('name', 'id');
        $all = new Countries();
        $countries = $all->all()->pluck('name.common', 'name.common');

        return view('locations.edit', compact('location', 'locations', 'users', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
        request()->validate([
            'name' => 'required'
        ]);

        $location->update($request->all());

        $location->save();

        return redirect()->route('locations.index')
            ->with('success', 'Location updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
        $location->delete();

        return redirect()->route('locations.index')
            ->with('success', 'Location deleted successfully');
    }
}
