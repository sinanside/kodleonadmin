<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Categories;
use App\Image;
use Images;

class postController extends Controller
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            return Post::with('user', 'category')->ordered()->paginate(10);
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor'))
        {
            if ($request->file('file')) {
                $image = $request->file('file');
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));

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
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));
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
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));
                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));
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
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));
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
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));
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
                $name = "blg_" . time() . '.' . $image->getClientOriginalExtension();

                $thumbnailImage = Images::make($image)->resize(200, 200)->save(public_path('/img/blog/posts/thumbs/' . $name));

                $watermark = Images::make(public_path('/img/watermark2.png'));
                $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/blog/posts/' . $name));
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
                'cat_id' => 'required|numeric|min:0|not_in:0'
            ]);

            return Post::create([
                'title' => $request['title'],
                'cat_id' => $request['cat_id'],
                'user_id' => auth()->user()->id,
                'meta_title' => $request['meta_title'],
                'meta_description' => $request['meta_description'],
                'meta_keywords' => $request['meta_keywords'],
                'short_content' => $request['short_content'],
                'content' => $request['content'],
                'photo1' => $request['photo1'],
                'photo1_alt' => $request['photo1_alt'],
                'photo2' => $request['photo2'],
                'photo2_alt' => $request['photo2_alt'],
                'photo3' => $request['photo3'],
                'photo3_alt' => $request['photo3_alt'],
                'photo4' => $request['photo4'],
                'photo4_alt' => $request['photo4_alt'],
                'mainpage' => $request['mainpage'],
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Post::with('user', 'category')->findOrFail($id);
            //return Post::findOrFail($id);
        }
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
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            $post = Post::findOrFail($id);
            $this->validate($request, [
                'title' => 'required|string|max:191',
                'cat_id' => 'required|numeric|min:0|not_in:0'

            ]);
            $post->user_id = auth()->user()->id;
            $post->update($request->all());

            return ['message' => 'update post'];
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
        $post =Post::findorFail($id);
        $post->delete();


        return ['message'=>'post deleted'];
    }
    public function up(Request $request)
    {
        $id = $request->id;
        $post =Post::findorFail($id);
        $post->moveOrderUp();

        return ['message'=>'post reordered'];
    }

    public function down(Request $request)
    {
        $id = $request->id;
        $post =Post::findorFail($id);
        $post->moveOrderDown();


        return ['message'=>'post reordered'];
    }

    public function search(){
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            if ($search = \Request::get('q')) {
                $posts = Post::with('user', 'category')->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('slug', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
                $posts = Post::ordered()->paginate(10);
            }
            return $posts;
        }
    }
}
