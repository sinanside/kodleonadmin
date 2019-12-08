<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\ContactUS;
use App\Image;
use Images;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        return ContactUS::orderBy('created_at', 'desc')->paginate(10);

    }
    public function storeimage(Request $request)
    {
        if($request->file('file'))
        {
            $image = $request->file('file');
            $name = "contactus".time().'.'.$image->getClientOriginalExtension();

            $thumbnailImage = Images::make($image)->resize(150, 150)->save(public_path('/img/contactus/thumbs/' . $name));
            $watermark = Images::make(public_path('/img/watermark.png'));
            $Image = Images::make($image)->insert($watermark, 'bottom-right', 10, 10)->save(public_path('/img/contactus/' . $name));
            //$image->move(public_path().'/img/social/', $name);
        }

        $image= new Image();
        $image->image_name = $name;
        $image->save();

        return response()->json([
            'data' => $name
        ], 200);
    }

    public function store(Request $request)
    {

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

    public function update(Request $request, $id)
    {
        $contactus = ContactUS::findOrFail($id);

        $this->validate($request, [
            'response' => 'required'

        ]);

        Mail::send('email.response',
            array(
                'name' => $request->get('name'),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message'),
                'response' => $request->get('response')

            ), function($message) use ($request)
            {
                $message->from('engin@dizaynschool.com');
                $message->to($request->email, $request->name)->subject('İletişim Mesajınız Hakkında');
            });


        $contactus -> update($request -> all());

        return ['message' => 'update contactus'];
    }

    public function destroy($id)
    {

        $contactus =ContactUS::findorFail($id);

        $contactus->delete();


        return ['message'=>'contactus deleted'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $contactus = ContactUS::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                    ->orWhere('email','LIKE',"%$search%")
                    ->orWhere('phone','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $contactus = ContactUS::ordered()->paginate(10);
        }
        return $contactus;
    }
}
