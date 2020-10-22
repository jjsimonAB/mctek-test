<?php

try {

    $redis = new Redis(); 
    $redis->connect('rediscont', 6379); 
    $allKeys = $redis->keys("*");
    if(empty($allKeys)){
        echo "no data found, proceeding to insert data into redis... \n";
        $redis->hmset("1", [
            'name' => 'movie 1', 
            'childs' => '2,5,6,4']);
        $redis->hmset("2", [
            'name' => 'movie 2'
            ]);
        $redis->hmset("3", [
            'name' => 'movie 3', 
            'childs' => '7']);
        $redis->hmset("4", [
            'name' => 'movie 4', 
            'childs' => '8,15,14']);
        $redis->hmset("5", [
            'name' => 'series 1', 
            'childs' => '9']);
        $redis->hmset("6", [
            'name' => 'series 2', 
            'childs' => '10,3']);
        $redis->hmset("7", [
            'name' => 'series 3', 
            'childs' => '13']);
        $redis->hmset("8", [
            'name' => 'series 4', 
            'childs' => '']);
        $redis->hmset("9", [
            'name' => 'movie A', 
            'childs' => '']);
        $redis->hmset("10", [
            'name' => 'movie B', 
            'childs' => '11,12']);
        $redis->hmset("11", [
            'name' => 'series A', 
            'childs' => '']);
        $redis->hmset("12", [
            'name' => 'series B', 
            'childs' => '']);
        $redis->hmset("13", [
            'name' => 'mini series 1', 
            'childs' => '']);
        $redis->hmset("14", [
            'name' => 'mini series 2', 
            'childs' => '']);
        $redis->hmset("15", [
            'name' => 'series 5', 
            'childs' => '16']);
        $redis->hmset("16", [
            'name' => 'movie 5', 
            'childs' => '']);

    } 

    sort($allKeys);
    //options
    switch($argv[1]){
        case 'list':
            $keys = $allKeys[0];
            lists($keys, $redis);
        break;
        case 'add':
            echo "add flow \n";
            $item = [$argv[2], (isset($argv[3]) ? $argv[3] : '')];
            addItem($item, $redis, $allKeys);
        break;
        case 'delete':
            echo "delete flow \n";
            deleteItem($argv[2], $redis);
        break;
        default:
            echo "invalid argument";
    }

}catch (Exception $e) {
    echo $e;
}

function lists($keys, $redis) {
    try {
        $data = $redis->hgetall($keys);
        $dataChilds = explode(",", $data['childs']);
        print_r($data['name']."\n");
        if(!empty($dataChilds)){
            generateList($dataChilds, $redis, null);
        }
    }catch (Exception $e){
        echo $e;
    }

}

function generateList($dataChilds, $redis, $counter = 0 ) {

    $iterationCounter = $counter;
    $tabs = "\t";

    //Quick tabbing solution 
    //TO-DO: refactor it
    if(isset($counter)) {
        switch($iterationCounter) {
            case 1:
                $tabs = "\t \t";
            break;
            case 2: 
                $tabs = "\t \t";
            break;
            case 3: 
                $tabs = "\t \t \t";
            break;
            case 4: 
                $tabs = "\t \t \t";
            break;
            case 5: 
                $tabs = "\t \t \t \t";
            break;
            default:   
                null;
        }
    }

    //iterating and displaying childs of each parent
    foreach($dataChilds as $child) {
        $childName = $redis->hgetall($child);
        $childSubNodes = explode(",", $childName['childs']);
        echo $tabs.$childName['name']."\n" ;
        if(!empty($childSubNodes[0])){
            $iterationCounter = $iterationCounter + 1;
            generateList($childSubNodes, $redis, $iterationCounter);
        }
    };
}

function addItem($item, $redis, $keys) {
    $id = sizeof($keys) + 1;
    try {
        $rootChilds = $redis->hgetall(1);
        $newChilds = $rootChilds['childs'] . ",$id";
        $redis->hset(1,'childs',$rootChilds['childs'] . ",$id");
        $redis->hmset($id, [
            'name' => $item[0], 
            'childs' => (!empty($item[1]) ? $item[1] : '')]);
    }catch (Exception $e){
        echo $e;
    }

}

function deleteItem($id, $redis) {
    try {
        $redis->del($id);
    }catch(Exception $e){
        echo $e;
    }
}

?>