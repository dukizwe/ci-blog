<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersCategoriesSeeder extends Seeder
{
	public function run()
	{
                    $db = db_connect();
                    $db->query("TRUNCATE TABLE users_categories");
                    $db->query("INSERT INTO users_categories(name) VALUES('admin'), ('user')");
	}
}
