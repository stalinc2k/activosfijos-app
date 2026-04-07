<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'TestUser',
            'email' => 'user@user.com',
        ]);
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'type' => 'admin',
            'status' => 'enabled'
        ]);
        DB::table('departments')->insert([
            'name' => 'SISTEMAS',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'LOGISTICA',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'FACTURACION',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'BODEGA',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'MERCADEO',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'GERENCIAS',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'CONTABILIDAD',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'RRHH',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        DB::table('departments')->insert([
            'name' => 'COBRANZA',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
        //DATOS CARGOS
        DB::table('appointments')->insert([
            'name' => 'JEFE DE SISTEMAS',
            'department_id' => 01,
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);

        DB::table('appointments')->insert([
            'name' => 'JEFE DE LOGISTICA',
            'department_id' => 02,
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);

        DB::table('employees')->insert([
            'name' => 'STALIN REASCOS',
            'mail' => 'sistemas@hospimedikka.com',
            'department_id' => 01,
            'appointment_id' => 01,
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);

         DB::table('categories')->insert([
            'name' => 'ACTIVOS',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);

        DB::table('categories')->insert([
            'name' => 'SUMINISTROS',
            'created_at' => Carbon::now(),
            'created_by' => 02,
        ]);
    }
}
