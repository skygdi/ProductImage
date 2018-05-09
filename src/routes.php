<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use skygdi\ProductImage\model\ProductImage;

Route::get('skygdi/pi/test', function(){
	//echo 'Hello from the calculator package!';
    /*
    //Creating
    ProductImage::create([
        "product_id"    =>  1,
        "description"   =>  "kknd",
        "sort_index"    =>  1
    ]);
    */

    $pi = ProductImage::find(1);
    //$pi->UploadImage( storage_path('app/file.jpg') ); //From local file
    //$pi->UploadImage( $request->file('new_image') );  //From upload form
    //$pi->UploadImageFromUrl("https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png");    //From Internet
    echo "<img src='".url('/').$pi->ImageUrl()."'/>";
});




/*
Image route
 */
Route::get( '/storage/{id}/{filename}', function($id,$filename){
    $path = storage_path().'/app/public/'.$id.'/'.$filename;
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    $response->header("Cache-Control", " private, max-age=1800");
    return $response;
});




/*
Route::get('skygdi/paypal/test', 'skygdi\paypal\CommonController@test');
Route::post('skygdi/paypal/test/create', 'skygdi\paypal\TestController@TestCreate');
Route::post('skygdi/paypal/test/execute', 'skygdi\paypal\TestController@TestExecute');
Route::post('paypal/create', 'skygdi\paypal\CommonController@Create');
*/
