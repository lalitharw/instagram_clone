<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\processPostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

// models
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "images"=>"required|mimes:png,jpg,webp,jpeg|max:2048",
            "caption" => "string"
        ]);

        DB::beginTransaction();

        try{
            $post = new Post();
            $post->caption = $request->caption;
            $post->save();

            if($request->hasFile("images")){
                processPostImage::dispatch($post->id,$request->file("images"));
            }

            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();

        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage()
        ], 500);
        }



    }
}
