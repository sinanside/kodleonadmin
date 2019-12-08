<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topcategory;
use App\Image;
use Images;

class shp_topcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Topcategory::ordered()->paginate(10);
    }

    public function storeimage1(Request $request)
    {
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "tpctgry_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/shop/topcategory/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/shop/topcategory/' . $name));
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
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "tpctgry_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/shop/topcategory/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/shop/topcategory/' . $name));
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
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "tpctgry_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/shop/topcategory/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/shop/topcategory/' . $name));
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
            'name_tc' => 'required|string|max:191'
        ]);

        return Topcategory::create([
            'specialcode_tc'=>$request['specialcode_tc'],
            'name_tc'=>$request['name_tc'],
            'name_tc_web'=>$request['name_tc_web'],
            'photo1'=>$request['photo1'],
            'photo2'=>$request['photo2'],
            'photo3'=>$request['photo3'],
            'short_description'=>$request['short_description'],
            'meta_description'=>$request['meta_description'],
            'description'=>$request['description'],
            'menu'=>$request['menu'],
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
        return Topcategory::findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Topcategory::findorFail($id);
        $extras->moveOrderUp();

        return ['message'=>'topcategory reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Topcategory::findorFail($id);
        $extras->moveOrderDown();


        return ['message'=>'topcategory reordered'];
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $extras = Topcategory::findOrFail($id);

        $this->validate($request, [
            'name_tc' => 'required|string|max:191',

        ]);
        $extras -> update($request -> all());

        return ['message' => 'update topcategory'];
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
        $extras =Topcategory::findorFail($id);

        $extras->delete();


        return ['message'=>'topcategory deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $extras = Topcategory::where(function($query) use ($search){
                $query->where('name_tc','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $extras = Topcategory::ordered()->paginate(10);
        }
        return $extras;
    }
}
