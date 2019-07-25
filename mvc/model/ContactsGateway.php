<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */

class ContactsGateway {
    public function selectAll($order) {
        if ( !isset($order) ) {
            $order = "name";
        }
        $conn = mysqli_connect('localhost', 'root', '',"mvc_crud");
        $dbOrder =  mysqli_real_escape_string($conn,$order);
        $dbres = mysqli_query($conn,"SELECT * FROM contacts ORDER BY $dbOrder ASC");
        
        $contacts = array();
        while ( ($obj = mysqli_fetch_object($dbres)) != NULL ) {
            $contacts[] = $obj;
        }
        
        return $contacts;
    }
    
    public function selectById($id) {
        $dbId = $id;
        $conn = mysqli_connect('localhost', 'root', '',"mvc_crud");
        $dbres = mysqli_query($conn,"SELECT * FROM contacts WHERE id=$dbId");
        
        return mysqli_fetch_object($dbres);
		
    }
    
    public function insert( $name, $phone, $email, $address ) {
        $conn = mysqli_connect('localhost', 'root', '',"mvc_crud"); 
        $dbName = ($name != NULL)?"'".$name."'":'NULL';
        $dbPhone = ($phone != NULL)?"'".$phone."'":'NULL';
        $dbEmail = ($email != NULL)?"'".$email."'":'NULL';
        $dbAddress = ($address != NULL)?"'".$address."'":'NULL';
        
        mysqli_query($conn,"INSERT INTO contacts (name, phone, email, address) VALUES ($dbName, $dbPhone, $dbEmail, $dbAddress)");
        return mysqli_insert_id();
    }
    
    public function delete($id) {
        $conn = mysqli_connect('localhost', 'root', '',"mvc_crud");
        $dbId = $id;

        mysqli_query($conn,"DELETE FROM contacts WHERE id=$dbId");
    }
    
}

?>
