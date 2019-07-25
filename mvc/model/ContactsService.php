<?php

require_once 'model/ContactsGateway.php';
require_once 'model/ValidationException.php';


class ContactsService {
    
    private $contactsGateway    = NULL;
    public function __construct() {
        $this->contactsGateway = new ContactsGateway();
    }
    private function openDb() {
        $conn = mysqli_connect('localhost', 'root', '');
        $db = mysqli_select_db($conn,"mvc_crud");
        if (!$conn) {
            throw new Exception("Connection to the database server failed!");
        }
        if (!$db) {
            throw new Exception("No mvc-crud database found on database server.");
        }
    }
    
    private function closeDb() {
        $conn = mysqli_connect('localhost', 'root', '');
        mysqli_close($conn);
    }
    
    public function getAllContacts($order) {
        try {
            $this->openDb();
            $res = $this->contactsGateway->selectAll($order);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    public function getContact($id) {
        try {
            $this->openDb();
            $res = $this->contactsGateway->selectById($id);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
        return $this->contactsGateway->find($id);
    }
    
    private function validateContactParams( $name, $phone, $email, $address ) {
        $errors = array();
        if ( !isset($name) || empty($name) ) {
            $errors[] = 'Name is required';
        }
        if ( empty($errors) ) {
            return;
        }
        throw new ValidationException($errors);
    }
    
    public function createNewContact( $name, $phone, $email, $address ) {
        try {
            $this->openDb();
            $this->validateContactParams($name, $phone, $email, $address);
            $res = $this->contactsGateway->insert($name, $phone, $email, $address);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    public function deleteContact( $id ) {
        try {
            $this->openDb();
            $res = $this->contactsGateway->delete($id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    
    
}

?>
