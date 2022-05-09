<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Image;

class PostController extends Controller
{
    public function post_upload(Request $request)
    {
        $request->validate([
            'title' => 'required|max:250',
            'post' => 'required',
            // 'file' => 'required',
        ]);

        if ($request->file){
            $post = new Post();
            $post->title = $request->title;
            $post->post = $request->post;
            $post->user_id = Auth::user()->id;
////            return $request->file;

            if ($post->save()){
                // $file_name = time()."_".$request->file('file')->getClientOriginalExtensionension();
                // $request->file->move( 'uploads', $request->file('file'));
                $request->file('file')->store('upload');
                $image = new PostImage();
                $image->image = $request->file('file');
                $image->save();
            }

            dd('success');
        }
    }
}
