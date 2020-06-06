

```php
use Illuminate\Support\Facades\Cache;

$uniqueCacheKey = 'combinationOfVariablesToMakeUniqueKey';
$seconds = 10;

$value = Cache::remember($uniqueCacheKey, $seconds, function () {
    return User::with('purchaseOrders')
        ->limit(2)
        ->get();
});
```
