<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Hizmetturs;
use App\Althizmetturs;
use App\Localizations;
use App\Image;
use Images;

class localizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
{
    if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
        return Localizations::ordered()->paginate(10);
    }
}
    public function active()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Localizations::where('active','=','1')->ordered()->get();
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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/languages/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark.png'));
                //$Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/hizmetler/' . $name));
                $Image = Images::make($image)->save(public_path('/img/languages/' . $name));
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

            return Localizations::create([
                'title' => $request['title'],
                'short_title' => $request['short_title'],
                'image' => $request['image'],
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
            $localizations = Localizations::findOrFail($id);
            $this->validate($request, [
                'title' => 'required|string|max:191'
            ]);
            $localizations->update($request->all());

            return ['message' => 'update localization'];
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
        $categories =Localizations::findorFail($id);
        $categories->delete();

        return ['message'=>'localization deleted'];
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $althizmetturs =Localizations::findorFail($id);
        $althizmetturs->moveOrderUp();

        return ['message'=>'localization reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $localizations =Localizations::findorFail($id);
        $localizations->moveOrderDown();


        return ['message'=>'localization reordered'];
    }

    public function search()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($search = \Request::get('q')) {
                $localizations = Localizations::where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
                $localizations = Localizations::ordered()->paginate(10);
            }
            return $localizations;
        }
    }
}
