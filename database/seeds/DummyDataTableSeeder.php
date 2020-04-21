<?php

use App\Country;
use App\Product;
use App\ProductCategory;
use App\PurchaseOrder;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DummyDataTableSeeder extends Seeder
{
    /**
     * @var Faker
     */
    private $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Creating countries...');

        for ($i = 1; $i < 5; $i++) {
            Country::create([
                'name' => 'Country ' . $i,
            ]);
        }

        $this->command->info('Creating users...');

        Country::get()->each(function ($country) {

            for ($i = 0; $i < rand(4, 12); $i++):
                $country->users()->create([
                    'country_id' => $country->id,
                    'name' => 'User ' . $i . ' C' . $country->id,
                    'email' => "user{$i}_c{$country->id}@laravel.test",
                    'password' => bcrypt('secret'),
                ]);
            endfor;

        });

        $this->command->info('Creating passports...');

        User::get()->each(function ($user) {

            $user->passport()->create([
                'number' => "USR{$user->id}CTR{$user->country->id}",
                'date_of_expiry' => Carbon::now()->addDays(rand(50, 900)),
            ]);
        });


        $this->command->info('Creating product categories...');

        for ($i = 0; $i < 5; $i++):

            ProductCategory::create([
                'name' => 'Product ' . $i,
                'description' => $this->faker->text(100),
            ]);

        endfor;

        $this->command->info('Creating products...');

        ProductCategory::select('id')->get()->each(function ($productCategory) {

            for ($i = 0; $i < rand(1, 15); $i++):

                $productCategory->products()->create([
                    'name' => 'Product ' . $i . '_C' . $productCategory->id,
                    'price' => rand(50, 500),
                    'description' => $this->faker->text(200),
                    'is_available' => $this->faker->boolean,
                ]);

            endfor;

        });

        $this->command->info('Creating purchase orders...');

        User::get()->each(function ($user) {

            factory(PurchaseOrder::class, rand(0, 5))->create([
                'user_id' => $user->id,
            ])->each(function ($purchaseOrder) {

                $products = Product::inRandomOrder()
                    ->limit(rand(1, 3))
                    ->get();

                foreach ($products as $product):
                    $purchaseOrder->products()->attach(
                        $product->id,
                        ['quantity' => rand(1, 5)]
                    );
                endforeach;
            });

        });
    }
}
