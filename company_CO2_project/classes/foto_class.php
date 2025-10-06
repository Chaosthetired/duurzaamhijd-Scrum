 <?php
   class foto {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
   
   public function duplicateimagechecker($image_path, $uploadok) {
        if (file_exists($image_path)) {
            $uploadok = 0;
        }
        return $uploadok;
    }

    public function allowedimage($imageFileType, $uploadok){
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadok = 0;
        }
        return $uploadok;
    }

    public function addimage($uploadok, $image_path, $filesdata) {
        if ($uploadok != 0 && $filesdata["image_input"]['error'] == 0 ) {
            if (move_uploaded_file($filesdata["image_input"]["tmp_name"], $image_path)) {
            echo "The file " . htmlspecialchars(basename($filesdata["image_input"]["name"])) . " has been uploaded.<br>";
        
            $query = "INSERT INTO logo_table (logo_path) 
            VALUES (:logo_path)";
            $this->pdo->query($query);
            $this->pdo->bind(':logo_path', $image_path,);
            $this->pdo->execute();
            return $this->pdo->lastInsertId();
    }
    }
    }

    public function selectlogo($logo_id){
        $query = "SELECT * FROM logo_table WHERE logo_id = :logo_id";
        $this->pdo->query($query);
        $this->pdo->bind(':logo_id', $logo_id,);
        $this->pdo->execute();
        return $this->pdo->getRow();
    }

    public function selectimageALL($artist_id){
        $query = "SELECT * FROM image WHERE image_artist_id = :artist_id";
        $this->pdo->query($query);
        $this->pdo->bind(':artist_id', $artist_id,);
        $this->pdo->execute();
        return $this->pdo->getRows();
    }
}