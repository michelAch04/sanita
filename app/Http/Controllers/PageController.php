<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Permission;

class PageController extends Controller
{
    /**
     * Fetch all visible pages ordered by 'order'.
     */
    public static function getPages()
    {
        $pages = Page::with('Permission')
            ->whereHas('Permission', function ($query) {
                $query->where('view', 1);
            })
            ->orderBy('order')
            ->get();

        return $pages;
    }
}
