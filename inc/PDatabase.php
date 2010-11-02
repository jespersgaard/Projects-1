<?php
class PDatabase extends PDO{

    public function __construct() {
        $ini = $_SERVER['DOCUMENT_ROOT']."/projects/config.ini";
        $parse = parse_ini_file($ini , true) ;
        
        $driver = $parse["db_driver"];
        $dsn = "${driver}:";
        $user = $parse ["db_user"];
        $password = $parse ["db_password"];
        $options = $parse ["db_options"];
        $attributes = $parse ["db_attributes"];

        foreach($parse["dsn"] as $k => $v){
            $dsn .= "${k}=${v};" ;
        }
		
        parent::__construct($dsn, $user, $password, $options);
    }
}
?>