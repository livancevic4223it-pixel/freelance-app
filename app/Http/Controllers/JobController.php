<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Http\Requests\JobUpdateRequest;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): Response
    {
        $jobs = Job::all();

        return view('job.index', [
            'jobs' => $jobs,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('job.create');
    }

    public function store(JobStoreRequest $request): Response
    {
        $job = Job::create($request->validated());

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('jobs.index');
    }

    public function show(Request $request, Job $job): Response
    {
        return view('job.show', [
            'job' => $job,
        ]);
    }

    public function edit(Request $request, Job $job): Response
    {
        return view('job.edit', [
            'job' => $job,
        ]);
    }

    public function update(JobUpdateRequest $request, Job $job): Response
    {
        $job->update($request->validated());

        $request->session()->flash('job.id', $job->id);

        return redirect()->route('jobs.index');
    }

    public function destroy(Request $request, Job $job): Response
    {
        $job->delete();

        return redirect()->route('jobs.index');
    }
}
