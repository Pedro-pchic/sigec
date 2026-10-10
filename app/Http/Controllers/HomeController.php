<?php

namespace App\Http\Controllers;

use App\Actions\RecordEcommerceEvent;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, RecordEcommerceEvent $recordEcommerceEvent): View
    {
        $recordEcommerceEvent->recordPortalVisit($request);

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->limit(6)
            ->get();

        return view('portal.home', compact('categories'));
    }
}
