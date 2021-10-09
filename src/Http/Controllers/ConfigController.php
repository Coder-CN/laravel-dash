<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\Config as ResourcesConfig;
use Coder\LaravelDash\Http\Resources\Section;
use Coder\LaravelDash\Models\Config;
use Coder\LaravelDash\Models\InfoClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(ResourcesConfig::collection(Config::get()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type)
    {
        if ($type === 'basic') {
            Config::where('key', 'web_logo')->update(['value' => $request->input('web_logo')]);
            Config::where('key', 'web_author')->update(['value' => $request->input('web_author')]);
            Config::where('key', 'web_copyright')->update(['value' => $request->input('web_copyright')]);
            Config::where('key', 'web_host')->update(['value' => $request->input('web_host')]);
            Config::where('key', 'web_name')->update(['value' => $request->input('web_name')]);
            Config::where('key', 'web_seotitle')->update(['value' => $request->input('web_seotitle')]);
            Config::where('key', 'web_description')->update(['value' => $request->input('web_description')]);
            Config::where('key', 'web_keywords')->update(['value' => $request->input('web_keywords')]);
        } else if ($type === 'contact') {
            Config::where('key', 'address')->update(['value' => $request->input('address')]);
            Config::where('key', 'contact_phone')->update(['value' => $request->input('contact_phone')]);
            Config::where('key', 'fax')->update(['value' => $request->input('fax')]);
            Config::where('key', 'contact_email')->update(['value' => $request->input('contact_email')]);
            Config::where('key', 'contacts')->update(['value' => $request->input('contacts')]);
        } else if ($type === 'other') {
            Config::where('key', 'upload_type')->update(['value' => $request->input('upload_type')]);
            Config::where('key', 'upload_maximum_size')->update(['value' => $request->input('upload_maximum_size')]);
        } else {
            return $this->fail();
        }

        return $this->success();
    }
    
    /**
     * 獲取網站欄目
     */
    public function getWebSections()
    {
        return $this->success(Section::collection(InfoClass::whereNull('parent_id')->orderBy('sort')->get()));
    }

    /**
     * 更新網站欄目信息
     */
    public function updateWebSection(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'is_show' => 'required|boolean'
        ]);

        $section = InfoClass::findOrFail($id);
        try {
            $section->update($request->only([
                'name', 'description', 'picture', 'pictures', 'link_url',
                'seo_title', 'keywords', 'is_show', 'sub_title'
            ]));
            return $this->success(new Section($section));
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * 更新網站欄目排序
     */
    public function updateWebSectionSort(Request $request, $id)
    {
        $this->validate($request, [
            'position' => 'required|min:0|integer'
        ]);
        $section = InfoClass::findOrFail($id);
        $original_section = InfoClass::where('parent_id', $section->parent_id)->orderBy('sort')->skip($request->input('position'))->first();
        if ($original_section) {
            DB::beginTransaction();
            try {
                $section->sort = $original_section->sort + ($section->sort < $original_section->sort ? 1 : 0);
                $section->save();
                InfoClass::where('parent_id', $section->parent_id)->where('sort', '>=', $section->sort)->where('id', '<>', $section->id)->increment('sort');
                DB::commit();
                return $this->success();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->fail($e->getMessage());
            }
        }
        return $this->fail();
    }
}
