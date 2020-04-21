# Eloquent Cheat Sheet

* `create(array $attributes = [])`: Save a new model and return the instance
    ```php
    Country::create(['name' => 'France']);
    ```

* Find one by `id`
    ```php
    $user = User::find(3);
    // You can specify columns
    $user = User::find(3, ['name', 'email']);
    ```

* Find many by `id`
    ```php
    $users = User::find([1, 2]);
    // or
    $users = User::findMany([3, 2]);
    // or, you can select columns you want to fetch
    $users = User::findMany([3, 2], ['email', 'name']);
    ```


* `findOrFail()`: Find one by `id` or return 404 page if no records were found
    ```php
    $user = User::findOrFail(3);
    ```

* Find `first` `where` condition(s)
    ```php
    $user = User::where('email', 'hello@oussama.tn')->first();
    // or
    $user = User::firstWhere('email', 'hello@oussama.tn');
    ```

* `whereColumnName()`: append `column_name` and suffix it to `where`
    ```php
    Product::where('is_available', false)->get();
    // Is the same as:
    Product::whereIsAvailable(false)->get();
    ```

* `firstOrFail()`: Find first `where` condition(s) or return 404 page if no records were found
    ```php
    $user = User::where('email', 'hello@oussama.tn')->firstOrFail();
    ```

* `firstOrCreate(array $attributes, array $values = [])`: Get the first record matching the attributes or create it.
    ```php
    $country = Country::firstOrCreate(['name' => 'France']);
    ```

* `updateOrCreate(array $attributes, array $values = [])`: Create or update a record matching the attributes, and fill it with values.
    ```php
    $product = Product::updateOrCreate(['name' => 'Product 0_C1'], ['price' => '560']);
    ```

* `delete()`: Delete a record from the database.
    ```php
    $product = Product::find(10);
    $product->delete();
    ```

* Select all:
    ```sql
    User::get();
    User::all();
    ```

* `withCount`
    ```php
    // Select all users with `purchase_orders_count`
    User::withCount('purchaseOrders')->get();
    ```
    ```sql
    SELECT `users`.*,
      (SELECT count(*)
       FROM `purchase_orders`
       WHERE `users`.`id` = `purchase_orders`.`user_id`) AS `purchase_orders_count`
    FROM `users`
    ```

* `count`
    ```php
    $numberOfUsers = User::where('country_id', 2)->count();
    ```

* `exists()`: Determine if any rows exist for the current query
    ```php
    $recordExists = PurchaseOrder::where('date', '2020-03-14')->exists(); // true/false
    ```

* `doesntExist()`: Determine if no rows exist for the current query
    ```php
    $notExist = User::where('email', 'hello@oussama.tn')->doesntExist(); // true/false
    ```

* `whereIn($column, $values)`: Add a "where in" clause to the query
    ```php
    $users = User::whereIn('country_id', [1 , 2])->get();
    ```
    ```sql
    select * from `users` where `country_id` in (?, ?)
    ```

* `whereNotIn($column, $values)`: Add a "where not in" clause to the query
    ```php
    $users = User::whereNotIn('country_id', [1 , 2])->get();
    ```
    ```sql
    select * from `users` where `country_id` not in (?, ?)
    ```

* Select `where (conditionA=true and conditionB=true)`

    ```php
    $products = Product::where(['price' => 10, 'is_available' => true])->get();  
    $products = Product::where('price', 10)->where('is_available', true)->get();  
    ```
    ```sql
    select * from `products` where (`price` = ? and `is_available` = ?)
    ```

    ---

    ```php
    $products = Product::where('is_available', true)->where('price', '<', '100')->get();  
    ```
    ```sql
    select * from `products` where `is_available` = ? and `price` < ?
    ```
* Select `where(conditionA=true) and (conditionB=true or ConditionC=true)`

    ```php
    $products = Product::where('is_available', true)
                ->where(function ($query) {
                    $query->orWhere('name', 'like', '%new%')
                        ->orWhere('description', 'like', '%new%');
                })
                ->get();  
    ```
    ```sql
    select * from `products` where `is_available` = ? and (`name` like ? or `description` like ?)
    ```

* Select `where(conditionA=true) or (conditionB=true and ConditionC=true)`
    ```php
    $products = Product::where('product_category_id', 3)
                ->orWhere(function ($query) {
                    $query->where('name', 'like', '%new%')
                        ->where('description', 'like', '%new%');
                })
                ->get();  
    ```
    ```sql
    select * from `products` where `product_category_id` = ? or (`name` like ? and `description` like ?)
    ```

* Select `whereTime`, `whereDate`, `whereDay`, `whereMonth`, `whereYear`

    ```php
    $products = Product::whereTime('created_at', '09:10:10')->get();
    ```
    ```php
    $products = Product::whereDate('created_at', '2020-01-31')->get();
    ```
    ```php
    $products = Product::whereDay('created_at', '15')->get();
    $products = Product::whereDay('created_at', '>', '15')->get();
    ```
    ```php
    $products = Product::whereMonth('created_at', '06')->get();
    $products = Product::whereMonth('created_at', '<', '06')->get();
    ```
    ```php
    $products = Product::whereYear('created_at', 2010)->get();
    $products = Product::whereYear('created_at', '>', 2010)->get();
    ```

* Select using `column alias`

    ```php
    $product = App\Product::select('name as product_name')->get();
    ```
    ```sql
    select `name` as `product_name` from `products`
    ```

* Select `COUNT` and `groupBy`

    ```php
    Product::select(DB::raw('count(*) as product_count'))->groupBy('product_category_id')->get();
    ```
    ```sql
    select count(*) as product_count from `products` group by `product_category_id`
    ```

* Select `max`, `average`, `min`, `sum`
    ```php
    Product::max('price');
    ```

    ```php
    Product::average('price');
    Product::avg('price');
    ```

    ```php
    Product::min('price');
    ```

    ```php
    Product::sum('price');
    ```

* `increment` or `decrement` a column's value by a given amount:
    ```php
    $user = User::find('5');
    $user->increment('score'); // $user->score + 1
    $user->increment('score', 50); // $user->score + 50
    ```

* Select `inRandomOrder`
    ```php
    // Select the first element
    User::inRandomOrder()->first();
    
    //Select all records
    User::inRandomOrder()->get();
    ```
    ```sql
    select * from `users` order by RAND()
    ```


* Select `has`, `whereHas`, `orHas`
 
    ```php
    // Retrieve users that have at least one purchase order
    $users = User::has('purchaseOrders')->get();
    ```
    ```sql
    SELECT *
    FROM `users`
    WHERE EXISTS
        (SELECT *
         FROM `purchase_orders`
         WHERE `users`.`id` = `purchase_orders`.`user_id`)
    ```

   ---

    ```php
    // Retrieve users who made more that 20 purchase orders
    $users = User::has('purchaseOrders', '>', '20')->get();
    ```
    ```sql
    SELECT *
    FROM `users`
    WHERE
        (SELECT count(*)
         FROM `purchase_orders`
         WHERE `users`.`id` = `purchase_orders`.`user_id`) > 20
    ```

   ---

    ```php
    // Retrieve countries  with at least one user who made one or more purchase order
    $countries = Country::has('users.purchaseOrders')->get();
    ```
    ```sql
    SELECT *
    FROM `countries`
    WHERE EXISTS
        (SELECT *
         FROM `users`
         WHERE `countries`.`id` = `users`.`country_id`
           AND EXISTS
             (SELECT *
              FROM `purchase_orders`
              WHERE `users`.`id` = `purchase_orders`.`user_id`))
    ```

   ---

    ```php
    // Retrieve countries with at least one user who made more than 10 purchase orders
    $countries = Country::has('users.purchaseOrders', '>', 10)->get();
    ```
    ```sql
    SELECT *
    FROM `countries`
    WHERE EXISTS
        (SELECT *
         FROM `users`
         WHERE `countries`.`id` = `users`.`country_id`
           AND
             (SELECT count(*)
              FROM `purchase_orders`
              WHERE `users`.`id` = `purchase_orders`.`user_id`) > 10)
    ```

    ---

    ```php
    // Retrieve product categories with at least one product that have 'corporis' in it's description
    $productCategories = ProductCategory::whereHas('products', function($query){
        $query->where('description', 'like', '%corporis%');
    })->get();
    ```
    ```sql
    SELECT *
    FROM `product_categories`
    WHERE EXISTS
        (SELECT *
         FROM `products`
         WHERE `product_categories`.`id` = `products`.`product_category_id`
           AND `description` LIKE ?)
    ```

    ---

    ```php
    // Retrieve product categories having more than 2 products with 'corporis' in their description
    ProductCategory::whereHas('products', function($query){
        $query->where('description', 'like', '%corporis%');
    }, '>', 2)->get();
    ```
    ```sql
    SELECT *
    FROM `product_categories`
    WHERE
        (SELECT count(*)
         FROM `products`
         WHERE `product_categories`.`id` = `products`.`product_category_id`
           AND `description` LIKE ?) > 2
    ```

* `doesntHave`, `whereDoesntHave`, `orDoesntHave`

    ```php
    //  Retrieve all users that don't have any purchase order
    User::doesntHave('purchaseOrders')->get();
    ```
    ```sql
    SELECT *
    FROM `users`
    WHERE NOT EXISTS
        (SELECT *
         FROM `purchase_orders`
         WHERE `users`.`id` = `purchase_orders`.`user_id`)
    ```

    ---

    ```php
    //  Retrieve all users that don't have any purchase order + some conditions..
    User::whereDoesntHave('purchaseOrders', function($q){
        $q->where('date', '<', '2020-03-30');
    })->get();
    ```
    ```sql
    SELECT
    FROM `users`
    WHERE NOT EXISTS
        (SELECT *
         FROM `purchase_orders`
         WHERE `users`.`id` = `purchase_orders`.`user_id`
           AND `date` < ?)
    ```

    ---

* Get table name
    ```php
    (new User)->getTable(); // users
    ```

* Get the primary key for the model
    ```php
    (new User)->getKeyName(); // id
    ```

* `replicate()`: Clone the model into a new, non-existing instance.
    ```php
    $product = Product::first();
    $newProductInstance = $product->replicate();
    ```

* `toSql()`: Get the SQL representation of the query
    ```php
    $sql = User::where('email', 'hello@oussama.tn')->toSql();
    // $sql => "select * from `users` where `email` = ?"
    ```

* `getBindings()`: Get the current query value bindings in a flattened array
    ```php
    $bindings = User::where('email', 'hello@oussama.tn')->getBindings();
    // $bindings = ["hello@oussama.tn"];
    ```

* `oldest($column = null)`: Add an "order by" clause for a timestamp to the query.

    ```php
    Post::oldest()->get();
    ```
    ```sql
    select * from `posts` order by `created_at` asc
    ```

    ```php
    Post::oldest('updated_at')->get();
    ```
    ```sql
    select * from `posts` order by `updated_at` asc
    ```

* `latest($column = null)`: Add an "order by" clause for a timestamp to the query.

    ```php
    Post::latest()->get();
    ```
    ```sql
    select * from `posts` order by `created_at` desc
    ```

    ```php
    Post::latest('updated_at')->get();
    ```
    ```sql
    select * from `posts` order by `updated_at` desc
    ```
