<?php

namespace App\Database\Seeds;

use App\Models\PostModel;
use CodeIgniter\Database\Seeder;

class PostsSeeder extends Seeder
{
	public function run()
	{
		//
                    $data = [];
                    for ($i=1 ; $i <= 100; $i++) { 
                              $data[] = [
                                        'title' => static::faker()->text(50),
                                        'body' => static::faker()->text(5000)
                              ];
                    }
                    $postModel = new PostModel();
                    $db = db_connect();
                    $db->query('TRUNCATE TABLE posts');
                    $postModel->insertBatch($data);
	}
}
