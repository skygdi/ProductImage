<?php

namespace skygdi\ProductImage\model;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

//class product_images extends Model
class ProductImage extends Model implements HasMedia
{
	use SoftDeletes,HasMediaTrait;
    
    protected $table = 'product_image';

    protected $fillable = array('description','sort_index','product_id','featured');

    /*
    function url(){
    	$images = $this->getMedia('images');
    	return $images[0]->getUrl();
    }
    */
    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::deleting(function($obj) { // before delete() method call this
            
            $images = $obj->getMedia('images');
            foreach( $images as $image ){
                $image->delete();
            }
            // do the rest of the cleanup...
        });
    }

    function scopeFeatured($query){
        $query->where('featured', '=', 1);
    }

    function ImageUrl(){
    	$images_array = array();
    	$images = $this->getMedia('images');
    	if( count($images)<=0 ) return "";
    	return $images[0]->getUrl();
    }

    function UploadImage($file){
    	$this->Remove();
    	$this->addMedia($file)->toMediaCollection('images');
    }

    function UploadImageFromUrl($url){
    	$this->Remove();
    	$this->addMediaFromUrl($url)->toMediaCollection('images');
    }

    
}
