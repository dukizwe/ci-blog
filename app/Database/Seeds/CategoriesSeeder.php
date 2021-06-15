<?php

namespace App\Database\Seeds;

use App\Models\TagModel;
use CodeIgniter\Database\Seeder;

class CategoriesSeeder extends Seeder
{
	public function run()
	{
		//
                    $data = [];
                    for ($i=1; $i <= 20; $i++) { 
                              $data[] = [
                                        'name' => static::faker()->text(10),
                              ];
                    }
                    $db = db_connect();
                    // $db->query("TRUNCATE TABLE tags");
                    $categoriesModel = new TagModel();
                    $categoriesModel->insertBatch($data);
	}
}
