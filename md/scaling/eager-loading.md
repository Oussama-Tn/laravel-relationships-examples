
* You may use this package "Laravel N+1 Query Detector":
  * https://pociot.dev/1-finding-n1-queries-in-laravel

* Example:
    ```php
    // Get (30) users
    $users = User::limit(30)->get();

    foreach ($users as $user) {
        // access relationships with countries table
        $user->country->name;
    }
    // Result (30+1) queries !
    ```
    
    ```php
     // Get (30) users with 'country' relationship (defined on User model)
     $users = User::with('country')->limit(30)->get();

    foreach ($users as $user) {
        // access relationships with countries table
        $user->country->name;
    }
    // Result only (2) queries !!
    ```
    
* Check debugbar on this page to see all queries
