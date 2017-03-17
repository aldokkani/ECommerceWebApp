<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{
    protected  $_name='users';
    
     public function addUser($userData)
    {
      $row=$this->createRow();
      $row->fullname=$userData['fullname'];
      $row->email=$userData['email'];
      $row->password=$userData['password'];
      $row->save();
     
    }
    
    public function listUsers ()
    {
        return $this->fetchAll()->toArray(); 
    }
    
    public function editUser($id,$userData)
    {
       $user_data['fullname']=$userData['fullname'];
       $user_data['email']=$userData['email'];
       $this->update($user_data,"id=$id");
        
    }
    public function userDetails($id)
    {
         return $this->find($id)->toArray()[0];
    }
    public function deleteUser($id)
    {
         return $this->delete("id=$id");
    }
    
}

