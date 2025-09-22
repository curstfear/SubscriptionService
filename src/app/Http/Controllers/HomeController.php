<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke() {
        $page = Page::with('sections.items')->where('slug', 'home')->firstOrFail();

        return view('pages.home', compact('page'));
    }
}
