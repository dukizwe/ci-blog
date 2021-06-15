<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToComments extends Migration
{
	public function up()
	{
                    $field = [
                              'name' => [
                                        'name' => 'user_id',
                                        'type' => 'integer'
                              ]
                    ];
                    $this->forge->modifyColumn('comments', $field);
	}

	public function down()
	{
                    $field = [
                              'user_id' => [
                                        'name' => 'name',
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ]
                    ];
                    $this->forge->modifyColumn('comments', $field);
	}
}
