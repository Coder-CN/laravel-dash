<?php

namespace Coder\LaravelDash\Http\Controllers;

use Coder\LaravelDash\Models\InfoClass;
use Illuminate\Http\Request;

class InfoClassController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDiyContent($id)
    {
        return InfoClass::findOrFail($id)->diy_content;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDiyContent(Request $request, $id)
    {
        $data = InfoClass::findOrFail($id);
        $this->validate($request, [
            'diy_content' => 'required|array'
        ]);
        $data->diy_content = $request->input('diy_content');
        $data->save();

        return $this->success();
    }
}
