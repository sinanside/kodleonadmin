<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hizmetturs;
use App\Althizmetturs;
use App\Image;
use Images;

class althizmetturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Althizmetturs::with('hizmettur','localization')->ordered()->paginate(10);
        }
    }
    public function all($id)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            return Althizmetturs::where('hiz_id', '=', $id)->get();}

    }
    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Althizmetturs::with('hizmettur','localization')->ordered()->paginate(10);
        }
        else
        {
            return Althizmetturs::with('hizmettur','localization')->where("language", "=", $id)->ordered()->paginate(10);
        }
    }
    public function listbylang2($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Althizmetturs::with('hizmettur','localization')->ordered()->get();
        }
        else
        {
            return Althizmetturs::with('hizmettur','localization')->where("language", "=", $id)->ordered()->get();
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
                'hiz_id' => 'required|integer|min:1',
                'title' => 'required|string|max:191'
            ]);

            return Althizmetturs::create([
                'hiz_id' => $request['hiz_id'],
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
            $althizmetturs = Althizmetturs::with('hizmettur')->findOrFail($id);
            $this->validate($request, [
                'hiz_id' => 'required|integer|min:1',
                'title' => 'required|string|max:191'
            ]);
            $althizmetturs->slug = null;
            $althizmetturs->update($request->all());

            return ['message' => 'update althizmettur'];
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
        $categories =Althizmetturs::findorFail($id);
        $categories->delete();

        return ['message'=>'althizmettur deleted'];
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $althizmetturs =Althizmetturs::findorFail($id);
        $althizmetturs->moveOrderUp();

        return ['message'=>'althizmettur reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $althizmetturs =Althizmetturs::findorFail($id);
        $althizmetturs->moveOrderDown();


        return ['message'=>'althizmettur reordered'];
    }

    public function search()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($search = \Request::get('q')) {
                $althizmetturs = Althizmetturs::with('hizmettur','localization')->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orwhereHas('hizmettur', function($query) use ($search) {
                        $query->where('title', 'LIKE', "%$search%");
                    });
                })->paginate(10);
            } else {
                $althizmetturs = Althizmetturs::with('hizmettur','localization')->ordered()->paginate(10);
            }
            return $althizmetturs;
        }
    }
}
