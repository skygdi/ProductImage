### Quick Product Image class (product id , name and description) base on Spatie\MediaLibrary for Laravel
1.Install:
```php
composer require skygdi/product-image
```
2.Public migration files:
```php
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider"
php artisan vendor:publish --provider="skygdi\ProductImage\ProductImageProvider"
```
3.Migrate
```php
php artisan migrate
```
Change the #order_id input and #order_total value as your logic needed before clicking the paypal checkout button.
4.Usage:
```php
use skygdi\ProductImage\model\ProductImage as ProductImage;
```

5. Testing: The fast test URL:  yourUrl/skygdi/pi/test, or you could write on your own.
```php
Route::get('/', function () {
    //Creating
    ProductImage::create([
        "product_id"    =>  1,
        "description"   =>  "description",
        "sort_index"    =>  1
    ]);
    */

    $pi = ProductImage::find(1);
    //$pi->UploadImage( storage_path('app/file.jpg') ); //From local file
    //$pi->UploadImage( $request->file('new_image') );  //From upload form
    //$pi->UploadImageFromUrl("https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png");    //From Internet
    echo "<img src='".url('/').$pi->ImageUrl()."'/>";
});
```
___