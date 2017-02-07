<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Profile;
use App\Blocked;
use Storage;
use App\User;
use Auth;
use Session;
use Image;
use File;

class ProfileController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware(['auth', 'blocked']);
    }

    public function edit($user_id) {
        $user = User::find($user_id);
        $profile = $user->profile;

        return view('profiles.edit')->with([
            'user' => $user,
            'profile' => $profile,
            'pageTitle' => "Edit Profile"
        ]);
    }

    public function show($user_id) {
        $user = User::find($user_id);
        $profile = $user->profile;

        return view('profiles.show')->with([
            'user' => $user,
            'profile' => $profile,
            'pageTitle' => $user->name
        ]);
    }

    public function block(Request $request, $user_id) {
        $user = User::find($user_id);

        if ($user && Auth::user()->isAdmin()) {
            $block = new Blocked;
            $block->user_id = $user_id;
            $block->save();
        }

        return redirect()->route('profiles.show', $user_id);
    }

    public function unblock(Request $request, $user_id) {
        $user = User::find($user_id);

        if ($user && Auth::user()->isAdmin()) {
            $block = $user->blocked;
            $block->delete();
        }

        return redirect()->route('profiles.show', $user_id);
    }

    public function update(Request $request, $user_id) {

        // Data Validation
        $this->validate($request, array(
            'firstname'  => 'max:255',
            'lastname'   => 'max:255',
            'location'   => 'max:255',
            'birthdate'  => 'date',
            'gender'     => 'max:255',
            'bio'        => 'max:255',
            'profilepic' => 'image',
        ));

        // Define Vars
        $user = User::find($user_id);
        $profile = $user->profile;

        // Update Profile Columns
        $profile->firstname = $request->firstname;
        $profile->lastname  = $request->lastname;
        $profile->location  = $request->location;
        $profile->birthdate = $request->birthdate;
        $profile->gender    = $request->gender;
        $profile->bio       = $request->bio;

        if ($request->hasFile('profilepic')) {
            // Make Image
            $image    = $request->file('profilepic');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/avatars/' . $filename);

            // Save old avatar location (to delete it)
            $oldFilename = $profile->profilepic;

            // Create New Image
            $newImage = Image::make($image);

            // Resize Image to maintain its aspect ratio
            $thumbSize = 250;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Save Image
            $newImage->save($location);

            // Update User Profile Picture
            $profile->profilepic = $filename;

            // Delete Old Avatar
            Storage::delete($oldFilename);
        }

        // Save Updated Column
        $profile->save();

        Session::flash('success', 'This post was successfully saved.');
        return redirect()->route('profiles.show', $user_id);
    }
}
