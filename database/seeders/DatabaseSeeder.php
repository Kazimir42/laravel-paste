<?php

namespace Database\Seeders;

use App\Models\Paste;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        for ($i = 0; $i < 10; $i++) {
            $paste = new Paste([
                'content' => sprintf('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque placerat leo, et iaculis arcu varius euismod. Morbi sagittis diam ligula, eu hendrerit tellus pulvinar a. Integer dui dui, iaculis pellentesque semper ac, molestie at sapien. Sed suscipit mollis arcu, eget placerat nisi dictum in. In ac convallis lacus, et accumsan nisl. Proin tristique vulputate quam, nec imperdiet tellus aliquet ac. Duis fermentum felis porttitor facilisis porttitor. Aliquam id vestibulum sem, eget tristique diam. Mauris ultricies urna at nulla lobortis aliquam.'),
                'user_id' => 13
            ]);
            $paste->save();
        }
    }
}
