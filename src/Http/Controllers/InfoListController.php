<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\InfoList as ResourcesInfoList;
use Coder\LaravelDash\Models\InfoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $class_id)
    {
        $this->validate($request, [
            'pageNo' => 'integer',
            'pageSize' => 'integer',
        ]);
        $perPage = $request->input('pageSize', 10);
        $pageNo = $request->input('pageNo', 1);

        $data = InfoList::class($class_id)
            ->filter($request->all())
            ->orderBy('sort')
            ->latest()
            ->paginate($perPage, '*', 'page', $pageNo);

        return $this->success([
            'data' => ResourcesInfoList::collection($data->items()),
            'pageSize' => intval($data->perPage()),
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
        return $this->success(new ResourcesInfoList(InfoList::findOrFail($id), true));
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
            'class_id' => 'required|exists:info_classes,id',
            'title' => 'required',
            'pictures' => 'array',
            'is_show' => 'required|boolean',
            'sort' => 'required|integer',
            'files' => 'array',
            'files.*.id' => 'required|exists:files,id',
            'files.*.title' => 'required'
        ]);

        if ($request->filled('id')) {
            $data = InfoList::findOrFail($request->input('id'));
        } else {
            $data = new InfoList();
        }
        try {
            DB::beginTransaction();
            $data->class_id = $request->input('class_id');
            $data->title = $request->input('title');
            $data->description = $request->input('description');
            $data->picture = $request->input('picture');
            $data->pictures = $request->input('pictures');
            $data->link_url = $request->input('link_url');
            $data->keywords = $request->input('keywords');
            $data->content = $request->input('content');
            $data->author = $request->input('author');
            $data->source = $request->input('source');
            $data->is_show = $request->input('is_show');
            $data->sort = $request->input('sort');
            $data->release_at = $request->input('release_at');
            $data->save();

            // 更新关联文件
            $files = [];
            foreach ($request->input('files', []) as $file) {
                $files[$file['id']] = [
                    'title' => $file['title'],
                    'expiration_at' => $file['expiration_at']
                ];
            }
            $data->files()->sync($files);

            DB::commit();
            return $this->success(new ResourcesInfoList($data, true));

        } catch (\Exception $e) {
            DB::rollBack();
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
        try {
            DB::beginTransaction();
            
            $data = InfoList::find($id);
            // 删除关联文件记录
            $data->files()->detach();
            $data->delete();

            DB::commit();
            return $this->success();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail($e->getMessage());
        }
    }
}
