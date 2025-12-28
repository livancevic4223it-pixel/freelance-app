<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $jobs = Job::latest()->get();

        return view('job.index', [
            'jobs' => $jobs,
        ]);
    }

    public function create(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        return view('job.create', [
            'categories' => $categories,
        ]);
    }

    public function store(JobStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Ako forma ne šalje user_id, uzmi ulogovanog korisnika
        $data['user_id'] = $data['user_id'] ?? $request->user()->id;

        $job = Job::create($data);

        // ✅ BITNO ZA TEST
        $request->session()->flash('job.id', $job->id);

        return redirect()->route('jobs.index');
    }

    public function show(Request $request, Job $job): View
    {
        return view('job.show', [
            'job' => $job,
        ]);
    }

    public function edit(Request $request, Job $job): View
    {
        $categories = Category::orderBy('name')->get();

        return view('job.edit', [
            'job' => $job,
            'categories' => $categories,
        ]);
    }

    public function update(JobUpdateRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->validated());

        // ✅ BITNO ZA TEST
        $request->session()->flash('job.id', $job->id);

        return redirect()->route('jobs.index');
    }

    public function destroy(Request $request, Job $job): RedirectResponse
    {
        $job->delete();

        return redirect()->route('jobs.index');
    }
}
