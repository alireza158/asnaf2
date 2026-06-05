<?php
namespace Database\Seeders;
use App\Models\Role;use App\Models\User;use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder{public function run():void{$u=User::updateOrCreate(['email'=>'admin@example.com'],['name'=>'مدیرکل سامانه اتاق اصناف گرگان','mobile'=>'09110000000','password'=>Hash::make('password'),'is_active'=>true,'email_verified_at'=>now()]);if($r=Role::where('name','super-admin')->first()){$u->roles()->syncWithoutDetaching([$r->id]);}}}
