<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Galerycreator;
use App\Image;
use Images;
use File;


class galeryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Galerycreator::with('hizmettur','localization')->ordered()->paginate(10);
    }
    public function all()
    {
        $this->authorize('isAdmin');
        return Galerycreator::with('hizmettur','localization')->ordered()->paginate(10);
    }
    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Galerycreator::with('hizmettur','localization')->ordered()->paginate(10);
        }
        else
        {
            return Galerycreator::with('hizmettur','localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
    }
    public function listbyid(Request $request)
    {
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            return Galerycreator::with('hizmettur', 'localization')->where(function($query) use ($search){
                $query->where('hiz_id','=',"%$search%");
            })->ordered()->paginate(10);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:191'

        ]);

        $page =  Galerycreator::create([
            'name'=>$request['name'],
            'hiz_id'=>$request['hiz_id'],
            'language'=>$request['language'],
            'short_description1'=>$request['short_description1'],
            'picture1'=>$request['picture1'],
            'picture1_alt'=>$request['picture1_alt']

        ]);

        //$path = public_path().'/img/galery';
        //File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        //File::isDirectory($path.'/thumbs') or File::makeDirectory($path.'/thumbs', 0777, true, true);

    }

    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "glry_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/gallery/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/gallery/' . $name));

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
                $name = "glry_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/gallery/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/gallery/' . $name));
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
        return Galerycreator::with('hizmettur','localization')->findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Galerycreator::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'pages reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Galerycreator::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'pages reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Galerycreator::with('hizmettur','localization')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'

        ]);

        $page -> update($request -> all());

        return ['message' => 'update the pagecreator info'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $pages =Galerycreator::with('hizmettur','localization')->findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Galerycreator::with('hizmettur','localization')->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Galerycreator::with('hizmettur','localization')->ordered()->paginate(10);
        }
        return $pages;
    }
}
