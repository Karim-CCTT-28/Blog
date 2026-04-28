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

        $request->session()->put('admin_id', $admin->id);
        return redirect('/Articles');
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
            return redirect('/Articles');
        }

        return redirect('/')
            ->withInput($request->only('email'))
            ->with('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
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

        //    dd($request->all());
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif'
        ]);

        $folderName = null;

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
            "by" => "admin"
        ]);
        // }

        return response()->json(["staus" => "done"], 200);

    }



    public function readGroup(Request $request)
    {
        $articles = Article::latest()->paginate(10);

        // return response()->json($articles);
        return view('index', compact('articles'));
    }

    public function readOne(Request $request, int $id)
    {
        $article = Article::findOrFail($id);
        return view('article', compact('article'));
    }

}