<?php
class Item{

    static private $conn;

    protected $id;
    protected $name;
    protected $price;
    protected $description;
    protected $quantity;
    protected $category_id;
    protected $is_visible;

    public static function SetConnection($newConnection){
        Item::$conn = $newConnection;
    }

    public static function addItem($n, $p, $d, $q, $c_id, $is){
        $sqlStatement = "INSERT INTO items(name, price, description, quantity, category_id, is_visible) values ('$n', $p, '$d', $q, $c_id, $is)";
        if (Item::$conn->query($sqlStatement) === TRUE) {
            return new Item(Item::$conn->insert_id, $n, $p, $d, $q, $c_id, $is);
        }
        //error
        return null;
    }

    public static function GetItem($id){
        $sqlStatement = "SELECT * FROM items WHERE id=$id";
        $result=Item::$conn->query($sqlStatement);
        if ($result!= FALSE) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    return new Item($id, $row["name"], $row["price"], $row["description"], $row["quantity"], $row["category_id"], $row["is_visible"]);
                }
            }
        }
        return false;
    }

    public function saveToDb(){

        $name=$this->name;
        $price=$this->price;
        $description=$this->description;
        $quantity=$this->quantity;
        $category_id=$this->category_id;
        $is_visible=$this->is_visible;

        $sqlStatement = "UPDATE items SET name=$name, price=$price, description=$description, quantity=$quantity, category_id=$category_id, is_visible=$is_visible where  id=$this->id";
        if (Item::$conn->query($sqlStatement) === TRUE) {
            return TRUE;
        }
        //error
        return FALSE;
    }

    public static function GetItemsNames($arr){
        $sqlStatement = "SELECT name, price FROM items WHERE id IN $arr";
        $result = Item::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = array($row["name"],$row["price"]);
            }
        }
        return $ret;
    }

    public static function GetItemsFrom($cat){
        if($cat==='all'){
            $sqlStatement = "SELECT * FROM items";
        } else {
            $sqlStatement = "SELECT * FROM items WHERE category_id=$cat";
        }
        $result = Item::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Item($row["id"], $row["name"], $row["price"], $row["description"], $row["quantity"], $row["category_id"], $row["is_visible"]);
            }
        }
        return $ret;
    }

    public static function GetItemsByOrderId($id){
        $sqlStatement = "SELECT FROM items JOIN orders_items ON item_id=items.id WHERE order_id=$id";

        $result = Item::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Item($row["id"], $row["name"], $row["price"], $row["description"], $row["quantity"], $row["category_id"], $row["is_visible"]);
            }
        }
        return $ret;
    }

    public static function GetPromotedItems(){
        $sqlStatement = "SELECT * FROM items WHERE is_promoted=TRUE AND is_visible=TRUE";
        $result=Item::$conn->query($sqlStatement);
        if ($result==false){
            return false;
        }
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Item($row["id"], $row["name"], $row["price"], $row["description"], $row["quantity"], $row["category_id"], $row["is_visible"]);
            }
        }
        return $ret;
    }

    public static function GetPicturesCarousel($cat=0){
        if ($cat==0){
            $sqlStatement = "SELECT pictures.path_to_file, pictures.item_id FROM pictures INNER JOIN (SELECT MID(id) as minid, item_id FROM pictures GROUP BY item_id) minid on minid.minid pictures.id";
        } else {
            $sqlStatement = "SELECT pictures.path_to_file, pictures.item_id FROM pictures JOIN items ON pictures.item_id=items.id WHERE items.category_id=$cat AND items.is_promoted=1 INNER JOIN (SELECT MID(id) as minid, item_id FROM pictures GROUP BY item_id) minid on minid.minid pictures.id";
        }
        $result = Item::$conn->query($sqlStatement);
        if($result==false) {
            return false;
        }
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = array($row["item_id"] => $row["path_to_file"]);
            }
        }
        return $ret;
    }

    public function getPictures(){
        $sqlStatement = "SELECT * FROM pictures WHERE item_id=$this->id";
        $result = Item::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = $row;
            }
            return $ret;
        }
        return false;
    }

    public function deletePicture($id){
        $sqlStatement = "DELETE FROM pictures WHERE item_id=$this->id AND id=$id";

        return Item::$conn->query($sqlStatement);
    }
    /*
if($_FILES['fileToUpload']['type'] == 'image/gif' ||
$_FILES['fileToUpload']['type'] == 'image/png' ||
$_FILES['fileToUpload']['type'] == 'image/jpg' ||
$_FILES['fileToUpload']['type'] == 'image/jpeg'){
$tmpname=$_FILES['fileToUpload']['tmp_name']
*/
    public function addPicture($filename, $tmpname){

        $uploaddir='../images/';
        $hashed=md5($filename);

        $uploaddir.=date('Ymd'). '/' . substr($hashed, 0 , 2) . '/' . substr($hashed, -2) . '/' ;
        $this->createPath($uploaddir);

        $uploaddir = $uploaddir . '/' . $this->id . substr($filename,-4);

        if(move_uploaded_file($tmpname, $uploaddir)) {

            $sqlStatement = "INSERT INTO pictures (path_to_file, item_id) values ('$uploaddir', $this->id)";
            if (Item::$conn->query($sqlStatement) === TRUE) {
                return TRUE;
            } else{
                return FALSE;
            }
        }
    }
    /*
               echo "<script>alert='File failed to upload.'</script>";
           }else{
               echo "<script>alert='File uploaded succesfully.'</script>";
           }
           */

    //Funkcja do sprawdzania isteniania i ewentulanego tworzzenia katalogu
    private function createPath($path) {
        if (is_dir($path)) return true;
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
        $return = $this->createPath($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path) : false;
    }



    public function hideItem(){
        $sql = "UPDATE Items SET is_visible=FALSE WHERE id={$this->id}";
        return Item::$conn->query($sql);
    }

    public function showItem(){
        $sql = "UPDATE Items SET is_visible=TRUE WHERE id={$this->id}";
        return Item::$conn->query($sql);
    }

    //Zwracanie wartości obiektu
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getPrice(){
        return $this->price;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getQuantity(){
        return $this->quantity;
    }
    public function getCategory_id(){
        return $this->category_id;
    }
    public function getIsVisible(){
        return $this->is_visible;
    }

    //Ustawianie wartości obiektu

    public function setName($n){
        $this->name=$n;
    }
    public function setPrice($p){
        $this->price=$p;
    }
    public function setDescription($d){
        $this->description=$d;
    }
    public function setQuantity($q){
        $this->quantity=$q;
    }
    public function setCategory_id($c){
        $this->category_id=$c;
    }
    public function setIsVisible($is){
        $this->is_visible=$is;
    }



    //constructor
    private function __construct($newId, $newName, $newPrice, $newDescription, $newQuantity, $newCategory_id, $newIs_visible){
        $this->id = $newId;
        $this->name = $newName;
        $this->price = $newPrice;
        $this->description = $newDescription;
        $this->quantity = $newQuantity;
        $this->category_id=$newCategory_id;
        $this->is_visible=$newIs_visible;

    }
}