<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hizmetcreator;
use App\Image;
use Images;
use File;


class hizmetlerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Hizmetcreator::with('hizmettur','althizmettur','localization')->orderby('hiz_id')->ordered()->paginate(10);
    }
    public function all()
    {
        $this->authorize('isAdmin');
        return Hizmetcreator::with('hizmettur','althizmettur','localization')->ordered()->paginate(10);
    }
    public function eslestir(Request $request)
    {
        $this->authorize('isAdmin');
        $random = mt_rand(1000000000, 9999999999);
        if($request["icerik2"]>0)
        {
            $hizmet1 = Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($request["id"]);
            $refcode=$hizmet1->special_code;
            if($refcode > 0)
            {
                $hizmet2 = Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($request["icerik2"])->update(['special_code' => $refcode]);
            }
            else
            {
                $hizmet1->update(['special_code' => $random]);
                $hizmet2 = Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($request["icerik2"])->update(['special_code' => $random]);            }
            return "pair success";
        }
        else
        {
            return 'pair failed';
        }

    }

    public function eslestirmesil(Request $request)
    {
        $this->authorize('isAdmin');
        $hizmet1 = Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($request["id"])->update(['special_code' => null]);
        return "eşleştirme silindi";
    }
    public function searchbyspecialcode($code){
        $this->authorize('isAdmin');
        $pages = Hizmetcreator::with('hizmettur','althizmettur','localization')->where(function($query) use ($code){
            $query->where('special_code','=',"$code");
        })->paginate(10);

        return $pages;
    }

    public function listbylang($id,$id2)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Hizmetcreator::with('hizmettur','althizmettur','localization')->where("tur", "=", $id2)->orderby('hiz_id')->ordered()->paginate(10);
        }
        else
        {
            return Hizmetcreator::with('hizmettur','althizmettur','localization')->where("language", "=", $id)->where("tur", "=", $id2)->orderby('hiz_id')->ordered()->paginate(10);
        }
    }
    public function listbylang2($id,$id2)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Hizmetcreator::with('hizmettur','althizmettur','localization')->where("tur", "=", $id2)->ordered()->get();
        }
        else
        {
            return Hizmetcreator::with('hizmettur','althizmettur','localization')->where("language", "=", $id)->where("tur", "=", $id2)->ordered()->get();
        }
    }
    public function listbyid(Request $request)
    {
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            return Hizmetcreator::with('hizmettur', 'althizmettur', 'localization')->where(function($query) use ($search){
                $query->where('hiz_id','=',"%$search%");
            })->andwhere('althiz_id', '<>', "0")->ordered()->paginate(10);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'language' => 'required|numeric|min:0|not_in:0',
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'meta_keywords' => 'nullable|string|max:191'

        ]);

        $page =  Hizmetcreator::create([
            'name'=>$request['name'],
            'tur'=>$request['tur'],
            'hiz_id'=>$request['hiz_id'],
            'althiz_id'=>$request['althiz_id'],
            'language'=>$request['language'],
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

        ]);

        //$path = public_path().'/img/'.$page->slug;
        //File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        // File::isDirectory($path.'/thumbs') or File::makeDirectory($path.'/thumbs', 0777, true, true);

    }

    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "cnt_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));

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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
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
        return Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Hizmetcreator::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'pages reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Hizmetcreator::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'pages reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Hizmetcreator::with('hizmettur','althizmettur','localization')->findOrFail($id);

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
        $pages =Hizmetcreator::with('hizmettur','althizmettur','localization')->findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Hizmetcreator::with('hizmettur','althizmettur','localization')->where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Hizmetcreator::with('hizmettur','althizmettur','localization')->ordered()->paginate(10);
        }
        return $pages;
    }
}
