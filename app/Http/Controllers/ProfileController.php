<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile;
use Storage;
use App\User;
use Session;
use Image;
use File;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($user_id)
    {   $user = User::find($user_id);
        $profile = $user->profile;
        return view('profiles.edit')->with([
            'user' => $user,
            'profile' => $profile,
            'pageTitle' => "Edit Profile"
        ]);
    }

    public function show($user_id)
    {

       // $profile = Profile::find($user_id);
        $user = User::find($user_id);
        $profile = $user->profile;

        return view('profiles.show')->with([
            'user' => $user,
            'profile' => $profile,
            'pageTitle' => $user->name
        ]);
    }


    public function update(Request $request, $user_id)
    {
        //Validate the data
        $this->validate($request, array(
            'firstname'  => 'max:255',
            'lastname'   => 'max:255',
            'location'   => 'max:255',
            'birthdate'  => 'date',
            'gender'     => 'max:255',
            'bio'        => 'max:255',
            'profilepic' => 'image',

        ));

        //save the data to the db
        $user = User::find($user_id);
        $profile = $user->profile;

        $profile->firstname = $request->firstname;
        $profile->lastname  = $request->lastname;
        $profile->location  = $request->location;
        $profile->birthdate = $request->birthdate;
        $profile->gender    = $request->gender;
        $profile->bio       = $request->bio;

        if ($request->hasFile('profilepic')) {
            $oldFilename = $profile->profilepic;

            // Make Image
            $image    = $request->file('profilepic');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);

            $newImage = Image::make($image);

            // Smart Image Resizing
            $thumbSize = 250;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Save Location
            $newImage->save($location);

            // Update User
            $profile->profilepic = $filename;

            // Delete Old Avatar
            Storage::delete($oldFilename);
        }

        $profile->save();

        Session::flash('success', 'This post was successfully saved.');

        //redirect with flash data to events.show
        return redirect()->route('profiles.show', $user_id);
    }
}
