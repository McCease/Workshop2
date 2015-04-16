<?php
class User{

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
            'salt' => mcrypt_create_iv(22, MCRYPT_RANDOM),
        ];
        $hash_pass= password_hash($pass, PASSWORD_BCRYPT, $options);
        $sqlStatement = "INSERT INTO users(email, name, surname, address, phone, password) values ('$e','$n','$s','$a',$p,'$hash_pass')";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows == 1) {
            $userData = $result->fetch_assoc();
            return new User($userData['id'], $userData['name'], $userData['email'], $userData['name'], $userData['surname'], $userData['address'], $userData['phone'], $userData['password']);
        }
    }

    public static function GetAllUsers(){
        $sqlStatement = "SELECT FROM users";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($userData= $result->fetch_assoc()){
                $ret[] = new User($userData['id'], $userData['name'], $userData['email'], $userData['name'], $userData['surname'], $userData['address'], $userData['phone'], $userData['password']);
            }
        }
        return $ret;
    }
    public static function AuthenticateUser($email, $password){
        $sqlStatement = "SELECT FROM users WHERE email=$email";
        $result = User::$conn->query($sqlStatement);
        if ($result->num_rows != 1) {
            $userData = $result->fetch_assoc();
            $user = new User($userData['id'], $userData['name'], $userData['email'], $userData['name'], $userData['surname'], $userData['address'], $userData['phone'], $userData['password']);

            if($user->authenticate($password)){
                //User logged
                return $user;
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
}