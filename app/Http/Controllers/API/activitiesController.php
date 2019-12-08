<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activities;
use App\Image;
use Images;

class activitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Activities::ordered()->paginate(10);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeimage(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function storeimage1(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function storeimage2(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function storeimage3(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function storeimage4(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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
            $name = "actvts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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
        //return $request->all();

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        return Activities::create([
            'title'=>$request['title'],
            'meta_title'=>$request['meta_title'],
            'meta_description'=>$request['meta_description'],
            'meta_keywords'=>$request['meta_keywords'],
            'description1'=>$request['description1'],
            'description2'=>$request['description2'],
            'description3'=>$request['description3'],
            'description4'=>$request['description4'],
            'short_content'=>$request['short_content'],
            'content'=>$request['content'],
            'photo1'=>$request['photo1'],
            'photo1_alt'=>$request['photo1_alt'],
            'photo2'=>$request['photo2'],
            'photo2_alt'=>$request['photo2_alt'],
            'photo3'=>$request['photo3'],
            'photo3_alt'=>$request['photo3_alt'],
            'photo4'=>$request['photo4'],
            'photo4_alt'=>$request['photo4_alt'],
            'active'=>$request['active']
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
        return Activities::findOrFail($id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function up(Request $request)
    {
        $id = $request->id;
        $activities =Activities::findorFail($id);
        $activities->moveOrderUp();

        return ['message'=>'ourteam reordered'];
    }

    public function down(Request $request)
    {
        $id = $request->id;
        $activities =Activities::findorFail($id);
        $activities->moveOrderDown();


        return ['message'=>'ourteam reordered'];
    }

    public function update(Request $request, $id)
    {
        $activities = Activities::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',

        ]);
        $activities -> update($request -> all());

        return ['message' => 'update activities'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activities =Activities::findorFail($id);

        $activities->delete();


        return ['message'=>'post deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $activities = Activities::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $activities = Activities::ordered()->paginate(10);
        }
        return $activities;
    }
}
