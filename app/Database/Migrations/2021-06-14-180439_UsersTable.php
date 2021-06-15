<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersTable extends Migration
{
	public function up()
	{
                    $fields = [
                              'category_id' => [
                                        'type' => 'integer'
                              ],
                              'full_name' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ],
                              'email' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ],
                              'password' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
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
                              ->addForeignKey('category_id', 'users_categories', 'id')
                              ->createTable('users');
	}

	public function down()
	{
                    $this->forge->dropTable('users');
	}
}
