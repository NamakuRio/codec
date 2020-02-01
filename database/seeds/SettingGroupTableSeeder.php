<?php

use App\Models\SettingGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $settingGroups = [
                ['name' => 'Pengaturan Umum', 'slug' => Str::slug('Pengaturan Umum'), 'description' => 'Pengaturan umum seperti, judul situs, deskripsi situs, alamat dan sebagainya.', 'icon' => 'fas fa-cog', 'order' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ];

            SettingGroup::insert($settingGroups);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }
}
