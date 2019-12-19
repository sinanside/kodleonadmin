<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blogcomments;


class BlogcommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Blogcomments::with('makale','localization')->ordered()->paginate(10);
    }
    public function all()
    {
        $this->authorize('isAdmin');
        return Blogcomments::with('makale','localization')->ordered()->get();
    }
    public function listbylang($id)
    {
        $this->authorize('isAdmin');
        if($id==0)
        {
            return Blogcomments::with('makale','localization')->ordered()->paginate(10);
        }
        else
        {
            return Blogcomments::with('makale','localization')->where("language", "=", $id)->ordered()->paginate(10);
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
            'comment' => 'required|string|max:191'

        ]);

        $page =  Blogcomments::create([
            'user' =>1,
            'blg_id'=>$request['blg_id'],
            'name'=>$request['name'],
            'comment'=>$request['comment'],
            'language'=>$request['language']

        ]);

    }

    public function show($id)
    {
        $this->authorize('isAdmin');
        return Blogcomments::with('makale','localization')->findOrFail($id);
    }

    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Blogcomments::findorFail($id);
        $pages->moveOrderUp();

        return ['message'=>'comments reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $pages =Blogcomments::findorFail($id);
        $pages->moveOrderDown();


        return ['message'=>'comments reordered'];
    }

    public function update(Request $request, $id)
    {
        $page = Blogcomments::with('makale','localization')->findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191'

        ]);

        $page -> update($request -> all());

        return ['message' => 'update the blogcomments info'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $pages =Blogcomments::with('makale','localization')->findorFail($id);

        $pages->delete();


        return ['message'=>'page deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $pages = Blogcomments::with('makale','localization')->where(function($query) use ($search){
                $query->where('comment','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $pages = Blogcomments::with('makale','localization')->ordered()->paginate(10);
        }
        return $pages;
    }
}
