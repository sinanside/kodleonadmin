<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pagecreator;
use Images;
use File;


class iceriklerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Pagecreator::ordered()->paginate(10);
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
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:191',
            'meta_keywords' => 'nullable|string|max:191'

        ]);

        $page =  Pagecreator::create([
            'name'=>$request['name'],
            'meta_title'=>$request['meta_title'],
            'meta_description'=>$request['meta_description'],
            'meta_keywords'=>$request['meta_keywords']
        ]);

        $path = public_path().'/img/'.$page->slug;
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        File::isDirectory($path.'/thumbs') or File::makeDirectory($path.'/thumbs', 0777, true, true);

        return $page;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('isAdmin');
        return Pagecreator::findOrFail(1);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Pagecreator::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'pages reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Pagecreator::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'pages reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Pagecreator::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'meta_title' => 'sometimes|string|max:191',
            'meta_description' => 'sometimes|string|max:191',
            'meta_keywords' => 'sometimes|string|max:191'

        ]);

        $page -> update($request -> all());

        return ['message' => 'update the pagecreator info'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $pages =Pagecreator::findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Pagecreator::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Pagecreator::ordered()->paginate(10);
        }
        return $pages;
    }
}
