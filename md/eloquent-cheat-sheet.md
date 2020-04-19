# Eloquent Cheat Sheet

* Find one by `id`
    ```php
    $user = User::find(3);
    ```

* Find many by `id`
    ```php
    $users = User::find([1, 2]);
    ```


* `findOrFail()`: Find one by `id` or return 404 page if no records were found
    ```php
    $user = User::findOrFail(3);
    ```

* Find `first` `where` condition(s)
    ```php
    $user = User::where('email', 'hello@oussama.tn')->first();
    ```

* `firstOrFail()`: Find first `where` condition(s) or return 404 page if no records were found
    ```php
    $user = User::where('email', 'hello@oussama.tn')->firstOrFail();
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

* Select `max`, `average`, `min`
    ```php
    Product::max('price');
    ```

    ```php
    Product::average('price');
    ```

    ```php
    Product::min('price');
    ```

* `increment` database column:
    ```php
    User::find('5')->increment('score'); // $user->score + 1
    User::find('5')->increment('score', 50); // $user->score + 50
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


* Select `has`

  1.  
    ```php
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
  2.
    ```php
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
  3.
    ```php
    $country = Country::has('users.purchaseOrders')->get();
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
  4.
    ```php
    $country = Country::has('users.purchaseOrders', '>', 10)->get();
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
