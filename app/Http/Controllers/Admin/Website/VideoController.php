<?php

namespace App\Http\Controllers\Admin\Website;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Website\VideoService;

class VideoController extends Controller
{
    private $video_service;

    public function __construct(VideoService $video_service)
    {
        $this->video_service = $video_service;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->video_service->dataTable();
        }

        return view('admin.pages.website.video.index');
    }


    public function store(Request $request)
    {
        $result = $this->video_service->store($request->all());

        if ($result) {
            return redirect()->route('admin.website.video.index')->with('success', $this->video_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->video_service->message);
    }

    public function edit(Video $video)
    {
        abort_unless($video, 404);

        return view('admin.pages.website.video.edit', [
            'slider' => $video,
        ]);
    }

    public function update(Video $video, Request $request)
    {
        abort_unless($video, 404);
        $result = $this->video_service->update($video, $request->all());

        if ($result) {
            return redirect()->route('admin.website.video.index', $video->id)->with('success', $this->video_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->video_service->message);
    }

    public function destroy(Video $video)
    {
        abort_unless($video, 404);
        $result = $this->video_service->delete($video);

        if ($result) {
            return redirect()->route('admin.website.video.index', $video->id)->with('success', $this->video_service->message);
        }

        return back()->with('error', $this->video_service->message);
    }

    public function changeStatus(Request $request, Video $video)
    {
        abort_unless($video, 404);
        $result = $this->video_service->changeStatus($video);

        if ($result) {
            return redirect()->route('admin.website.video.index')->with('success', $this->video_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->video_service->message);
    }
}
