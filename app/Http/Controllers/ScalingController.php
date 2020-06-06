<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ScalingController extends Controller
{
    public function eagerLoading()
    {
        $users = User::with('country')->limit(30)->get();

        foreach ($users as $user) {
            $user->country->name;
        }

        return view('scaling.eagerLoading', compact('users'));
    }


    public function selectOnlyCloumnsYouNeed()
    {
        //with('user:id,name','category:id,name','tags:tags.id,name')
        // return 'Memory Usage: ' . round(xdebug_peak_memory_usage()/1048576, 2) . 'MB';
    }

    public function cachingQueryResult()
    {
        // Cache duration: seconds, hours, ... forever
        // CACHE_DRIVER: file, redis, memcached...

        $uniqueCacheKey = 'combinationOfVariablesToMakeUniqueKey';
        $seconds = 12;

        $value = Cache::remember($uniqueCacheKey, $seconds, function () {
            return User::with('purchaseOrders')
                ->limit(2)
                ->get();
        });

        return view('scaling.cachingQueryResult', compact('value'));
    }

    public function chunkingResult()
    {
        // By chunking, we use more queries but reduce memory usage => put this kind of queries in queues.
        // Kind of queries: could be used for reporting

        //return 'Memory Usage: ' . round(xdebug_peak_memory_usage()/1048576, 2) . 'MB';

    }

    public function benchmarkUsingAb()
    {
        // Using Apache Benchmark (https://www.sitepoint.com/stress-test-php-app-apachebench/)
        // Number of allowed simultaneous connexion:
        // sudo sysctl net.core.somaxconn
        // ab -n 500 -l -c 100 -k -H 'Accept-Encoding: gzip, deflate' http://laravel-relationships.test/scaling/caching-query-result
    }

    public function useIndexes()
    {
        // https://deliciousbrains.com/optimizing-laravel-database-indexing-performance/
    }

    public function useQueues()
    {

    }

    /**
     *
     * To enable xdebug on homestead:
     * https://laravel.com/docs/7.x/homestead#debugging-and-profiling
     * https://laracasts.com/discuss/channels/laravel/how-to-setup-xdebug-for-homestead-in-phpstrom?page=1
     * https://tecadmin.net/enable-disable-php-modules-ubuntu/
     */
}
