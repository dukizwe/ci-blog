<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
	public function run()
	{
                    $data = [];
                    for ($i=1; $i <= 10 ; $i++) { 
                              $data[] = [
                                        'category_id' => 2,
                                        'full_name' => static::faker()->name(),
                                        'email' => static::faker()->email,
                                        'password' => sha1('12345678')
                              ];
                    }
                    $userModel = new UserModel();
                    db_connect()->query('TRUNCATE TABLE users');
                    $userModel->insertBatch($data);
	}
}
