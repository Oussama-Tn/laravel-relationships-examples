## Testing models:

* Reset your database after each test :
    ```php
    use RefreshDatabase;
    ```

* Commands:
    ```bash
    vendor/bin/phpunit
    vendor/bin/phpunit --filter UserTest
    vendor/bin/phpunit --filter a_user_has_many_purchase_orders
    ```
    * You may create aliases for these commands, example:
        ```bash
        alias pu='vendor/bin/phpunit'
        alias pf='vendor/bin/phpunit --filter'
        ```
        Then use them as follow:
        ```bash
        pu
        pf UserTest
        pf a_user_has_many_purchase_orders
        ```

* Create unit test for model:
    ```bash
    php artisan make:test UserTest --unit
    ```

* Before testing, you may get this error:
    ```bash
    InvalidArgumentException: Unable to locate factory for [App\User].
    ```
    * Solution:
    replace `use PHPUnit\Framework\TestCase;` with `use Tests\TestCase;`

* Test relationship:
    ```php
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
    ```

* Make factory
    ```php
    php artisan make:factory UserFactory --model=User
    ```

    ```php
    factory(App\Country::class)->raw();
    /*
    => [
         "name" => "France",
       ]
    */
  
    factroy(App\Country::class)->make(); 
    /*
    Country Object (NOT PERSISTED in database)
    => App\Country {#2728
         name: "Tunisia",
       }
    */
    
  
    factroy(App\Country::class)->create();
    /*
    Country Object (PERSISTED in database)
    => App\Country {#2728
         name: "Japan",
         updated_at: "2020-06-05 11:16:44",
         created_at: "2020-06-05 11:16:44",
         id: 5,
       }
    */
    ```


* Create `signIn()` to authenticate user for testing purpose:
    ```php
    namespace Tests;
    
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use Laravel\Passport\Passport;
    
    abstract class TestCase extends BaseTestCase
    {
        use CreatesApplication;
    
        protected function signIn($user = null)
        {
            $user = $user ?: factory('App\Models\User')->create();
    
            $this->actingAs($user);
    
            return $user;
        }
    }
    ```
