<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\carousel;
use App\carousel_alt;


class carouselaltController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return carousel_alt::with('carousel')->ordered()->paginate(10);
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'carousel_id' => 'required|numeric|min:0|not_in:0'
        ]);

        return carousel_alt::create([
            'title'=>$request['title'],
            'carousel_id'=>$request['carousel_id'],
            'color'=>$request['color'],
            'delay'=>$request['delay'],
            'x1'=>$request['x1'],
            'x2'=>$request['x2'],
            'x3'=>$request['x3'],
            'x4'=>$request['x4'],
            'y1'=>$request['y1'],
            'y2'=>$request['y2'],
            'y3'=>$request['y3'],
            'y4'=>$request['y4'],
            'fontsize1'=>$request['fontsize1'],
            'fontsize2'=>$request['fontsize2'],
            'fontsize3'=>$request['fontsize3'],
            'fontsize4'=>$request['fontsize4'],
            'lineheight1'=>$request['lineheight1'],
            'lineheight2'=>$request['lineheight2'],
            'lineheight3'=>$request['lineheight3'],
            'lineheight4'=>$request['lineheight4'],
            'fontweight1'=>$request['fontweight1'],
            'fontweight2'=>$request['fontweight2'],
            'fontweight3'=>$request['fontweight3'],
            'fontweight4'=>$request['fontweight4'],
            'visibility1'=>$request['visibility1'],
            'visibility2'=>$request['visibility2'],
            'visibility3'=>$request['visibility3'],
            'visibility4'=>$request['visibility4'],
            'active'=>$request['active']
        ]);
    }

    public function show($id)
    {
        $this->authorize('isAdmin');
        return carousel_alt::with('carousel')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $carousel_alt = carousel_alt::findOrFail($id);
        $this->validate($request, [
                'title' => 'required|string|max:191',
                'carousel_id' => 'required|numeric|min:0|not_in:0'

            ]);
            $carousel_alt->update($request->all());

            return ['message' => 'update carousel_alt'];

    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $carousel_alt =carousel_alt::findorFail($id);
        $carousel_alt->delete();


        return ['message'=>'carousel_alt deleted'];
    }
    public function up(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $carousel_alt =carousel_alt::findorFail($id);
        $carousel_alt->moveOrderUp();

        return ['message'=>'carousel_alt reordered'];
    }

    public function down(Request $request)
    {
        $this->authorize('isAdmin');
        $id = $request->id;
        $carousel_alt =carousel_alt::findorFail($id);
        $carousel_alt->moveOrderDown();


        return ['message'=>'carousel_alt reordered'];
    }

    public function search()
    {
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $carousel_alt = carousel_alt::with('carousel')->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('slug', 'LIKE', "%$search%");
                })->paginate(10);
            } else {
            $carousel_alt = carousel_alt::with('carousel')->ordered()->paginate(10);
            }
            return $carousel_alt;

    }
}
