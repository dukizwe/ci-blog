<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CommentsTable extends Migration
{
	public function up()
	{
		//
                    $fields = [
                              'name' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ],
                              'post_id' => [
                                        'type' => 'INTEGER'
                              ],
                              'body' => [
                                        'type' => 'TEXT',
                                        'constraint' => 500
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
                              ->addForeignKey('post_id', 'posts', 'id', '', 'CASCADE')
                              ->createTable('comments');
	}

	public function down()
	{
		//
                    $this->forge->dropTable('comments');
	}
}
