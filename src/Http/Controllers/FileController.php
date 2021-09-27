<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Models\File;
use Coder\LaravelDash\Http\Resources\File as ResourcesFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'pageNo' => 'integer',
            'pageSize' => 'integer',
        ]);
        $perPage = $request->input('pageSize', 21);
        $pageNo = $request->input('pageNo', 1);

        $data = File::filter($request->all())->latest()->paginate($perPage, '*', 'page', $pageNo);

        return $this->success([
            'data' => ResourcesFile::collection($data->items()),
            'pageSize' => intval($data->perPage()),
            'pageNo' => $data->currentPage(),
            'totalPage' => $data->lastPage(),
            'totalCount' => $data->total()
        ]);
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'files' => 'required|array',
            'files.*' => 'file',
        ]);

        // 获取文件
        $files = $request->file('files');

        // 上传文件
        $files_path = []; // 存储文件路径
        $storage = Storage::disk('public');

        // 循环 - 保存文件
        foreach ($files as $file) {
            $extension = strtolower($file->extension());
            if ($extension === 'jpg' || $extension === 'png' || $extension === 'jpeg') {
                $type = 'image';
            } else if ($extension === 'mp4' || $extension === 'mov' || $extension === 'avi') {
                $type = 'video';
            } else {
                $type = 'file';
            }

            $path = $storage->put($type . 's/' . date('Ymd'), $file);

            if ($path) {
                $url = env('APP_URL') . Storage::url($path);
                // 存储数据库
                $files_path[] = File::create([
                    'type' => $type,
                    'url' => $url
                ]);
            } else {
                return $this->fail();
            }
        }

        return $this->success(ResourcesFile::collection($files_path));
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required'
        ]);
        try {
            File::destroy($request->input('ids'));
            return $this->success();
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}
