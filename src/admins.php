<?php
class Admin{

    static private $conn;

    protected $id;
    protected $email;
    protected $password;


    public static function SetConnection($newConnection){
       Admin::$conn = $newConnection;

    }

    public static function AuthenticateAdmin($email, $password){
        $sqlStatement = "SELECT * FROM admins WHERE email='$email'";
        $result = Admin::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $adminData = $result->fetch_assoc();
            $admin = new Admin( $adminData['id'], $adminData['email'], $adminData['password']);
            if($admin->authenticate($password)){

                //User logged
                return $admin;
            }
       }
        //No user or auth fail
        return null;
    }

    public function setPassword($newPassword){
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_RAND),
        ];
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT, $options);
    }

    public function authenticate($password)
    {
        $hashed_pass = $this->password;
        if (password_verify($password, $hashed_pass)) {
            //User is verified
            return true;
        }
        return false;
    }

    public function getId(){
        return $this->id;
    }
    public function getMail(){
        return $this->email;
    }

    private function __construct($newId, $newEmail, $newPassword)
    {
        $this->id = $newId;
        $this->email = $newEmail;
        $this->password = $newPassword;
    }
}