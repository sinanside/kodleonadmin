<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use App\Image;
use Images;

class productsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Products::ordered()->paginate(10);
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
            $name = "prdcts_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/products/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/products/' . $name));
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
            'title' => 'required|string|max:191'
        ]);

        return Products::create([
            'title'=>$request['title'],
            'short_description'=>$request['short_description'],
            'photo'=>$request['photo'],
            'photo_alt'=>$request['photo_alt'],
            'old_price'=>$request['old_price'],
            'new_price'=>$request['new_price'],
            'active'=>$request['active']
        ]);
    }

    public function show($id)
    {
        $this->authorize('isAdmin');
        return Products::findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Products::findorFail($id);
        $extras->moveOrderUp();

        return ['message'=>'products reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Products::findorFail($id);
        $extras->moveOrderDown();


        return ['message'=>'products reordered'];
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $extras = Products::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',

        ]);
        $extras -> update($request -> all());

        return ['message' => 'update products'];
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
        $extras =Products::findorFail($id);

        $extras->delete();


        return ['message'=>'products deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $extras = Products::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $extras = Products::ordered()->paginate(10);
        }
        return $extras;
    }
}
