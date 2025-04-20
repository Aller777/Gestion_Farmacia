<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Crear usuarios
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => 'alex',
            'email' => 'alex777@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        // Insertar categorías
        DB::table('categorias')->insert([
            [
                'nombre' => 'Analgésicos',
                'estado' => 1,
                'descripcion' => 'Medicamentos para aliviar el dolor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Antibióticos',
                'estado' => 1,
                'descripcion' => 'Medicamentos para tratar infecciones bacterianas.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Vitaminas y Suplementos',
                'estado' => 1,
                'descripcion' => 'Productos para fortalecer el sistema inmunológico y la salud general.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cuidado Personal',
                'estado' => 1,
                'descripcion' => 'Productos para la higiene y el cuidado del cuerpo.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insertar proveedores
        DB::table('proveedores')->insert([
            [
                'nombre' => 'FarmaPlus SAC',
                'ruc' => '20123456789',
                'direccion' => 'Av. Salud 123, Lima',
                'telefono' => '987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Botica Central SRL',
                'ruc' => '20987654321',
                'direccion' => 'Jr. Medicinas 456, Arequipa',
                'telefono' => '912345678',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Insertar productos
        DB::table('productos')->insert([
            [
                'nombre' => 'Paracetamol 500mg',
                'descripcion' => 'Analgésico y antipirético',
                'precio_compra' => 0.20,
                'precio_venta' => 0.50,
                'stock' => 100,
                'stock_minimo' => 10,
                'fecha_vencimiento' => '2026-12-31',
                'categoria_id' => 1,
                'proveedor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Amoxicilina 500mg',
                'descripcion' => 'Antibiótico de amplio espectro',
                'precio_compra' => 0.40,
                'precio_venta' => 1.00,
                'stock' => 50,
                'stock_minimo' => 5,
                'fecha_vencimiento' => '2025-10-15',
                'categoria_id' => 2,
                'proveedor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Nastiflu 500mg',
                'descripcion' => 'Antibiótico para la gripe',
                'precio_compra' => 0.50,
                'precio_venta' => 1.20,
                'stock' => 50,
                'stock_minimo' => 5,
                'fecha_vencimiento' => '2025-10-15',
                'categoria_id' => 2,
                'proveedor_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
