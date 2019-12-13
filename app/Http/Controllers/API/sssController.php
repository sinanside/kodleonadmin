<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sss;
use App\Image;
use Images;

class sssController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $this->authorize('isAdmin');
        return Sss::with('localization')->ordered()->paginate(10);
    }

    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Sss::with('localization')->ordered()->paginate(10);
        }
        else
        {
            return Sss::with('localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
    }

    public function storeimagebyeditor(Request $request)
    {
        $this->authorize('isAdmin');
        if ($request->file('file')) {
            $image = $request->file('file');
            $name = "sss_" . time() . '.' . $image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/sss/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/sss/' . $name));
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
        $sss =Sss::findorFail($id);
        $sss->moveOrderUp();

        return ['message'=>'sss reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $sss =Sss::findorFail($id);
        $sss->moveOrderDown();


        return ['message'=>'sss reordered'];
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'question' => 'required'
        ]);

        return Sss::create([
            'question'=>$request['question'],
            'answer'=>$request['answer'],
            'mainpage'=>$request['mainpage'],
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
        $sss = Sss::findOrFail($id);

        $this->validate($request, [
            'question' => 'required'

        ]);

        $sss -> update($request -> all());

        return ['message' => 'update sss'];
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
        $sss =Sss::findorFail($id);

        $sss->delete();


        return ['message'=>'sss deleted'];
    }

    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $sss = Sss::where(function($query) use ($search){
                $query->where('question','LIKE',"%$search%")
                    ->orWhere('answer','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $sss = Sss::ordered()->paginate(10);
        }
        return $sss;
    }
}
