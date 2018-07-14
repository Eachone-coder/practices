<?php
/**
 * User: zjx
 * Date: 2018/6/26
 * Time: 21:02
 */

$table = new swoole_table(1024);

$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 64);
$table->column('age', $table::TYPE_INT, 3);

$table->create();

$table->set('singwa_imooc', ['id' => 1, 'name' => 'singwa', 'age' => 30]);

$table['singwa_imooc_2'] = [
    'id' => 2,
    'name' => 'singwa2',
    'age' => 31,
];

var_dump($table->get('singwa_imooc'));
var_dump($table['singwa_imooc_2']);

$table->incr('singwa_imooc_2', 'age', 2);
var_dump($table['singwa_imooc_2']);

$table->del('singwa_imooc_2');
var_dump($table['singwa_imooc_2']);