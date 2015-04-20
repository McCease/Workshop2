<?php
class User{

    static private $conn;

    protected $id;
    protected $email;
    protected $name;
    protected $surname;
    protected $address;
    protected $phone;
    protected $password;
    protected $orders;


    public static function SetConnection($newConnection){
        User::$conn = $newConnection;

    }

    public static function RegisterUser($e,$n,$s,$a,$p,$pass){
        //TU mozna dołożyc sanityzację
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_RAND),
        ];
        $hash_pass= password_hash($pass, PASSWORD_BCRYPT, $options);
        $sqlStatement = "INSERT INTO users(email, name, surname, address, phone, password) values ('$e','$n','$s','$a',$p,'$hash_pass')";
        $result = User::$conn->query($sqlStatement);
        if ($result==true) {
            $id=User::$conn->insert_id;
            return new User($id, $e, $n, $s, $a, $p, $hash_pass);
        }
    }

    public static function GetAllUsers(){
        $sqlStatement = "SELECT * FROM users";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($userData= $result->fetch_assoc()){
                $ret[] = new User($userData['id'], $userData['email'], $userData['name'], $userData['surname'], $userData['address'], $userData['phone'], $userData['password']);
            }
        }
        return $ret;
    }
    public static function AuthenticateUser($email, $password){
        $sqlStatement = "SELECT * FROM users WHERE email='$email'";
        $result = User::$conn->query($sqlStatement);
        if($result==true) {
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                $user = new User($userData['id'], $userData['email'], $userData['name'], $userData['surname'], $userData['address'], $userData['phone'], $userData['password']);

                if ($user->authenticate($password)) {
                    //User logged
                    return $user;
                }
            }
        }
        //No user or auth fail
        return null;
    }

    public function deleteUser($password){
        if($this->authenticate($password)){
            $sqlStatement= "DELETE FROM users WHERE id=$this->id";
            if (User::$conn->query($sqlStatement) === TRUE) {
                return TRUE;
            }
            //error
            return FALSE;
        }
    }

    public function Orders(){
        return Order::NewOrder($this->id);
    }

    public function getAllOrders(){

        $this->orders=Order::GetOrdersByUserId($this->id);

    }

    public function setPassword($newPassword){
        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_RANDOM),
        ];
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT, $options);
    }

    public function authenticate($password){
        $hashed_pass = $this->password;
        if(password_verify($password, $hashed_pass)){
            //User is verified
            return true;
        }
        return false;
    }

    //public function sendMail(){}
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getSurname(){
        return $this->surname;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getAddress(){
        return $this->address;
    }
    public function getPhone(){
        return $this->phone;
    }


    private function __construct($newId, $newEmail, $newName, $newSurname, $newAddress, $newPhone, $newPassword)
    {
        $this->id = $newId;
        $this->email = $newEmail;
        $this->name = $newName;
        $this->surname = $newSurname;
        $this->address = $newAddress;
        $this->phone = $newPhone;
        $this->password = $newPassword;
    }

}