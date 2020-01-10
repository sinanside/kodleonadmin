<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Socialmedia;
use App\Image;
use Images;
class SocialmediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Socialmedia::ordered()->paginate(10);

    }


    public function storeimage(Request $request)
    {
        $this->authorize('isAdmin');
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(100, 100)->save(public_path('/img/social/thumbs/' . $name));
            $Image = Images::make($image)->save(public_path('/img/social/' . $name));

            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $socialmedia =Socialmedia::findorFail($id);
        $socialmedia->moveOrderUp();

        return ['message'=>'socialmedia reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $socialmedia =Socialmedia::findorFail($id);
        $socialmedia->moveOrderDown();


        return ['message'=>'socialmedia reordered'];
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        return Socialmedia::create([
            'icon'=>$request['icon'],
            'icon2'=>$request['icon2'],
            'name'=>$request['name'],
            'url'=>$request['url'],
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
        $socialmedia = Socialmedia::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'

        ]);

        $socialmedia -> update($request -> all());

        return ['message' => 'update socialmedia'];
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
        $socialmedia =Socialmedia::findorFail($id);

        $socialmedia->delete();


        return ['message'=>'socialmedia deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $socialmedias = Socialmedia::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('url','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $socialmedias = Socialmedia::ordered()->paginate(10);
        }
        return $socialmedias;
    }
}
