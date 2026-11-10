<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Product;
use App\Models\Category;
use App\Models\Asset;

class ProductController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Product();
    }


    public function index()
    {
       $products = $this->model->all();
       $categories = (new Category)->all();
       
        return $this->view('admin/index-products',compact('products','categories'));
    }

    public function store($data)
    {

        if(isset($_SESSION['admin']['logedIn'])){
        $product = $this->model->insert([
         'name'        => $data['name'],
         'category_id' => $data['category_id'],
         'description' => $data['description'],
         'price'       => $data['price'],
         'old_price'   => $data['old_price'],
         'stock'       => $data['stock'],
         'is_active'   => $data['is_active'],
        ]);     

        $file = $data['file'];

        $files = $this->model->saveFile($file['images'], 'products');
         
         foreach ($files as $file) {
            (new Asset)->insert([
                'product_id' => $product,
                'file_path'  => $file,
            ]);
        }       
    }

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }




    public function update($data)
    {

        if(isset($_SESSION['admin']['logedIn'])){
        $product = $this->model->update($data['id'],[
         'name'        => $data['name'],
         'category_id' => $data['category_id'],
         'description' => $data['description'],
         'price'       => $data['price'],
         'old_price'   => $data['old_price'],
         'stock'       => $data['stock'],
         'is_active'   => $data['is_active'],
        ]);     
    }

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }




public function destroy($data)
{
    if (isset($_SESSION['admin']['logedIn'])) {

        $images = (new Asset)->where('product_id', '=', $data['id']);

        foreach ($images as $image) {
            $this->model->removeFile($image['file_path']);
        }

        $this->model->destroy($data['id']);
    }

    return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
}

    public function productDetails($id){

        $product = $this->model->where('id', '=' , $id);
        $images = (new Asset)->where('product_id','=', $id);
        $product['image'] = $images; 
        $product['thub'] = $images[0]; 
//        var_dump($product); die();
        return $this->view('user/product-details', compact('product'));

    }



}
