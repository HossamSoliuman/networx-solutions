<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('home', [
            'services' => Service::query()->active()->ordered()->get(),
            'contactEmail' => Setting::get('contact_email'),
            'contactPhone' => Setting::get('contact_phone'),
            'website' => Setting::get('website'),
            'address' => Setting::get('address'),
        ]);
    }
}
