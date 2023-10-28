<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputan['name'] = 'Admin';
        $inputan['email'] = 'admin@gmail.com';//ganti pake emailmu
        $inputan['password'] = Hash::make('112233');//passwordnya 123258
        $inputan['phone'] = '085852527575';
        $inputan['alamat'] = 'Tokyo City';
        $inputan['role'] = 'admin';//kita akan membuat akun atau users in dengan role admin
        User::create($inputan);

        $input['name'] = 'Seller';
        $input['email'] = 'seller@gmail.com';//ganti pake emailmu
        $input['password'] = Hash::make('112233');//passwordnya 123258
        $input['phone'] = '085852527575';
        $input['alamat'] = 'Tokyo City';
        $input['role'] = 'seller';//kita akan membuat akun atau users in dengan role admin
        User::create($input);

        $inpute['name'] = 'Member';
        $inpute['email'] = 'member@gmail.com';//ganti pake emailmu
        $inpute['password'] = Hash::make('112233');//passwordnya 123258
        $inpute['phone'] = '085852527575';
        $inpute['alamat'] = 'Tokyo City';
        $inpute['role'] = 'member';//kita akan membuat akun atau users in dengan role admin
        User::create($inpute);
    }
}
