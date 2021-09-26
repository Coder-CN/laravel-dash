<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Resources\Banner as ResourcesBanner;
use Coder\LaravelDash\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'pageNo' => 'integer',
            'pageSize' => 'integer',
        ]);
        $perPage = $request->input('pageSize', 10);
        $pageNo = $request->input('pageNo', 1);

        $data = Banner::orderBy('sort')->paginate($perPage, '*', 'page', $pageNo);

        return $this->success([
            'data' => ResourcesBanner::collection($data->items()),
            'pageSize' => $data->perPage(),
            'pageNo' => $data->currentPage(),
            'totalPage' => $data->lastPage(),
            'totalCount' => $data->total()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'location' => 'required',
            'picture' => 'required',
            'is_show' => 'required|boolean',
            'sort' => 'required|integer'
        ]);

        if ($request->filled('id')) {
            $banner = Banner::findOrFail($request->input('id'));
        } else {
            $banner = new Banner();
        }

        try {
            $banner->location = $request->input('location');
            $banner->title = $request->input('title');
            $banner->subtitle = $request->input('subtitle');
            $banner->picture = $request->input('picture');
            $banner->link_url = $request->input('link_url');
            $banner->is_show = $request->input('is_show');
            $banner->sort = $request->input('sort');
            $banner->save();
            return $this->success(new ResourcesBanner($banner));
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        try {
            $banner->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
