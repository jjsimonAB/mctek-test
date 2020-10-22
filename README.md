# mctek-test
Quick test for mctek recruitment process

To test the scrip first you neet to build the containers using:

> $ docker-compose build

To run the php script use:

> $ docker-compose run --rm php php ./index.php <command>

There are 3 commands you can use list, add and delete

## List

>**note**: the first time run the script twice, the first time the script is gonna fetch the data to the redis container.

To list the previuously created list use:

> $ docker-compose run --rm php php ./index.php list

this should return an ordenated movie list

## Add

>**note**: the add functionality takes 2 arguments the first is the name of the new item and the second one is opcional and its the childs of that new item.

To add a new item use:

> $ docker-compose run --rm php php ./index.php add <item-name> <item-childs>(optional)

## Delete

To delete a certain item just send the item key using:

> $docker-compose run --rm php php ./index.php delete <key>

## Redis structure

This is how the redis is created once the script runs for the first time:

> SET 1 {"name": "movie 1", "childs": [2,5,6,4]}
SET 2 {"name": "movie 2", "childs": []}
SET 3 {"name": "movie 3", "childs": [7]}
SET 4 {"name": "movie 4", "childs": [8,15,14]}
SET 5 {"name": "serie 1", "childs": [9]}
SET 6 {"name": "serie 2", "childs": [10, 3]}
SET 7 {"name": "serie 3", "childs": [13]}
SET 8 {"name": "serie 4", "childs": [20]}
SET 9 {"name": "movie A", "childs": [20]}
SET 10 {"name": "movie B", "childs": [11,12]}
SET 11 {"name": "series A", "childs": [20]}
SET 12 {"name": "series B", "childs": [20]}
SET 13 {"name": "mini series 1", "childs": [20]}
SET 14 {"name": "mini series 2", "childs": [20]}
SET 15 {"name": "serie 5", "childs": [16]}
SET 16 {"name": "movie 5", "childs": []}
