<?php

class DATABASE {
    static private $result;
    static private $connection;

    public function __construct() {
        self::connect();
    }

    static function connect() {
        self::$connection = new PDO(
            'mysql:dbname='.getenv('DB_TARGET').';host='.getenv('DB_ADRESS'),
            getenv('DB_USER'),
            getenv('DB_PASSWORD')
        )
        or die('Не удалось соединиться: ' . mysqli_connect_error());
    }


    static function genType($data) {
        $result = '';
        $map = [
            "string" => 's',
            "integer" => 'i',
            "double" => 'd',
        ];
        foreach($data as $value) {
            $result.=$map[$value];
        }
        return $result;
    }

    static function query($string, $data = null) {
        if(self::$connection) {
            $query = self::$connection->prepare($string);
            $query->execute($data);
            self::$result = $query->fetchAll();
        } else {
            self::connect();
            self::query($string, $data);
        }
    }
    static function getResult() {
        return self::$result;
    }
}
