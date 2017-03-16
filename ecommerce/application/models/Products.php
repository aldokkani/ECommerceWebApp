<?php

class Application_Model_Products extends Zend_Db_Table_Abstract
{
     protected  $_name='products';

      public function addProduct($productData)
    {
      $row=$this->createRow();
      $row->name_en=$productData['name_en'];
      $row->name_ar=$productData['name_ar'];
      $row->description_en=$productData['description_en'];
      $row->description_ar=$productData['description_ar'];
      $row->unit_price=$productData['unit_price'];
      $row->photo=$productData['photo'];
      $row->category_id=$productData['category_id'];
      $row->save();
     
    }
    
    public function listProducts ()
    {
        return $this->fetchAll()->toArray(); 
    }
    
    public function editProduct($id,$productData)
    {
       $product_data['name_en']=$productData['name_en'];
       $product_data['name_ar']=$productData['name_ar'];
       $product_data['description_en']=$productData['description_en'];
       $product_data['description_ar']=$productData['description_ar'];
       $product_data['unit_price']=$productData['unit_price'];
       $product_data['photo']=$productData['photo'];
       $this->update($product_data,"id=$id");
        
    }
    public function productDetails($id)
    {
         return $this->find($id)->toArray()[0];
    }
    public function deleteProduct($id)
    {
         return $this->delete("id=$id");
    }

     
     
     
     
     
     
     
     
}

