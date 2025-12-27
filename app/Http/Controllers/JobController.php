<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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
        $categories = Category::all();

        return view('job.create', [
            'categories' => $categories,
        ]);
    }

    public function store(JobStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Job::create($data);

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
        return view('job.edit', [
            'job' => $job,
        ]);
    }

    public function update(JobUpdateRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->validated());

        return redirect()->route('jobs.index');
    }

    public function destroy(Request $request, Job $job): RedirectResponse
    {
        // dozvoli brisanje samo vlasniku oglasa
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $job->delete();

        return redirect()->route('jobs.index');
    }
}
