<?php

namespace App\Database\Seeds;

use App\Models\CommentModel;
use CodeIgniter\Database\Seeder;

class CommentsSeeder extends Seeder
{
	public function run()
	{
		//
                    $data = [];
                    for ($i=1 ; $i < 100; $i++) { 
                              $data[] = [
                                        'user_id' => random_int(1, 10),
                                        'body' => static::faker()->text(100),
                                        'post_id' => random_int(1, 99),
                                        'created_at' => static::faker()->dateTime('2021-01-25')->format('Y-m-d H:i:s')
                              ];
                    }
                    $commentModel = new CommentModel();
                    $db = db_connect();
                    $db->query('TRUNCATE TABLE comments');
                    $commentModel->insertBatch($data);
	}
}
