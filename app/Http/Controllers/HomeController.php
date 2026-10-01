<?php

namespace App\Http\Controllers;

use App\Actions\RecordEcommerceEvent;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
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

        $products = Product::query()
            ->with(['category', 'inventory'])
            ->where('is_active', true)
            ->whereHas('category', fn (Builder $query): Builder => $query->where('is_active', true))
            ->whereHas('inventory', fn (Builder $query): Builder => $query->where('stock', '>', 0))
            ->latest('id')
            ->limit(6)
            ->get();

        return view('portal.home', compact('categories', 'products'));
    }
}
