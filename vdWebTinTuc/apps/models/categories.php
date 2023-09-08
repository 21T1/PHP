<?php
    class apps_models_categories extends apps_libs_dbConnection{
        protected $tableName = 'categories';
    
        public function buildSelectBox(){
            $query = $this->buildQueryParams(["SELECT"=>"id, name"])->select();
            $result = [""=>"--select category--"];
            foreach($query as $row)
                $result[$row["id"]] = $row["name"];
            return $result;
        }
    }
?>    
