<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReactionsTable extends Migration
{
	public function up()
	{
		//
                    $fields = [
                              'post_id' => [
                                        'type' => 'INTEGER'
                              ],
                              'ip_address' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ],
                              'vote' => [
                                        'type' => 'INTEGER',
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
                    $this->forge->addField('id')
                              ->addField($fields)
                              ->addForeignKey('post_id', 'posts', 'id')
                              ->createTable('reactions');
	}

	public function down()
	{
		//
                    $this->forge->dropTable('reactions');
	}
}
