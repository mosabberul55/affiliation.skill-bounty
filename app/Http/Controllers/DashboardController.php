<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function courses()
    {
        $response = Http::withHeaders([
            'x-api-key' => 1234
        ])->acceptJson()->get('https://skill-bounty.com/api/development/courses');

        if ($response->successful()) {
            $courses = $response->json();
        } else {
            $courses = [];
        }

        return Inertia::render('Courses', [
            'courses' => $courses['data'],
        ]);
    }
}
