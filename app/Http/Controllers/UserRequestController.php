<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRequest;
use App\User;
use Auth;
use DB;
use App\Events\RequestEvent;
use Notification;
use App\Notifications\RequestNotification;

class UserRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:Administer requests', ['only' => ['edit', 'update', 'destroy']]);
        $this->middleware('permission:Administer work orders', ['only' => ['workOrders', 'updateWorkOrders']]);
    }
    //
    public function index(Request $request)
    {
        if (Auth::user()->can('Administer requests')) {
            $requests = UserRequest::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $requests = UserRequest::orderBy('created_at', 'desc')->whereRequesterId(Auth::user()->id)->paginate(10);
        }

        return view('requests.index', compact('requests'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function workOrders(Request $request)
    {
        $requests = UserRequest::orderBy('created_at', 'desc')->whereWorkerId(Auth::user()->id)->paginate(10);

        return view('requests.work_orders', compact('requests'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function updateWorkOrders(Request $request)
    {
        $userRequest = UserRequest::find($request->request_id);
        $userRequest->work_status = $request->status;
        $userRequest->save();

        return response()->json(['success' => 'Request updated successfully'], 200);
    }

    public function show($id)
    {
        $userRequest = UserRequest::find($id);
        return view('requests.show', compact('userRequest'));
    }

    public function create()
    {
        return view('requests.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $userRequest = new UserRequest;
        $userRequest->ticket_id = strtoupper(uniqid());
        $userRequest->title = $request->title;
        $userRequest->description = $request->description;
        $userRequest->priority = $request->priority;
        $userRequest->requester_id = Auth::user()->id;
        $userRequest->save();

        $managers = User::whereHas("roles", function ($q) {
            $q->where("name", "Asset Manager");
        })->get();

        $details = [
            'message' => 'There is a new request.'
        ];

        foreach ($managers as $manager) {
            broadcast(new RequestEvent($manager, 'There is a new request.'));
            Notification::send($manager, new RequestNotification($details));
        }

        return redirect()->route('requests.index')
            ->with('success', 'Request created successfully');
    }

    public function destroy($id)
    {
        $userRequest = UserRequest::find($id);
        $userRequest->delete();

        return redirect()->route('requests.index')
            ->with('success', 'Request deleted successfully');
    }

    public function edit($id)
    {
        $userRequest = UserRequest::find($id);
        $workers = User::role('IT Support')->select(
            DB::raw("CONCAT(first_name,' ',last_name) AS name"),
            'id'
        )->pluck('name', 'id');

        return view('requests.edit', compact('userRequest', 'workers'));
    }

    public function update(Request $request, $id)
    {
        if ($request->submit == 'Approve' || $request->submit == 'Update') {
            request()->validate([
                'title' => 'required',
                'description' => 'required',
                'worker_id' => 'required'
            ]);
        } else {
            request()->validate([
                'title' => 'required',
                'description' => 'required'
            ]);
        }

        $userRequest = UserRequest::find($id);
        $userRequest->title = $request->title;
        $userRequest->description = $request->description;
        $userRequest->priority = $request->priority;

        if ($request->submit == 'Approve') {
            $userRequest->worker_id = $request->worker_id;
            $userRequest->work_status = 'Open';
            $userRequest->status = 'Approved';

            $user = Auth::user();

            $user->messages()->create([
                'message' => 'You request has been approved.',
                'request_id' => $id
            ]);

            $worker = User::find($request->worker_id);

            broadcast(new RequestEvent($worker, 'You have new work order.'));

            $details = [
                'message' => 'You have new work order.'
            ];

            Notification::send($worker, new RequestNotification($details));
        }

        if ($request->submit == 'Reject') {
            $userRequest->status = 'Rejected';
            $userRequest->worker_id = null;
            $userRequest->work_status = null;

            $user = Auth::user();

            $user->messages()->create([
                'message' => 'You request has been rejected.',
                'request_id' => $id
            ]);
        }

        if ($request->submit == 'Update') {
            if ($userRequest->worker_id != $request->worker_id) {

                $userRequest->worker_id = $request->worker_id;

                $worker = User::find($request->worker_id);

                broadcast(new RequestEvent($worker, 'You have new work order.'));

                $details = [
                    'message' => 'You have new work order.'
                ];

                Notification::send($worker, new RequestNotification($details));
            }
        }

        $userRequest->save();

        return redirect()->route('requests.index')
            ->with('success', 'Request edited successfully');
    }
}
