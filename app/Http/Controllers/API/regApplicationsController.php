<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reg_application;
use App\Cities;

class regApplicationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $this->authorize('isAdmin');
        return Reg_application::orderBy('id', 'DESC')->paginate(10);
    }
    public function regsread()
    {
        $this->authorize('isAdmin');
        return Reg_application::where('reads',0)->update(['reads' => '1']);
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $this->validate($request, [
            'name' => 'required|string|max:191'
        ]);

        return Reg_application::create([
            'name'=>$request['name'],
            'phone'=>$request['phone'],
            'type'=>$request['type'],
            'regdate'=>$request['regdate'],
            'reads'=>$request['reads'],
            'status'=>$request['status']
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
        $this->authorize('isAdmin');
        return Reg_application::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('isAdmin');
        $regs = Reg_application::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',

        ]);
        $regs -> update($request -> all());

        return ['message' => 'update reg_applications'];
    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $regs =Reg_application::findorFail($id);

        $regs->delete();


        return ['message'=>'reg_applications deleted'];
    }
    public function search(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $regs = Reg_application::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $regs = Reg_application::orderBy('id', 'DESC')->paginate(10);
        }
        return $regs;
    }
    public function search2(){
        $this->authorize('isAdmin');
        if ($search = \Request::get('q')) {
            $regs = Reg_application::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $regs = Reg_application::orderBy('id', 'DESC')->paginate(5);
        }
        return $regs;
    }
}
