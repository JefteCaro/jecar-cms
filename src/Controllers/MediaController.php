<?php

namespace Jecar\Cms\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Jecar\Cms\Facades\Cms;
use Jecar\Cms\Models\Page;
use Jecar\Cms\Requests\Pages\CreatePage;
use Jecar\Cms\Resources\PageCollection;
use Jecar\Cms\Resources\PageResource;

class MediaController extends BaseController
{
    public function __construct()
    {

    }

    public function jsonResponse(Request $request, $mode = 'index')
    {
        switch ($mode) {
            default: {
                $data = Page::paginate(20);
                return response()->json(new PageCollection($data));
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->wantsJson())
        {
            return $this->jsonResponse($request);
        }

        return view('jecar::cms', ['prefix' => app('jecar')->pathPrefix('cms')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePage $request)
    {
        $data = Page::create($request->validated());

        return response()->json([
            'message' => 'Page Created',
            'data' => new PageResource($data)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $object
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $object)
    {
        return view('jecar::cms', ['prefix' => app('jecar')->pathPrefix('cms')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $object
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $object)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $object
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $object)
    {
        //
    }

    public function content(Request $request)
    {
        return Cms::renderPage($request->path());
    }
}
