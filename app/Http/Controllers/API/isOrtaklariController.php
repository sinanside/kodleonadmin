<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Isortaklari;
use App\Image;
use Images;

class isOrtaklariController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Isortaklari::ordered()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeimage(Request $request)
    {
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "ortm_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/isortaklari/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/isortaklari/' . $name));

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
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "isort_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/isortaklari/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/isortaklari/' . $name));

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
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        return Isortaklari::create([
            'name'=>$request['name'],
            'link'=>$request['link'],
            'picture1'=>$request['picture1'],
            'short_description1'=>$request['short_description1'],
            'short_description2'=>$request['short_description2'],
            'short_description3'=>$request['short_description3'],
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
        $this->authorize('isAdmin');
        return Isortaklari::findOrFail($id);

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
        $this->authorize('isAdmin');
        $id = $request->id;
        $isortaklari =Isortaklari::findorFail($id);
        $isortaklari->moveOrderUp();

        return ['message'=>'ourteam reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $isortaklari =Isortaklari::findorFail($id);
        $isortaklari->moveOrderDown();


        return ['message'=>'ourteam reordered'];
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $isortaklari = Isortaklari::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',

        ]);
        $isortaklari -> update($request -> all());

        return ['message' => 'update ourteam'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $isortaklari =Isortaklari::findorFail($id);

        $isortaklari->delete();


        return ['message'=>'ourteam deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $isortaklari = Isortaklari::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $isortaklari = Isortaklari::ordered()->paginate(10);
        }
        return $isortaklari;
    }

}
