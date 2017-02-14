<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Category;
use App\Profile;
use App\Blocked;
use App\User;
use Storage;
use Session;
use Image;
use File;

class AdminController extends Controller {

    public function index() {
        return view('admin.index');
    }

    public function listUsers() {
        return view('admin.list_users')->with([
            'users' => User::all(),
            'pageTitle' => 'View Users'
        ]);
    }

    public function listCategories() {
        return view('admin.list_categories')->with([
            'categories' => Category::all(),
            'pageTitle' => 'View Categories'
        ]);
    }

    public function createCategory() {
        return view('admin.create_category')->with([
            'pageTitle' => 'Create Category'
        ]);
    }

    public function editCategory($id) {
        return view('admin.edit_category')->with([
            'category' => Category::find($id),
            'pageTitle' => 'Edit Category'
        ]);
    }

    public function createCategoryAction(Request $request) {
        $category = new Category;
        $category->name = $request->input('name');

        if ($request->hasFile('image')) {
            // Make Image
            $image    = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/categories/' . $filename);

            // Create New Image
            $newImage = Image::make($image);

            // Resize Image to maintain its aspect ratio
            $thumbSize = 800;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Save Image
            $newImage->save($location);

            // Update Event Image
            $category->image = $filename;
        }

        $category->save();

        Session::flash('success', 'Category was created.');
        return redirect()->route('admin.list_categories');
    }

    public function editCategoryAction(Request $request, $id) {
        $category = Category::find($id);
        $category->name = $request->input('name');

        if ($request->hasFile('image')) {
            // Make Image
            $image    = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/categories/' . $filename);

            // Create New Image
            $newImage = Image::make($image);

            // Resize Image to maintain its aspect ratio
            $thumbSize = 800;
            $aspectRatio = $newImage->width() / $newImage->height();
            if ($aspectRatio >= 1) {
                $newImage->resize($aspectRatio * $thumbSize, $thumbSize);
            }
            else {
                $newImage->resize($thumbSize, $thumbSize / $aspectRatio);
            }

            // Get old image
            $oldFilename = $category->image;

            // Save Image
            $newImage->save($location);

            // Update Event Image
            $category->image = $filename;

            // Delete old image
            if ($oldFilename == 'cover.jpeg') {
                Storage::delete($oldFilename);
            }
        }

        $category->save();

        Session::flash('success', 'Category was edited.');
        return redirect()->route('admin.list_categories');
    }

    public function deleteCategory($id) {
        $category = Category::find($id);

        Storage::delete($category->image);
        $category->delete();

        Session::flash('success', 'The category was successfully deleted.');
        return redirect()->route('admin.list_categories');
    }

    public function blockUser(Request $request, $user_id) {
        $user = User::find($user_id);
        $block = new Blocked;
        $block->user_id = $user_id;
        $block->save();

        return redirect()->route('admin.list_users');
    }

    public function unblockUser(Request $request, $user_id) {
        $user = User::find($user_id);
        $block = $user->blocked;
        $block->delete();

        return redirect()->route('admin.list_users');
    }

}
