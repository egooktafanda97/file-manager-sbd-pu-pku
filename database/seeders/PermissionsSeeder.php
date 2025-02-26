<?php

namespace Database\Seeders;

use App\Models\FileManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileManager::all()->each(function ($file) {
            Permission::create(['name' => $file->code_clasification ?? $file->uuid]);
        });
    }
}
