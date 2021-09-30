<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Http\Resources\Config as ResourcesConfig;
use Coder\LaravelDash\Models\Config;
use Illuminate\Http\Request;

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
            Config::where('key', 'web_name')->update(['value' => ['zh-TW' => $request->input('web_name_tw'), 'en-US' => $request->input('web_name_en')]]);
            Config::where('key', 'web_seotitle')->update(['value' => ['zh-TW' => $request->input('web_seotitle_tw'), 'en-US' => $request->input('web_seotitle_en')]]);
            Config::where('key', 'web_keywords')->update(['value' => ['zh-TW' => $request->input('web_keywords_tw'), 'en-US' => $request->input('web_keywords_en')]]);
            Config::where('key', 'web_description')->update(['value' => ['zh-TW' => $request->input('web_description_tw'), 'en-US' => $request->input('web_description_en')]]);
        }
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
