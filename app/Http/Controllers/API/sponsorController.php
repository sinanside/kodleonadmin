<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sponsor;

class sponsorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Sponsor::orderBy('id', 'DESC')->paginate(10);
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');
        $this->validate($request, [
            'title' => 'required|string|max:191'
        ]);

        return Sponsor::create([
            'title'=>$request['title'],
            'url'=>$request['url'],
            'url2'=>$request['url2'],
            'active'=>$request['active']
        ]);
    }

    public function show($id)
    {
        $this->authorize('isAdmin');
        return Sponsor::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');

        $sponsor = Sponsor::findOrFail($id);
        $this->validate($request, [
            'title' => 'required|string|max:191',

        ]);
        $sponsor -> update($request -> all());

        return ['message' => 'update sponsor'];
    }

    public function updateactive()
    {
        $this->authorize('isAdmin');

        $sponsor = Sponsor::where('active',1)->update(['active' => '0']);

        return ['message' => 'updateactive sponsor'];
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
        $sponsor =Sponsor::findorFail($id);

        $sponsor->delete();


        return ['message'=>'sponsor deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $sponsor = Sponsor::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $sponsor = Sponsor::orderBy('id', 'DESC')->paginate(10);

        }
        return $sponsor;
    }
}
