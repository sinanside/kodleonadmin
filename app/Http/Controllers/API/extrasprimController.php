<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Extrasprim;
use App\Image;
use Images;

class extrasprimController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Extrasprim::where('slug', '=', 'prim')->ordered()->paginate(10);
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
            $name = "prim_".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/prim/thumbs/' . $name));

            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/prim/' . $name));

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

        return Extrasprim::create([
            'slug'=>'prim',
            'title'=>$request['title'],
            'picture'=>$request['picture'],
            'icon'=>$request['icon'],
            'short_content1'=>$request['short_content1'],
            'short_content2'=>$request['short_content2'],
            'short_content3'=>$request['short_content3'],
            'description'=>$request['description'],
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
        return Extrasprim::findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Extrasprim::findorFail($id);
        $extras->moveOrderUp();

        return ['message'=>'prim reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $extras =Extrasprim::findorFail($id);
        $extras->moveOrderDown();


        return ['message'=>'prim reordered'];
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $extras = Extrasprim::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',

        ]);
        $extras -> update($request -> all());

        return ['message' => 'update prim'];
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
        $extras =Extrasprim::findorFail($id);

        $extras->delete();


        return ['message'=>'prim deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $extras = Extrasprim::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $extras = Extrasprim::ordered()->paginate(10);
        }
        return $extras;
    }
}
