<?php

class Application_Model_User extends Zend_Db_Table_Abstract {

    protected $_name = 'users';

    public function addUser($userData) {
        $row = $this->createRow();
        $row->fullname = $userData['fullname'];
        $row->email = $userData['email'];
        $row->password = $userData['password'];
        return $row->save();
    }

    public function selectAll() {
        return $this->fetchAll()->toArray();
    }

    public function editUser($id, $userData) {
        $user_data['fullname'] = $userData['fullname'];
        $user_data['email'] = $userData['email'];
        return $this->update($user_data, "id=$id");
    }

    public function selectOne($id) {
        return $this->find($id)->toArray()[0];
    }

    public function deleteUser($id) {
        return $this->delete("id=$id");
    }

    public function blockUser($u_id) {
        return $this->update(['isactive' => 0], "id= $u_id");
    }

    public function activateUser($u_id) {
        return $this->update(['isactive' => 1], "id= $u_id");
    }
    
    public function selectUserByEmail($email) {
        return $this->fetchAll("email= '".$email."'")->toArray()[0];
    }

}
