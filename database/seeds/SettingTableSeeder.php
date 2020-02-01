<?php

use App\Models\SettingGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
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
            $settings = [
                [
                    ['name' => 'app_name', 'value' => 'CODEC', 'default_value' => 'CODEC', 'type' => 'text', 'comment' => null, 'required' => 1, 'order' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                    ['name' => 'app_description', 'value' => 'CODEC App', 'default_value' => 'CODEC App', 'type' => 'textarea', 'comment' => null, 'required' => 1, 'order' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                    ['name' => 'app_logo', 'value' => null, 'default_value' => null, 'type' => 'file', 'comment' => null, 'required' => 0, 'order' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                    ['name' => 'favicon', 'value' => null, 'default_value' => null, 'type' => 'file', 'comment' => null, 'required' => 0, 'order' => 4, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                    ['name' => 'app_author', 'value' => 'Rio Prastiawan', 'default_value' => 'Rio Prastiawan', 'type' => 'text', 'comment' => null, 'required' => 1, 'order' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                    ['name' => 'app_version', 'value' => '0.0.1-alpha', 'default_value' => '0.0.1-alpha', 'type' => 'text', 'comment' => null, 'required' => 1, 'order' => 6, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ],
            ];

            foreach ($settings as $key => $setting) {
                $key++;
                $settingGroup = SettingGroup::find(['id' => $key])->first();

                if (!$settingGroup) {
                    continue;
                }

                foreach($setting as $record){
                    $settingGroup->settings()->create($record);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }
}
