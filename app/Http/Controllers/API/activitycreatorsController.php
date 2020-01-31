<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activitycreators;
use App\Image;
use Images;
use File;


class activitycreatorsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Activitycreators::with('activity','localization')->ordered()->paginate(10);
    }
    public function all()
    {
        $this->authorize('isAdmin');
        return Activitycreators::with('activity','localization')->ordered()->paginate(10);
    }

    public function listbylang($id)
    {
       $this->authorize('isAdmin');
       return Activitycreators::with('activity','localization')->where("language", "=", $id)->orderBy('activity_id')->ordered()->paginate(10);
    }
    public function listbylang2($id,$id2)
    {
       $this->authorize('isAdmin');
       return Activitycreators::with('activity','localization')->where("language", "=", $id)->where("activity_id", "=", $id2)->orderBy('activity_id')->ordered()->get();

    }
    public function listbyid(Request $request)
    {
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            return Activitycreators::with('activity', 'localization')->where(function($query) use ($search){
                $query->where('name','=',"%$search%");
            })
            ->ordered()->paginate(10);
        }
    }

     public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'activity_id' => 'required',
            'tur'=> 'required'

        ]);

        $page =  Activitycreators::create([
            'name'=>$request['name'],
            'tur'=>$request['tur'],
            'activity_id'=>$request['activity_id'],
            'language'=>$request['language'],
            'short_description1'=>$request['short_description1'],
            'short_description2'=>$request['short_description2'],
            'youtube_link'=>$request['youtube_link'],
            'video_link'=>$request['video_link'],
            'picture_link'=>$request['picture_link'],
            'active'=>$request['active']

        ]);


    }

    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "act_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));

            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage1(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }

    public function show($id)
    {
        $this->authorize('isAdmin');
        return Activitycreators::with('activity', 'localization')->findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Activitycreators::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'pages reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Activitycreators::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'pages reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Activitycreators::with('activity', 'localization')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
             'activity_id' => 'required',
             'tur'=> 'required'

        ]);

        $page -> update($request -> all());

        return ['message' => 'update the pagecreator info'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $pages =Activitycreators::with('activity', 'localization')->findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Activitycreators::with('activity', 'localization')->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Activitycreators::with('activity', 'localization')->ordered()->paginate(10);
        }
        return $pages;
    }
}
