<?php
class functions {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addtype($type_name)
    {
        $query = "INSERT INTO ams_image_to_text (image_to_text_image_id, image_to_text_text_id) 
                VALUES (:image_id, :text_id)";
        $this->pdo->query($query);
        $this->pdo->bind(':type_name', $type_name);
        $this->pdo->execute();
        return $this->pdo->lastInsertId();
    }

    public function selectImageToTextALL()
    {
        $query = "SELECT * FROM ams_image_to_text";
        $this->pdo->query($query);
        $this->pdo->execute();
        return $this->pdo->getRows();
    }

    public function addImageToText($image_id, $text_id)
    {
        var_dump($image_id);
        $query = "INSERT INTO ams_image_to_text (image_to_text_image_id, image_to_text_text_id) 
                VALUES (:image_id, :text_id)";
        $this->pdo->query($query);
        $this->pdo->bind(':image_id', $image_id);
        $this->pdo->bind(':text_id', $text_id);
        $this->pdo->execute();
        return $this->pdo->lastInsertId();
    }

    public function deleteImageToText($image_to_text_id)
    {
        $query = "DELETE FROM ams_image_to_text WHERE image_to_text_id = :image_to_text_id";
        $this->pdo->query($query);
        $this->pdo->bind(':image_to_text_id', $image_to_text_id);
        $this->pdo->execute();
    }

    public function updateImageToText($text_id, $image_id, $image_to_text_id)
    {
        $query = "UPDATE ams_image_to_text SET 
            image_to_text_image_id = :image_id, 
            image_to_text_text_id = :text_id
            WHERE image_to_text_id = :image_to_text_id";
        $this->pdo->query($query);
        $this->pdo->bind(':image_to_text_id', $image_to_text_id);
        $this->pdo->bind(':image_id', $image_id);
        $this->pdo->bind(':text_id', $text_id);
        $this->pdo->execute();

        return $this->pdo->lastInsertId();
    }
}