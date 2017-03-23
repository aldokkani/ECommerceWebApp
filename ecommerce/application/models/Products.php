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
    }

        public function SelectAllProductsWithOffer() {

        $db=Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
             ->from(array('p'=>'products'),
                array('p.id','p.name_en','p.rate','p.description_en','p.photo','p.unit_price','p.name_ar','p.description_ar'))
             ->joinLeft(array('o'=>'offer'),'p.id = o.product_id', array('discount'));
        $rs=$select->query()->fetchAll();
        return $rs;
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
        return $this->fetchAll("vendor_id=$vendor_id")->toarray();
    }

    public function searchByName($p_name) {
        /* Searches for a product by its name */
        $product = $this->fetchAll("name_en = '".$p_name."'")->toArray()[0];
        return $product;//json_encode($product);
    }

    public function editRate($product_id,$avgRate) {
      // var_dump($rate);exit;
        $product_data['rate'] = $avgRate;
        $this->update($product_data, "id=$product_id");
    }

}
