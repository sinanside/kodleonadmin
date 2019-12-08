<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hizmetturs;
use App\Image;
use Images;

class hizmetturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Hizmetturs::with('localization')->ordered()->paginate(10);
        }
    }
    public function all()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Hizmetturs::with('localization')->get();}


    }
    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Hizmetturs::with('localization')->ordered()->paginate(10);
        }
        else
        {
            return Hizmetturs::with('localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
    }

    public function listbylang2($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Hizmetturs::with('localization')->ordered()->get();
        }
        else
        {
            return Hizmetturs::with('localization')->where("language", "=", $id)->ordered()->get();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeimage(Request $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/hizmetler/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark.png'));
                //$Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
                $Image = Images::make($image)->save(public_path('/img/hizmetler/' . $name));
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            $this->validate($request, [
                'title' => 'required|string|max:191'
            ]);

            return Hizmetturs::create([
                'title' => $request['title'],
                'short_description' => $request['short_description'],
                'photo' => $request['photo'],
                'photo_alt' => $request['photo_alt'],
                'language' => $request['language'],
                'active' => $request['active']
            ]);
        }
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            $hizmetturs = Hizmetturs::findOrFail($id);
            $this->validate($request, [
                'title' => 'required|string|max:191'
            ]);
            $hizmetturs->slug = null;
            $hizmetturs->update($request->all());

            return ['message' => 'update hizmettur'];
        }
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
        $categories =Hizmetturs::findorFail($id);
        $categories->delete();

        return ['message'=>'hizmettur deleted'];
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $hizmetturs =Hizmetturs::findorFail($id);
        $hizmetturs->moveOrderUp();

        return ['message'=>'hizmettur reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $hizmetturs =Hizmetturs::findorFail($id);
        $hizmetturs->moveOrderDown();


        return ['message'=>'hizmettur reordered'];
    }

    public function search()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($search = \Request::get('q')) {
                $hizmetturs = Hizmetturs::where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('short_description', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
                $hizmetturs = Hizmetturs::with('localization')->ordered()->paginate(10);
            }
            return $hizmetturs;
        }
    }
}
