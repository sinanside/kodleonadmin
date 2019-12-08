<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\carousel;
use App\Image;
use Images;


class carouselController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return carousel::ordered()->paginate(10);
    }

    public function allcarousels()
    {
        $this->authorize('isAdmin');
        return carousel::all();

    }
    public function storeimage(Request $request)
    {
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = 'crsl_'.time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(150, 150)->save(public_path('/img/carousel/thumbs/' . $name));
            $Image = Images::make($image)->save(public_path('/img/carousel/' . $name));

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
            'carousel_title' => 'required|string|max:191'

        ]);

        return carousel::create([
            'carousel_title'=>$request['carousel_title'],
            'image'=>$request['image'],
            'image_alt'=>$request['image_alt'],
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $carousel = carousel::findOrFail($id);

        $this->validate($request, [
            'carousel_title' => 'required|string|max:191'
        ]);

        $carousel -> update($request -> all());

        return ['message' => 'update carousel'];
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
        $carousel =carousel::findorFail($id);

        $carousel->delete();


        return ['message'=>'carousel deleted'];
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $carousel =carousel::findorFail($id);
        $carousel->moveOrderUp();

        return ['message'=>'carousel reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $carousel =carousel::findorFail($id);
        $carousel->moveOrderDown();


        return ['message'=>'carousel reordered'];
    }

    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $carousels = carousel::where(function($query) use ($search){
                $query->where('carousel_title','LIKE',"%$search%")
                    ->orWhere('top_text','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $carousels = carousel::ordered()->paginate(10);
        }
        return $carousels;
    }
}
