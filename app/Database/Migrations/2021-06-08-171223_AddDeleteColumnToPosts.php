<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeleteColumnToPosts extends Migration
{
	public function up()
	{
		//
                    $field = [
                              'deleted_at' => [
                                        'type' => 'DATETIME',
                                        'null' => true
                              ]
                    ];
                    $this->forge->addColumn('posts', $field);
	}

	public function down()
	{
		//
                    $this->forge->dropColumn('posts', 'deleted_at');
	}
}
