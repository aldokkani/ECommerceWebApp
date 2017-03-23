<?php

class Application_Model_Offer extends Zend_Db_Table_Abstract
{
    protected $_name = 'offer';

    public function selectAll() {
        return $this->fetchAll()->toArray();
    }

    public function selectOne($offer_id) {
        return $this->find($offer_id)->toArray()[0];
    }

    public function selectByProduct($p_id){
        @$result= $this ->fetchall("product_id=$p_id")->toarray()[0];
        if(count($result)>0){
          return $result;
        }
    }

    public function addOffer($data,$product_id) {
        $offer = array (
            'discount' => (int)$data['discount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'product_id' => $product_id
        );
        $row = $this->createRow($offer);
        return $row->save();
    }

    public function editOffer($offer_id, $data) {
        $offer = array (
            'discount' => (int)$data['discount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date']
        );
        return $this->update($offer, "id= $offer_id");
    }

    public function deleteOffer($p_id) {
        return $this->delete("product_id= $p_id");
    }


    function getProductOffer($product_id)
    {
        $discount = 0;

        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '123456',
            'dbname'   => 'dbzend'
        ));

        $date = Zend_Date::now();
        $timeStamp = gmdate("Y-m-d", $date->getTimestamp());

        $stmt = $db->query("SELECT * FROM offer where product_id = $product_id and end_date > '" . $timeStamp . "' and start_date < '".$timeStamp . "' "   );

        $rows = $stmt->fetchAll();
        if($rows)
        {
            $rows = $rows[0];
            $discount = $rows['discount'];
        }

        return $discount ;
    }

}
