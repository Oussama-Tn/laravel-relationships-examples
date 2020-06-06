
* Saving data on pivot table
    ```php
    App\User::find(1)->roles()->save($role, ['expires' => $expires]);
    ```

* Updating data on pivot table 

    ```php
    App\User::find(1)->roles()->save($role, ['expires' => $expires]);
    ```

* Updating A Record On A Pivot Table `updateExistingPivot()`
    ```php
    $user = App\User::find(1);
    
    $user->roles()->updateExistingPivot($roleId, $attributes);
    ```

* Models:
    $touches
    $table
    $fillable
    $casts
    $primaryKey
    $keyType
    $incrementing
    $with
    $withCount
    $perPage

* dump queries
    ```php
    \DB::enableQueryLog();
    
    $usersWithLastPurchaseOrder = \App\User::with([
        'purchaseOrders' => function ($q) {
            $q->latest('date')->first();
        },
    ])->get();
    
    $query_dump = \DB::getQueryLog();
    
    dd($query_dump);
    ```


* Testing models relationships
    
* SubQuery `addSelect()` Laravel 6
    ```php
    DB::listen( function ($query) { dump($query->sql); } );
    
    App\User::addSelect(['latest_purchase_order' => function ($query) {
     $query->select('date')
       ->from('purchase_orders')
       ->whereColumn('user_id', 'users.id')
       ->limit(1)
       ->latest('date'); // oldest('date'))
    } 
      ])
      ->find(1);
    ```

* whereNull / whereNotNull / orWhereNull / orWhereNotNull
* whereColumn / orWhereColumn
* whereIn / whereNotIn / orWhereIn / orWhereNotIn
* whereNotBetween / orWhereNotBetween
  
  

