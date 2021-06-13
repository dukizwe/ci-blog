<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TagPost extends Migration
{
	public function up()
	{
		//
                    $fields = [
                              'post_id' => [
                                        'type' => 'integer',
                                        'null' => true
                              ],
                              'tag_id' => [
                                        'type' => 'integer',
                                        'null' => true
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
                              ->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'SET NULL')
                              ->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'SET NULL')
                              ->createTable('tag_post');
	}

	public function down()
	{
		//
                    $this->forge->dropTable('tag_post');
	}
}
