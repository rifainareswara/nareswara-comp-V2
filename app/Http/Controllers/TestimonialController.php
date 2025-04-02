<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\ProjectClient;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('id')->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil data klien dari tabel project_clients
        // Data diurutkan berdasarkan kolom 'id' secara menurun (data terbaru terlebih dahulu)
        // Hanya 10 data per halaman dengan mekanisme pagination
        $clients = ProjectClient::orderByDesc('id')->paginate(10);

        // Mengirimkan data klien ke view 'admin.testimonials.create'
        // Variabel $clients akan tersedia di view dengan nama yang sama
        return view('admin.testimonials.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        // Closure-based transaction
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumnailPath;
            }

            $newTestimonial = Testimonial::create($validated);
        });

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        $clients = ProjectClient::orderByDesc('id')->get();

        return view('admin.testimonials.edit', compact('testimonial', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        DB::transaction(function () use ($request, $testimonial) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumnailPath;
            }

            $testimonial->update($validated);
        });

        return redirect()->route('admin.testimonials.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        DB::transaction(function () use ($testimonial) {
            $testimonial->delete();
        });

        return redirect()->route('admin.testimonials.index');
    }
}
