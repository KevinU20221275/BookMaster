<?php
require_once(__DIR__ . '/../../conf/conf.php');
    
class Login extends Conf {
    public $username;
    public $password;
     
    public function get_user(){
        $query = "SELECT A.id, firstName, lastName, username, email, roleName, phone, isEmployerEnabled, roleId FROM employee AS A 
        INNER JOIN role AS B 
        ON A.roleId = B.id WHERE username=:username && password=:password";
        $params = [':username' => $this->username,
        ':password' => md5($this->password)
        ];
         
        $result = $this->exec_query($query, $params);
         
        if ($result){
            return $result->fetch(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}
