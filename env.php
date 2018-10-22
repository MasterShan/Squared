<?php

require "vendor/autoload.php";

use App\Database\Database;

$db = new Database();
$rows = $db->fetch("SELECT * FROM users")->between('id', 0, '?')->and('name', 'LIKE', '?')->args([50, 'peter'])->execute();
#$db->insert('users', ['name' => 'pete']);
#$rows = $db->fetch("SELECT * FROM users")->where('id', '=', '?', 'NOT')->args([3123])->execute();
#$db->delete('users')->where('id', '=', 23)->execute();
#$db->update('users', ['id' => 21])->where('name', '=', 'peter')->execute();

echo '<pre>';
print_r($rows);
echo '</pre>';


#$db->delete('users')->where('id', '=', 23)->execute();