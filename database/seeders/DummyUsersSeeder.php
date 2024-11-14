<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'=>'Anisa Nurhidayah',
                'nis'=>'2109210',
                'email'=>'hidayahnuranisa123@gmail.com',
                'role'=>'guru',
                'password'=>bcrypt('123456'),
            ],
            [
                'name'=>'Kholifatul Umam',
                'nis'=>'291001718',
                'email'=>'umam321@gmail.com',
                'role'=>'siswa',
                'password'=>bcrypt('123456'),
            ]
        ];

        foreach($userData as $key => $val ){
            User :: create ($val);
        }
    }
}
