<?php

namespace App\Database\Seeds;

use App\Models\TagPost;
use CodeIgniter\Database\Seeder;

class TagPostSeeder extends Seeder
{
	public function run()
	{
		//
                    $data = [];
                    for ($i=1; $i <= 100; $i++) { 
                              for ($j=1; $j <= random_int(3, 5) ; $j++) {
                                        $data[] = [
                                                  'post_id' => $i,
                                                  'tag_id' => random_int(1, 20)
                                        ];
                              }
                    }
                    $db = db_connect();
                    $db->query('TRUNCATE TABLE tag_post');
                    $tagPostModel = new TagPost();
                    $tagPostModel->insertBatch($data);
	}
}
