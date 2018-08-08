<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder_development extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		'name' => 'Admin',
    		'email' => 'admin@example.com',
    		'password' => bcrypt('secret!'),
    		'created_at' => Carbon::now(),
    		'updated_at' => Carbon::now()
		]);
		DB::table('users')->insert([
			'name' => 'Mittens McGee',
			'email' => 'no@me.com',
			'password' => bcrypt(strtolower('1234567')),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now()
		]);
        
		$names = ['Aaron', 'Beth', 'Chris', 'Dennis', 'Erik', 'Francine', 'Ginny', 'Hermione', 'Ian', 'Josh', 'Jennifer', 'Karla', 'Linus', 'Madeline', 'Neville', 'Opie', 'Persephone', 'Quill', 'Rasputin', 'Sunny', 'Trevor', 'Ursula', 'Vanessa', 'Wendy', 'Xephos', 'Yolanda', 'Zander', 'Abel', 'Abie', 'Acey', 'Acie', 'Adam', 'Adan', 'Aden', 'Adin', 'Ajay', 'Alan', 'Alba', 'Alby', 'Aldo', 'Alec', 'Alek', 'Alex', 'Alma', 'Alta', 'Alto', 'Alva', 'Alvy', 'Amil', 'Amin', 'Amir', 'Amit', 'Amon', 'Amos', 'Andy', 'Anna', 'Arba', 'Arch', 'Ares', 'Aric', 'Arlo', 'Arne', 'Arno', 'Aron', 'Arvo', 'Atha', 'Audy', 'Avon', 'Axel', 'Ayan', 'Babe', 'Baby', 'Bart', 'Beau', 'Bell', 'Bert', 'Bill', 'Bird', 'Birt', 'Blas', 'Bode', 'Bose', 'Boss', 'Boyd', 'Brad', 'Bret', 'Buck', 'Budd', 'Buel', 'Bunk', 'Burk', 'Burl', 'Burr', 'Burt', 'Bush', 'Byrd', 'Cade', 'Cael', 'Cain', 'Cale', 'Carl', 'Cary', 'Case', 'Cash', 'Cass', 'Cato', 'Chad', 'Chas', 'Chaz', 'Chet', 'Chin', 'Chip', 'Clay', 'Clem', 'Cleo', 'Coby', 'Codi', 'Cody', 'Coen', 'Cole', 'Colt', 'Cora', 'Cory', 'Coty', 'Crew', 'Cris', 'Cruz', 'Curt', 'Dale', 'Dana', 'Dane', 'Dann', 'Darl', 'Dash', 'Dave', 'Davy', 'Dean', 'Dell', 'Deon', 'Derl', 'Desi', 'Dick', 'Dink', 'Dino', 'Dion', 'Dirk', 'Dock', 'Doll', 'Donn', 'Dora', 'Dorr', 'Doss', 'Doug', 'Drew', 'Duff', 'Duke', 'Earl', 'Eben', 'Eber', 'Eddy', 'Eden', 'Edie', 'Edna', 'Eino', 'Elam', 'Elby', 'Elex', 'Elie', 'Ella', 'Elmo', 'Elon', 'Eloy', 'Elva', 'Elza', 'Elzy', 'Emil', 'Emit', 'Emma', 'Emry', 'Enos', 'Enzo', 'Erby', 'Eric', 'Erie', 'Erin', 'Erle', 'Esau', 'Esco', 'Esta', 'Eula', 'Evan', 'Ewin', 'Ezra', 'Fate', 'Ferd', 'Fern', 'Finn', 'Flem', 'Floy', 'Foch', 'Ford', 'Fred', 'Gabe', 'Gael', 'Gage', 'Gail', 'Gale', 'Gary', 'Gene', 'Geno', 'Gino', 'Glen', 'Gray', 'Greg', 'Grey', 'Guss', 'Gust', 'Hale', 'Hall', 'Hamp', 'Hank', 'Hans', 'Harl', 'Harm', 'Hart'];
		
		foreach ($names as $name) {
	    	DB::table('users')->insert([
	    		'name' => $name,
	    		'email' => strtolower($name) . '@example.com',
	    		'password' => bcrypt(strtolower($name)),
	    		'created_at' => Carbon::now(),
	    		'updated_at' => Carbon::now()
	    	]);
		}
    }
}
