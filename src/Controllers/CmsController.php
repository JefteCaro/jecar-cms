<?php

namespace Jecar\Cms\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Jecar\Cms\Facades\Cms;
use Jecar\Cms\Models\Page;

class CmsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->wantsJson())
        {

        }

        return view('jecar::cms', ['prefix' => app('jecar')->pathPrefix('cms')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
