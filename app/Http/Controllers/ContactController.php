<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __invoke(Request $request): View
    {
        $services = Service::query()->active()->ordered()->get();

        return view('contact', [
            'services' => $services,
            'selectedService' => $services->firstWhere('slug', $request->string('service')->value()),
        ]);
    }
}
