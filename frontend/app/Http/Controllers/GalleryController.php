<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        
        $query = Gallery::public()->ordered();
        
        if ($category) {
            $query->where('category', $category);
        }
        
        $gallery = $query->get();
        $categories = Gallery::public()->distinct('category')->pluck('category')->filter();
        
        return view('public.gallery', compact('gallery', 'categories', 'category'));
    }
}