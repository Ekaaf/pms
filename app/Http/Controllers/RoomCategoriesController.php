<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RoomCategory;

class RoomCategoriesController extends Controller
{
    
    public function roomCategoryAdd(Request $request)
    {   
        return view('room_categories.room_category_add');
    }
}
