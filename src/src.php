<?php
    class Inventory {
        private $item;
        private $description;
        private $id;

        function __construct($item, $description, $id = null)
        {
            $this->item = $item;
            $this->description = $description;
            $this->id = $id;
        }

        function setItem($item)
        {
            $this->item = (string) $item;
        }

        function getItem()
        {
            return $this->item;
        }

        function setDescription($description)
        {
            $this->description = (string) $description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO inventory_table (item, description) values ('{$this->getItem()}', '{$this->getDescription()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_items = $GLOBALS['DB']->query("SELECT * FROM inventory_table;");
            $inventory = array();
            foreach ($returned_items as $current) {
                $current_item = $current['item'];
                $description = $current['description'];
                $id = $current['id'];
                $new_inventory = new Inventory($current_item, $description, $id);
                array_push($inventory, $new_inventory);
            }
            return $inventory;
        }

        static function searchAll($term)
        {
            $returned_items = $GLOBALS['DB']->query("SELECT * FROM inventory_table where item LIKE '%{$term}%';");
            $inventory = array();
            foreach ($returned_items as $current) {
                $current_item = $current['item'];
                $description = $current['description'];
                $id = $current['id'];
                $new_inventory = new Inventory($current_item, $description, $id);
                array_push($inventory, $new_inventory);
            }
            return $inventory;
        }


        static function replace($old_name, $new_name)
        {
            $GLOBALS['DB']->query("UPDATE inventory_table SET item = '{$new_name}' WHERE item = '{$old_name}';");
            
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM inventory_table;");
        }
    }


?>
