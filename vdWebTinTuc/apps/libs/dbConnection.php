<?php
/**
 * Database connection class
 */
    class apps_libs_dbConnection{
        protected $username = 'root';
        protected $password = "";
        protected $host = 'localhost';
        protected $database = 'PHP';
        
        protected $tableName;
        protected $queryParams = [];
        protected static $connectionInstance = null;


        public function __construct() {
            $this->connect();
        }
        
        /**
         * Create a database connection
         * @return new PDOs
         */
        public function connect() {
            if(self::$connectionInstance === null){
                try{
                    self::$connectionInstance = new PDO('mysql:host='.$this->host.';dbname='.$this->database,
                            $this->username, $this->password);
                    self::$connectionInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (Exception $ex) {
                    echo "ERROR: ".$ex->getMessage();
                    die();
                }
            }
        }
        
        /**
         * 
         * @param type $sql
         * @param type $param
         * @return type
         */
        public function query($sql, $param = []) {
            $q = self::$connectionInstance->prepare($sql);
            //avoid error when execute
            if(is_array($param) && $param)
                $q->execute($param);
            else
                $q->execute();
            return $q;
                
        }
        
        public function buildQueryParams($params = []) {
            $default = [
                "SELECT"=>"*",
                "WHERE"=>"",
                "OTHER"=>"",
                "params"=>"",
                "field"=>"",
                "value"=>[],
                "JOIN"=>""
            ];
            //Overwrite $default   
            $this->queryParams = array_merge($default, $params);
            return $this;
        }

        public function buildCondition($condition){ 
            if(trim($condition))
                return "WHERE ".$condition;
            else
                return "";
        }
        
        public function select() {
            $sql = "SELECT ".$this->queryParams['SELECT']
                   ." FROM ".$this->tableName
                   ." ".$this->queryParams['JOIN']
                   ." ".$this->buildCondition($this->queryParams['WHERE'])
                   ." ".$this->queryParams['OTHER'];
            $query = $this->query($sql, $this->queryParams['params']);
    
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        public function selectOne() {
            $this->queryParams['OTHER'] = 'LIMIT 1';
            $data = $this->select();
            if($data)
                return $data[0];
            return [];
        }
        public function insert() {
            $sql = "INSERT INTO ".$this->tableName
                    ." ".$this->queryParams['field'];
            $result = $this->query($sql, $this->queryParams["value"]);
            if($result)
                return self::$connectionInstance->lastInsertId ();
            return false;
        }
        public function update() {
            $sql = "UPDATE ".$this->tableName
                    ." SET ".$this->queryParams['value']
                    ." ".$this->buildCondition($this->queryParams['WHERE']);
            return $this->query($sql, $this->queryParams['params']);
            
        }
        public function delete() {
            $sql = "DELETE FROM ".$this->tableName
                    ." ".$this->buildCondition($this->queryParams['WHERE']);
            return $this->query($sql, $this->queryParams['params']);
        }
    }
?>