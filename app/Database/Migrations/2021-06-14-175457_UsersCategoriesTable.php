<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersCategoriesTable extends Migration
{
	public function up()
	{
                    $fields = [
                              'name' => [
                                        'type' => 'VARCHAR',
                                        'constraint' => 50
                              ]
                    ];
                    $this->forge->addField('id')->addField($fields)->createTable('users_categories');
	}

	public function down()
	{
                    $this->forge->dropTable('user_categories');
	}
}
