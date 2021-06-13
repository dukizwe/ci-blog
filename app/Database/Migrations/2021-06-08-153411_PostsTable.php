<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PostsTable extends Migration
{
	public function up()
	{
		//
                    $fields = [
                              'title' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ],
                              'body' => [
                                        'type' => 'TEXT'
                              ],/* 
                              'image' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255,
                                        'unique' => true,
                                        'null' => true
                              ], */
                              'created_at' => [
                                        'type' => 'DATETIME'
                              ],
                              'updated_at' => [
                                        'type' => 'DATETIME',
                                        'null' => true
                              ],
                    ];
                    $this->forge->addField('id')->addField($fields)->createTable('posts');

	}

	public function down()
	{
		//
                    $this->forge->dropTable('posts');
	}
}
