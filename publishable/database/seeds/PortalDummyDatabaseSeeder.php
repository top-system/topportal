<?php

use Illuminate\Database\Seeder;

class PortalDummyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            PagesTableSeeder::class,
            TranslationsTableSeeder::class,
            PermissionRoleTableSeeder::class,
        ]);
    }
}
