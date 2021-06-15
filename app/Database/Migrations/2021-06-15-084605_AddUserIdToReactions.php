<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToReactions extends Migration
{
	public function up()
	{
                    $field = [
                              'ip_address' => [
                                        'name' => 'user_id',
                                        'type' => 'integer'
                              ]
                    ];
                    $this->forge->modifyColumn('reactions', $field);
	}

	public function down()
	{
                    $field = [
                              'user_id' => [
                                        'name' => 'ip_address',
                                        'type' => 'VARCHAR',
                                        'constraint' => 255
                              ]
                    ];
                    $this->forge->modifyColumn('reactions', $field);
	}
}
