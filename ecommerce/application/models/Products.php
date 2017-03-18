<?php

class Application_Model_Products extends Zend_Db_Table_Abstract {

    protected $_name = 'products';

    public function addProduct($productData, $vendor_id) {
        $row = $this->createRow();
        $row->name_en = $productData['name_en'];
        $row->name_ar = $productData['name_ar'];
        $row->description_en = $productData['description_en'];
        $row->description_ar = $productData['description_ar'];
        $row->unit_price = $productData['unit_price'];
        $row->photo = $productData['photo'];
        $row->category_id = $productData['category_id'];
        $row->vendor_id = $vendor_id;
        $row->save();
    }

    public function SelectAll() {
        return $this->fetchAll()->toArray();
        // var_dump( $this->fetchAll()->toArray());exit();
        // $select = $this->select()
        //             ->from('products')
        //             ->joinLeft(array('offer'=>'offer'),'product.id = offer.product_id');
        //             // ->where('products.id = ?', 1);
        //
        // return $select;
    }

    public function editProduct($id, $productData) {
        $product_data['name_en'] = $productData['name_en'];
        $product_data['name_ar'] = $productData['name_ar'];
        $product_data['description_en'] = $productData['description_en'];
        $product_data['description_ar'] = $productData['description_ar'];
        $product_data['unit_price'] = $productData['unit_price'];
        $product_data['photo'] = $productData['photo'];
        $this->update($product_data, "id=$id");
    }

    public function selectOne($id) {
        return $this->find($id)->toArray()[0];
    }

    public function deleteProduct($id) {
        return $this->delete("id=$id");
    }

    public function getCategoryProducts($id) {
        return $this->select("category_id=$id");
    }

    public function getNewProducts() {
        return $this->fetchAll($where = null, $order = 'id DESC', $count = 5);
    }

    function selectAllByVendor($vendor_id) {
        return $this->fetchall("vendor_id=$vendor_id")->toarray();
    }

}
