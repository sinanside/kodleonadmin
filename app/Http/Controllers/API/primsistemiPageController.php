<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pagecreator;
use App\Image;
use Images;

class primsistemiPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
    }

    public function storeimage(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "prmsstmpage_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/primsistemipage/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark2.png'));

            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/primsistemipage/' . $name));

            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function storeimagebyeditor(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "prmsstmpage_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/primsistemipage/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark2.png'));

            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/primsistemipage/' . $name));

            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return Pagecreator::findOrFail(8);
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
        $mainpage = Pagecreator::findOrFail(8);

        $this->validate($request, [
            'name' => 'string'
        ]);

        $mainpage -> update($request -> all());

        return ['message' => 'update the prim sistemi page info'];
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