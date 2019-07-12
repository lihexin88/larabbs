<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     *按照顺序进行批量数据填充
     */
    public function run() {
        $this->call(UsersTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
		$this->call(ReplysTableSeeder::class);
    }
}
