<?php

namespace App\Http\Controllers;   //interiorul folderului use e pentru exterior
use App\Event;
use App\User;
use App\Category;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Mail;
use Session;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PagesController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('blocked');
    }

    public function getIndex() {
        return view('pages/welcome');
        #process variable data and params
        #talk to the model
        #receive data back from the model
        #compile or process data from the model if needed
        #pass that data to the correct view
    }

    public function showCategories() {
        return view('events.categories')->with([
            'pageTitle' => 'Categories'
        ]);
    }

    public function showCategory($id) {
        $category = Category::find($id);

        return view('events.category')->with([
            'hero' => 'category-detail',
            'category' => $category
        ]);
    }

    public function discoverEvents() {
        return view('events.discover');
    }

    public function getAllEvents() {
        view::share('$sharedItem', "");

        $events = Event::activeEvents()->orderBy('startdate')->paginate(20);
        return view('pages/allevents')->with(['events' => $events]);
    }

    public function getProfile(){
        $user = Auth::user();

        return view('pages.profile')->with([
            'user' => $user
        ]);
    }
}