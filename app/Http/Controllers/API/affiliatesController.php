<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Affiliates;
use App\Image;
use Images;
use File;


class affiliatesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Affiliates::with('localization')->ordered()->paginate(10);
    }
    public function all()
    {
        $this->authorize('isAdmin');
        return Affiliates::with('localization')->ordered()->get();
    }

    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Affiliates::with('localization')->ordered()->paginate(10);
        }
        else
        {
            return Affiliates::with('localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
    }

    public function listbylang2($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Affiliates::with('localization')->ordered()->get();
        }
        else
        {
            return Affiliates::with('localization')->where("language", "=", $id)->ordered()->get();
        }
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'language' => 'required|numeric|min:1',
            'name' => 'required|string|max:191',

        ]);

        $page =  Affiliates::create([
            'name'=>$request['name'],
            'city'=>$request['city'],
            'region'=>$request['region'],
            'address'=>$request['address'],
            'tel'=>$request['tel'],
            'language'=>$request['language'],
            'short_description1'=>$request['short_description1'],
            'short_description2'=>$request['short_description2'],
            'short_description3'=>$request['short_description3'],
            'picture1'=>$request['picture1'],
            'picture2'=>$request['picture2'],
            'picture3'=>$request['picture3'],
            'picture4'=>$request['picture4'],
            'picture5'=>$request['picture5'],
            'picture6'=>$request['picture6'],
            'picture7'=>$request['picture7'],
            'picture8'=>$request['picture8'],
            'description1'=>$request['description1'],


        ]);


    }

    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));

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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage2(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage3(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage4(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage5(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage6(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage7(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimage8(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
        }
    }
    public function storeimagebyeditor(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/affiliates/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/affiliates/' . $name));
                //$image->move(public_path().'/img/social/', $name);
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
        return Affiliates::with('localization')->findOrFail($id);
    }

    public function searchbyspecialcode($code){
        $this->authorize('isAdmin');
        $pages = Affiliates::with('localization')->where(function($query) use ($code){
            $query->where('special_code','=',"$code");
        })->paginate(10);

        return $pages;
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Affiliates::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'pages reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Affiliates::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'pages reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Affiliates::with('localization')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'meta_title' => 'sometimes|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'meta_keywords' => 'nullable|string|max:191'

        ]);

        $page -> update($request -> all());

        return ['message' => 'update the pagecreator info'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $pages =Affiliates::with('localization')->findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Affiliates::with('localization')->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Affiliates::with('localization')->ordered()->paginate(10);
        }
        return $pages;
    }
}
