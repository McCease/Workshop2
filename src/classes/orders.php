<?php
class Order
{
    static private $conn;

    protected $id;
    public $status;
    protected $user_id;
    public $date;
    public $items;
    public $summary;

    public static function SetConnection($newConnection){
        Order::$conn = $newConnection;
    }

    public function submitOrder(){
        $this->date = date('Y-m-d H:i:s');
        $this->status = 'realisation';
        $sqlStatement = "INSERT INTO orders (status, user_id, date) VALUES ('$this->status', $this->user_id, '$this->date')";
        Order::$conn->query($sqlStatement);
        $this->id=Order::$conn->insert_id;
        //ITEMY DO ITEMS ORDERS
        $temp_items='';
        foreach($this->items as $item_id => $quan){
            $temp_items.="('$this->id', $item_id, $quan),";
        }
        $temp_items=chop($temp_items, ',');
        $sqlStatement = "INSERT INTO orders_items (order_id, item_id, quantity) VALUES $temp_items";
        Order::$conn->query($sqlStatement);
    }

    public function deleteOrder(){
        $sqlStatement= "DELETE FROM orders WHERE id=$this->id";
        if (Order::$conn->query($sqlStatement) === TRUE) {
            return TRUE;
        }
        //error
        return FALSE;
    }

    public function addItem($item_id){
        if(!isset($this->items[$item_id])) {
            $this->items[$item_id] = 1;
        } else {
            $this->items[$item_id] += 1;
        }
    }

    public function changeQuantity($item_id, $newq){
        if(!$newq<1) {
            $this->items[$item_id] = $newq;
        }else{
            $this->removeItem($item_id);
        }
    }

    public function removeItem($item_id){
        unset($this->items[$item_id]);

        //albo tak: unset($this->(items)[$item_id]);

    }

    public static function NewOrder($id){
        return new Order($id);
    }

    public static function GetAllOrders()
    {
        $sqlStatement = "SELECT * FROM orders";

        $result = Order::$conn->query($sqlStatement);
        if($result==false){
            return false;
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sqlStatement = "SELECT * FROM orders_items WHERE order_id={$row["id"]}";
                $result2 = Order::$conn->query($sqlStatement);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $items[] = array($row2["item_id"] => $row2["quantity"]);
                    }
                }
                $ret[] = new Order( $row["user_id"], $row["status"], $row["date"], $row["id"], $items);
            }
        }
        return $ret;
    }

    public static function GetOrdersByUserId($id)
    {
        $sqlStatement = "SELECT * FROM orders WHERE user_id=$id";

        $result = Order::$conn->query($sqlStatement);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sqlStatement = "SELECT * FROM orders_items WHERE order_id={$row["id"]}";
                $result2 = Order::$conn->query($sqlStatement);
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        $items[] = array($row2["item_id"] => $row2["quantity"]);
                    }
                }
                $ret[] = new Order( $row["user_id"], $row["status"], $row["date"], $row["id"], $items);
            }
        }else{
            return false;
        }
        return $ret;
    }

    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getDate(){
        return $this->date;
    }
    public function getItems(){
        return $this->items;
    }

    private function __construct($newUser_Id, $newStatus='cart', $newDate=0, $newId=NULL, $newItems=NULL)
    {
        $this->id = $newId;
        $this->status = $newStatus;
        $this->user_id = $newUser_Id;
        $this->date = $newDate;
        $this->items = $newItems;
    }
}