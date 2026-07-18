<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'services' => Service::query()->active()->ordered()->limit(6)->get(),
        ]);
    }
}
