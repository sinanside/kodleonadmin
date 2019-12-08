<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kazancplani;
use App\Image;
use Images;

class kazancplaniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        return Kazancplani::ordered()->paginate(10);

    }

    public function storeimage1(Request $request)
    {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "kzncplan_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/kazancplani/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/kazancplani/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
    }
    public function storeimage2(Request $request)
    {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "kzncplan_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/kazancplani/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/kazancplani/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);

    }
    public function storeimage3(Request $request)
    {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "kzncplan_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/kazancplani/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/kazancplani/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);

    }

    public function storeimagebyeditor(Request $request)
    {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "kzncplan_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/kazancplani/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/kazancplani/' . $name));
                //$image->move(public_path().'/img/social/', $name);
            }

            $image = new Image();
            $image->image_name = $name;
            $image->save();

            return response()->json([
                'data' => $name
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        return Kazancplani::create([
            'title' => $request['title'],
            'short_content1' => $request['short_content1'],
            'short_content2' => $request['short_content2'],
            'short_content3' => $request['short_content3'],
            'content' => $request['content'],
            'photo1' => $request['photo1'],
            'photo1_alt' => $request['photo1_alt'],
            'photo2' => $request['photo2'],
            'photo2_alt' => $request['photo2_alt'],
            'photo3' => $request['photo3'],
            'photo3_alt' => $request['photo3_alt'],
            'active' => $request['active']
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
        return Kazancplani::findOrFail($id);

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
        $kazancplani = Kazancplani::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);
        $kazancplani->update($request->all());

        return ['message' => 'update kazancplani'];
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
        $kazancplani =Kazancplani::findorFail($id);
        $kazancplani->delete();


        return ['message'=>'kazancplani deleted'];
    }
    public function up(Request $request)
    {
        $id = $request->id;
        $kazancplani =Kazancplani::findorFail($id);
        $kazancplani->moveOrderUp();

        return ['message'=>'kazancplani reordered'];
    }

    public function down(Request $request)
    {
        $id = $request->id;
        $kazancplani =Kazancplani::findorFail($id);
        $kazancplani->moveOrderDown();


        return ['message'=>'kazancplani reordered'];
    }

    public function search(){
            if ($search = \Request::get('q')) {
                $kazancplani = Kazancplani::where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
                $kazancplani = Kazancplani::ordered()->paginate(10);
            }
            return $kazancplani;

    }
}
