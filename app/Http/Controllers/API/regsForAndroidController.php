<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reg_application;
use App\Cities;

class regsForAndroidController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api');
    }

    public function index()
    {
        $regs = Reg_application::with('city')->orderBy('id', 'DESC');

        $response["regs"] = $regs;
        $response["success"] = 1;
        return response()->json($response);
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
            'email'=>$request['email'],
            'city'=>$request['city'],
            'town'=>$request['town'],
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
}
