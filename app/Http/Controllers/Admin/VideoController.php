<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index() { return view('admin.videos.index', ['items' => Video::latest()->paginate(12)]); }
    public function create() { return view('admin.videos.form', ['item' => new Video]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        Video::create($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video created.');
    }

    public function edit(Video $video) { return view('admin.videos.form', ['item' => $video]); }

    public function update(Request $request, Video $video)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $video->update($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video updated.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return back()->with('success', 'Video deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'url' => ['required', 'url', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if (!Video::extractVideoId($data['url'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'url' => 'Enter a valid YouTube watch, youtu.be, Shorts, or embed URL.',
            ]);
        }
        return $data;
    }
}
