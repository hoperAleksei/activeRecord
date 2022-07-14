<?php
// Active record class for the 'data' table.
class Data
{
    public $id;
    public $message;
    private $dbh;

    public function __construct($dbh, $message = null, $id = null)
    {
        $this->dbh = $dbh;
        $this->message = $message;
        $this->id = $id;
    }

    public function save()
    {
        if ($this->id) {
            $sql = "INSERT INTO data (id, message) VALUES (:id, :message)";
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $this->id);
        } else {
            $sql = "INSERT INTO data (message) VALUES (:message)";
            $sth = $this->dbh->prepare($sql);
        }
        $sth->bindParam(':message', $this->message);
        $sth->execute();
        return true;
    }

    public function delete() {
        if ($this->id AND $this->message) {
            $sql = "DELETE FROM data WHERE id = ? AND message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->id, $this->message]);
        } else if ($this->message) {
            $sql = "DELETE FROM data WHERE message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->message]);
        } else if ($this->id) {
            $sql = "DELETE FROM data WHERE id = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->id]);
        }
    }

    public function find() {
        if ($this->id AND $this->message) {
            $sql = "SELECT * FROM data WHERE id = ? AND message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->id, $this->message]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if ($this->id) {
            $sql = "SELECT * FROM data WHERE id = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->id]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else if ($this->message) {
            $sql = "SELECT * FROM data WHERE message = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute([$this->message]);
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT * FROM data";
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }

}