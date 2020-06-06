<?php

namespace Tests\Unit;

use App\Country;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_many_purchase_orders()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->purchaseOrders);
    }

    /** @test */
    public function a_user_belongs_to_country()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Country::class, $user->country);
    }

    /** @test  */
    public function users_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id','name', 'email', 'email_verified_at', 'password'
            ]), 'One or more columns are missing in users table');
    }
}
