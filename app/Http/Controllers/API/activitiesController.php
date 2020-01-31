<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Activities;
use App\Image;
use Images;

class activitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Activities::ordered()->paginate(10);

    }

    public function listbylang($id,$tur)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Activities::with('localization')->ordered()->paginate(10);
        }
        else
        {
            return Activities::with('localization')->where("language", "=", $id)->where("tur", "=", $tur)->ordered()->paginate(10);
        }
    }

    public function listbylang2($id)
        {
            return Activities::with('localization')->where("language", "=", $id)->ordered()->get();
        }
    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));

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
    public function storeimage1(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/activities/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/activities/' . $name));
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


    public function store(Request $request)
    {
        //return $request->all();

        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        return Activities::create([
            'start_date'=>$request['start_date'],
            'end_date'=>$request['end_date'],
            'tur'=>$request['tur'],
            'title'=>$request['title'],
            'meta_title'=>$request['meta_title'],
            'meta_description'=>$request['meta_description'],
            'meta_keywords'=>$request['meta_keywords'],
            'short_description1'=>$request['short_description1'],
            'short_description2'=>$request['short_description2'],
            'short_description3'=>$request['short_description3'],
            'short_description4'=>$request['short_description4'],
            'short_description5'=>$request['short_description5'],
            'short_description6'=>$request['short_description6'],
            'short_description7'=>$request['short_description7'],
            'short_description8'=>$request['short_description8'],
            'short_description9'=>$request['short_description9'],
            'short_description10'=>$request['short_description10'],
            'link1_text'=>$request['link1_text'],
            'link1_href'=>$request['link1_href'],
            'link2_text'=>$request['link2_text'],
            'link2_href'=>$request['link2_href'],
            'link3_text'=>$request['link3_text'],
            'link3_href'=>$request['link3_href'],
            'link4_text'=>$request['link4_text'],
            'link4_href'=>$request['link4_href'],
            'link5_text'=>$request['link5_text'],
            'link5_href'=>$request['link5_href'],
            'link6_text'=>$request['link6_text'],
            'link6_href'=>$request['link6_href'],
            'picture1'=>$request['picture1'],
            'picture2'=>$request['picture2'],
            'picture3'=>$request['picture3'],
            'picture4'=>$request['picture4'],
            'picture5'=>$request['picture5'],
            'picture6'=>$request['picture6'],
            'picture7'=>$request['picture7'],
            'picture8'=>$request['picture8'],
            'picture1_alt'=>$request['picture1_alt'],
            'picture2_alt'=>$request['picture2_alt'],
            'picture3_alt'=>$request['picture3_alt'],
            'picture4_alt'=>$request['picture4_alt'],
            'picture5_alt'=>$request['picture5_alt'],
            'picture6_alt'=>$request['picture6_alt'],
            'picture7_alt'=>$request['picture7_alt'],
            'picture8_alt'=>$request['picture8_alt'],
            'description1'=>$request['description1'],
            'description2'=>$request['description2'],
            'description3'=>$request['description3'],
            'description4'=>$request['description4'],
            'description5'=>$request['description5'],
            'description6'=>$request['description6'],
            'description7'=>$request['description7'],
            'description8'=>$request['description8'],
            'language'=>$request['language'],
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
        return Activities::with('localization')->findOrFail($id);

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
        $id = $request->id;
        $activities =Activities::with('localization')->findorFail($id);
        $activities->moveOrderUp();

        return ['message'=>'ourteam reordered'];
    }

    public function down(Request $request)
    {
        $id = $request->id;
        $activities =Activities::with('localization')->findorFail($id);
        $activities->moveOrderDown();


        return ['message'=>'ourteam reordered'];
    }

    public function update(Request $request, $id)
    {
        $activities = Activities::with('localization')->findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:191',

        ]);
        $activities -> update($request -> all());

        return ['message' => 'update activities'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activities =Activities::with('localization')->findorFail($id);

        $activities->delete();


        return ['message'=>'post deleted'];
    }
    public function search($id,$tur){
        if ($search = \Request::get('q')) {
            $activities = Activities::
            where("language", "=", $id)->
            where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $activities = Activities::with('localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
        return $activities;
    }
}
