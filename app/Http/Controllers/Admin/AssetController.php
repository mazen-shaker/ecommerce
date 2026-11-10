<?php

namespace App\Http\Controllers\Admin;

use core\view\Main;
use App\Models\Product;
use App\Models\Category;
use App\Models\Asset;

class AssetController extends Main
{
    public object $model;

    public function __construct()
    {
        $this->model = new Asset();
    }



    public function index($id)
    {
        $images = $this->model->where('product_id', '=', $id);
        $productId = $id;
        return $this->view('admin/index-products-assets',compact('images','productId'));
    }


    public function destroy($data)
    {
    
    if (isset($_SESSION['admin']['logedIn'])) {

    $image = $this->model->find($data['id']);
           
    $this->model->destroy($data['id']);
            
    $this->model->removeFile($image['file_path']);

    }
        
    return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }



    public function store($data)
    {

        if(isset($_SESSION['admin']['logedIn'])){
        $file = $data['file'];

        $files = $this->model->saveFile($file['images'], 'products');
         
         foreach ($files as $file) {
            $this->model->insert([
                'product_id' => $data['product_id'],
                'file_path'  => $file,
            ]);
        }       
    }

        return header("Location:" . $GLOBALS['basePath'] . "/" . $GLOBALS['previousUrl']);
    }

}
