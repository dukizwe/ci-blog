<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CategoriesTable extends Migration
{
	public function up()
	{
		//
                    $fields = [
                              'name' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 100,
                              ],
                              'created_at' => [
                                        'type' => 'DATETIME'
                              ],
                              'updated_at' => [
                                        'type' => 'DATETIME',
                                        'null' => true
                              ],
                              'deleted_at' => [
                                        'type' => 'DATETIME',
                                        'null' => true
                              ]
                    ];
                    $this->forge->addField('id')->addField($fields)->createTable('tags');
	}

	public function down()
	{
		//
                    $this->forge->dropTable('tags');
	}
}
