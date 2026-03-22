<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function publicIndex(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type');
        
        $query = Notice::published()->latest('publish_at');
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        if ($type) {
            $query->where('type', $type);
        }
        
        $notices = $query->paginate(10);
        $types = Notice::published()->distinct('type')->pluck('type')->filter();
        
        return view('public.notices', compact('notices', 'types', 'search', 'type'));
    }

    public function show(string $id)
    {
        $notice = Notice::published()->findOrFail($id);
        return view('public.notice-detail', compact('notice'));
    }
}