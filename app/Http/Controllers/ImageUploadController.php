<?php

namespace App\Http\Controllers;
use App\Image;
use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class ImageUploadController extends Controller
{
   public function home(){
   	$images=Image::all();
   	 return view('home',compact('images'));
   }
   // save image to database
   public function saveImages($name, $image_url)
   {
       $image = new Image();
       $image->image_name = $name;
       $image->image_url = $image_url;

       $image->save();
   }

// Image upload method
   public function uploadImages(Request $request)
   {
       $this->validate($request,[
           'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
       ]);

       // $image_name = $request->file('image_name')->getRealPath();;

       // Cloudder::upload($image_name, null);

       // return redirect()->back()->with('status', 'Image Uploaded Successfully');
        $image = $request->file('image_name');

       $name = $request->file('image_name')->getClientOriginalName();

       $image_name = $request->file('image_name')->getRealPath();;

       Cloudder::upload($image_name, null);

       list($width, $height) = getimagesize($image_name);

       $image_url= Cloudder::show(Cloudder::getPublicId(), ["width" => $width, "height"=>$height]);

       //save to uploads directory
       $image->move(public_path("uploads"), $name);

       //Save images
       $this->saveImages( $name, $image_url);

       return redirect()->back()->with('status', 'Image Uploaded Successfully');

   }
}
