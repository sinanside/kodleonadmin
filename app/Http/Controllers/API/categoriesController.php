<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Categories;
use App\Image;
use Images;

class categoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Categories::ordered()->paginate(10);
        }
    }
    public function allcategories()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
        return Categories::all();}

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

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/categories/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/categories/' . $name));
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
                $name = "blgct_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/categories/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/categories/' . $name));
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
                'title' => 'required|string|max:191',
                'mainpage_limit' => 'integer'
            ]);

            return Categories::create([
                'title' => $request['title'],
                'short_description' => $request['short_description'],
                'photo' => $request['photo'],
                'photo_alt' => $request['photo_alt'],
                'description' => $request['description'],
                'mainpage_limit' => $request['mainpage_limit'],
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
            $categories = Categories::findOrFail($id);
            $this->validate($request, [
                'title' => 'required|string|max:191',
                'mainpage_limit' => 'integer'

            ]);
            $categories->slug = null;
            $categories->update($request->all());

            return ['message' => 'update categories'];
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
        $categories =Categories::findorFail($id);
        $categories->delete();

        return ['message'=>'category deleted'];
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $categories =Categories::findorFail($id);
        $categories->moveOrderUp();

        return ['message'=>'categories reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $categories =Categories::findorFail($id);
        $categories->moveOrderDown();


        return ['message'=>'categories reordered'];
    }

    public function search()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($search = \Request::get('q')) {
                $categories = Categories::where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('short_description', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
                $categories = Categories::ordered()->paginate(10);
            }
        return $categories;
        }
    }
}
