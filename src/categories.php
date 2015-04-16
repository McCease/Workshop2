<?php
class Category{

    protected $id;
    protected $name;
    protected $parent_id;

    public static function SetConnection($newConnection){
        Category::$conn = $newConnection;
    }

    public static function AddCategory($n, $p){
        $sqlStatement = "INSERT INTO categories(name, parent_id)values ('$n', $p)";
        if (Category::$conn->query($sqlStatement) === TRUE) {
            return new Category(Category::$conn->insert_id, $n, $p);
        }
        //error
        return null;
    }

    public static function GetAllCategories(){

        $sqlStatement = "SELECT FROM categories";

        $result = Category::$conn->query($sqlStatement);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $ret[] = new Category($row["id"], $row["name"], $row["parent_id"]);
            }
        }
        return $ret;
    }

    public function saveToDb(){

        $name=$this->name;
        $parent_id=$this->parent_id;

        $sqlStatement = "UPDATE categoriess SET name=$name, parent_id=$parent_id where  id=$this->id";
        if (Category::$conn->query($sqlStatement) === TRUE) {
            return TRUE;
        }
        //error
        return FALSE;
    }

    public function deleteCategory(){
        $sqlStatement = "DELETE FROM categories WHERE id=$this->id";
        return Item::$conn->query($sqlStatement);
    }

    //Pobieranie danych kategorii
    public function getId(){
        return $this->id;
    }
    public function getName(){
    return $this->name;
}
    public function getParent_id(){
        return $this->parent_id;
    }
    //ustawianie danych kategorii
    public function setName($n){
        $this->name=$n;
    }
    public function setParent_id($p){
        $this->parent_id=$p;
    }

    //konstruktor
    private function __construct($newId, $newName, $newParent_Id)
    {
        $this->id = $newId;
        $this->name = $newName;
        $this->parent_id = $newParent_Id;
    }


    //public function getParent(){}
    //public function getChildren(){}
}
