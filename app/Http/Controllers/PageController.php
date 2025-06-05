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
    public static function getPages($userId)
    {
        $pages = Permission::where('users_id', $userId)
            ->where('view', 1)
            ->with('page')
            ->join('pages', 'permissions.pages_id', '=', 'pages.id')
            ->orderBy('pages.order')
            ->select('permissions.*')
            ->get();

        return $pages;
    }
}
