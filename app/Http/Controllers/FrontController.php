<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\CompanyAbout;
use App\Models\OurPrinciple;
use App\Models\CompanyStatistic;
use App\Models\HeroSection;
use App\Models\OurTeam;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $hero_sections = HeroSection::orderByDesc('id')->take(1)->get();
        $principles = OurPrinciple::take(4)->get();
        $statistics = CompanyStatistic::take(4)->get();
        $products = Product::take(3)->get();
        $teams = OurTeam::take(7)->get();
        $testimonials = Testimonial::take(5)->get();
        return view('front.index', compact('hero_sections', 'principles', 'statistics', 'products', 'teams', 'testimonials'));
    }

    public function team()
    {
        $teams = OurTeam::take(12)->get();
        $statistics = CompanyStatistic::take(4)->get();
        return view('front.team', compact('teams', 'statistics'));
    }

    public function about()
    {
        $abouts = CompanyAbout::take(2)->get();
        $statistics = CompanyStatistic::take(4)->get();
        return view('front.about', compact('abouts', 'statistics'));
    }

    public function appointment()
    {
        $testimonials = Testimonial::take(5)->get();
        $products = Product::take(3)->get();
        return view('front.appointment', compact('testimonials', 'products'));
    }

    public function appointment_store(StoreAppointmentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $newAppointment = Appointment::create($validated);
            // dd($newAppointment);
        });

        return redirect()->route('front.index');
    }
}
