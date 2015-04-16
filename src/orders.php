<?php
class Order
{
    protected $id;
    public $status;
    protected $user_id;
    public $date;
    public $items;

    public static function SetConnection($newConnection){
        Order::$conn = $newConnection;
    }

    public function submitOrder(){
        $this->date = date('YY-mm-dd');
        $this->status = 'realisation';
        $sqlStatement = "INSERT INTO orders (status, user_id, date) VALUES ($this->status, $this->user_id, $this->date)";
        Order::$conn->query($sqlStatement);
        $this->id=Order::$conn->insert_id;
        //ITEMY DO ITEMS ORDERS

        $temp_items='';
        foreach($this->items as $row){
            $temp_items.="($this->id, {$row['item_id']}, {$row['quantity']}),";
        }
        $temp_items=chop($temp_items, ',');
        $sqlStatement = "INSERT INTO orders_items (order_id, item_id, quantity) VALUES ('$temp_items')";
        Order::$conn->query($sqlStatement);
    }

    public function deleteOrder(){
        $sqlStatement= "DELETE FROM orders WHERE id=$this->id";
        if (User::$conn->query($sqlStatement) === TRUE) {
            return TRUE;
        }
        //error
        return FALSE;
    }

    public function addItem($item_id, $q){
        $this->items[]=array("item_id"=>$item_id, "quantity"=>$q);
    }
    //public function CHANGE QUANTITY
    //public function DELETE ITEM
    public static function NewOrder($id){
        return new Order($id);
    }

    public static function GetOrdersByUserId($id)
    {
        $sqlStatement = "SELECT FROM orders WHERE user_id=$id";

        $result = Order::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ret[] = new Order($row["id"], $row["status"], $row["user_id"], $row["date"]);
            }
        }
        return $ret;
    }

    private function __construct($newUser_Id)
    {
        $this->id = NULL;
        $this->status = 'cart';
        $this->user_id = $newUser_Id;
        $this->date = 0;
        $this->items = NULL;
    }
}