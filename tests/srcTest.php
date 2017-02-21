<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/src.php';

    $server = 'mysql:host=localhost:8889;dbname=test_inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class SourceTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_getItem() {
            $item = 'teddy bear';
            $description = 'a brown bear';
            $test_inventory = new Inventory($item, $description);

            $result = $test_inventory->getItem();

            $this->assertEquals($item, $result);
        }

        function test_save() {
            $item = 'teddy bear';
            $description = 'a brown bear';
            $test_inventory = new Inventory($item, $description);
            $test_inventory->save();

            $result = Inventory::getAll();

            $this->assertEquals($result[0], $test_inventory);
        }

        function test_getAll() {
            $item1 = 'teddy bear';
            $description1= 'a brown bear';
            $item2 = 'shoddy bear';
            $description2 = 'a racoon';
            $test_inventory1 = new Inventory($item1, $description1);
            $test_inventory1->save();
            $test_inventory2 = new Inventory($item2, $description2);
            $test_inventory2->save();

            $result = Inventory::getAll();

            $this->assertEquals([$test_inventory1, $test_inventory2], $result);
        }

        function test_deleteAll(){
            $item1 = 'teddy bear';
            $description1= 'a brown bear';
            $item2 = 'shoddy bear';
            $description2 = 'a racoon';
            $test_inventory1 = new Inventory($item1, $description1);
            $test_inventory1->save();
            $test_inventory2 = new Inventory($item2, $description2);
            $test_inventory2->save();

            Inventory::deleteAll();
            $result = Inventory::getAll();

            $this->assertEquals([], $result);
        }

        function test_search() {
            $item1 = 'teddy bear';
            $description1= 'a brown bear';
            $item2 = 'shoddy bear';
            $description2 = 'a racoon';
            $test_inventory1 = new Inventory($item1, $description1);
            $test_inventory1->save();
            $test_inventory2 = new Inventory($item2, $description2);
            $test_inventory2->save();
            $term = 'teddy';

            $result = Inventory::searchAll($term);

            $this->assertEquals([$test_inventory1], $result);
        }

        function test_replace() {
            $item1 = 'teddy bear';
            $description1= 'a brown bear';
            $test_inventory1 = new Inventory($item1, $description1);
            $test_inventory1->save();
            $old_name = 'teddy bear';
            $new_name = 'blayze';

            Inventory::replace($old_name, $new_name);
            $result = Inventory::getAll();
            $this->assertEquals($new_name, $result[0]->getItem());
        }
    }



?>
