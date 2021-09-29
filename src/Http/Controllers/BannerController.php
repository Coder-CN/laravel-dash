<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\Banner as ResourcesBanner;
use Coder\LaravelDash\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'pageSize' => intval($data->perPage()),
            'pageNo' => $data->currentPage(),
            'totalPage' => $data->lastPage(),
            'totalCount' => $data->total()
        ]);
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
            'sort' => 'required|integer|min:1'
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
            if (!$banner->id) {
                $banner->sort = $request->input('sort');
                Banner::where('sort', '>=', $banner->sort)->increment('sort');
            } else if ($banner->sort !== $request->input('sort')) {
                $original_sort = $banner->sort;
                $banner->sort = $request->input('sort');
                if ($original_sort > $banner->sort) { // 如果排序靠前，区间往后移一位
                    Banner::whereBetween('sort', [$banner->sort, $original_sort - 1])->where('id', '<>', $banner->id)->increment('sort');
                } else { // 如果排序靠后，区间往前移一位
                    Banner::whereBetween('sort', [$original_sort + 1, $banner->sort])->where('id', '<>', $banner->id)->decrement('sort');
                }
            }
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
            DB::beginTransaction();
            // 更新排序
            Banner::where('sort', '>', $banner->sort)->decrement('sort');
            $banner->delete();

            DB::commit();
            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail($e->getMessage());
        }
    }

    /**
     * 更新排序
     */
    public function updateSort(Request $request, $id)
    {
        $this->validate($request, [
            'sort' => 'required|integer|min:1'
        ]);
        
        $data = Banner::findOrFail($id);
        try {
            DB::beginTransaction();
            if ($data->sort !== $request->input('sort')) {
                $original_sort = $data->sort;
                $data->sort = $request->input('sort');
                if ($original_sort > $data->sort) { // 如果排序靠前，区间往后移一位
                    Banner::whereBetween('sort', [$data->sort, $original_sort - 1])->where('id', '<>', $data->id)->increment('sort');
                } else { // 如果排序靠后，区间往前移一位
                    Banner::whereBetween('sort', [$original_sort + 1, $data->sort])->where('id', '<>', $data->id)->decrement('sort');
                }
            }
            $data->save();

            DB::commit();
            return $this->success(new ResourcesBanner($data));
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
