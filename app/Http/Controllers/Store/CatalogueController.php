<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;

class CatalogueController extends Controller
{
    public function index()
    {
        $catalogues = Catalogue::active()->get();

        return view('store.catalogue', compact('catalogues'));
    }
}
