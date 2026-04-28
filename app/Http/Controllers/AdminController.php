<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{

public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $admin = Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return response()->json([
        'message' => 'Admin registered successfully',
        'admin' => $admin
    ]);
}






    public function login(Request $request)
    {
        // dd("start");
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->put('admin_id', $admin->id);
            // session(['admin_id' => $admin->id]);

            // dd("found");
            return response()->json([
                'status' => 'success',
                'message' => 'Login Successful',
            ], 200);
        }
        // dd("not found");

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid Credentials',
            'userIs'=>$admin
        ], 401);
    }


    function delete(Request $request)
    {

     

        $Article = Article::find($request->id);
        if ($Article) {
            Storage::disk('public')->deleteDirectory($Article->images);

            $Article->delete();

            return response()->json(["Message" => "Deleted successfully"]);
        }

        return response()->json(["Message" => "Post not found"], 404);

    }

    function update(Request $request)
    {
       

        $this->delete($request);
        $this->save($request);
    }

    function save(Request $request)
    {

       
        $request->validate([
            'title'=> 'required',
            'content' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif'
        ]);

        $folderName  = null;
        
        if ($request->hasFile('images')) {
            $folderName = 'post_' . time();

            foreach ($request->file('images') as $image) {

                $image->store($folderName, 'public');
            }

        }


        # this loop for a test
        // for( $i = 0; $i < 10; $i++ ) {

            Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                "images" => $folderName,
                "by"=>"admin"
                ]);
                // }

        return $request->input('content');

    }



  public function readGroup(Request $request)
{
    $Articles = Article::latest()->simplePaginate(10);

    return response()->json($Articles);
}


}