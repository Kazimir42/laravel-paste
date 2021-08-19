<?php

namespace Database\Seeders;

use App\Models\Paste;
use App\Models\User;
use Database\Factories\GuestFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $guest = new User([
            'name' => 'Guest',
            'email' => 'guest@guest.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $guest->save();

        \App\Models\User::factory(3)->create();

        for ($i = 0; $i < 10; $i++) {
            $paste = new Paste([
                'title' => 'paste ' . $i,
                'content' => sprintf('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed scelerisque placerat leo, et iaculis arcu varius euismod. Morbi sagittis diam ligula, eu hendrerit tellus pulvinar a. Integer dui dui, iaculis pellentesque semper ac, molestie at sapien. Sed suscipit mollis arcu, eget placerat nisi dictum in. In ac convallis lacus, et accumsan nisl. Proin tristique vulputate quam, nec imperdiet tellus aliquet ac. Duis fermentum felis porttitor facilisis porttitor. Aliquam id vestibulum sem, eget tristique diam. Mauris ultricies urna at nulla lobortis aliquam.'),
                'status' => 'public',
                'user_id' => 1
            ]);
            $paste->save();
        }
    }
}
