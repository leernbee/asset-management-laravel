<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use Spatie\MediaLibrary\Models\Media;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfile(User $user)
    {
        $this->validate(
            request(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'nullable|date_format:m-d-Y',
                'contact_no' => 'nullable|regex:/639[0-9]{9}/'
            ],
            [
                'first_name.required'    => 'The field first name is required.',
                'last_name.required'      => 'The field last name is required.',
                'birth_date.date_format' => 'The field birth date is invalid.',
                'contact_no.regex'      => 'The field contact number is invalid.',
            ]
        );

        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->contact_no = request('contact_no');
        $user->birth_date = request('birth_date');
        $user->employee_id = request('employee_id');
        $user->job_title = request('job_title');

        if (request('contact_no') == null) {
            $user->sms_2fa_enable = 0;
        }

        if (request('avatar') !== NULL) {
            $media = Media::whereCollectionName('avatars')->whereModelId(Auth::user()->id)->orderBy('created_at', 'desc')->first();
            if ($media !== NULL) {
                $media->delete();
            }

            $name = md5(request('avatar')->getClientOriginalName());
            $filename = md5(request('avatar')->getClientOriginalName()) . '.' . request('avatar')->getClientOriginalExtension();

            $original = $user->addMediaFromRequest('avatar')->setName($name)->setFileName($filename)->toMediaCollection('avatars');

            unlink($original->getPath());
        }

        $user->save();
        Session::flash('flash_message', 'Updated Successfully!');
        return back();
    }
}
