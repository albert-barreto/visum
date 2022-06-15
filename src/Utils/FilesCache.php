<?php

namespace App\Utils;

use Doctrine\Common\Cache\SQLite3Cache;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\TagAwareAdapter;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\DoctrineAdapter;

class FilesCache implements Interfaces\CacheInterface
{
    public $cache;

    public function __construct()
    {
        // not working on free Heroku account:
        $this->cache =  new TagAwareAdapter(
         new FilesystemAdapter()
        );

        $provider = new SQLite3Cache(new \SQLite3(__DIR__ . '/cache/data.db'), 'TableName');

        $this->cache =  new TagAwareAdapter(

            new DoctrineAdapter(
            // a cache provider instance
                $provider,

                // a string prefixed to the keys of the items stored in this cache
                $namespace = '',

                // the default lifetime (in seconds) for cache items that do not define their
                // own lifetime, with a value 0 causing items to be stored indefinitely (i.e.
                // until the database table is truncated or its rows are otherwise deleted)
                $defaultLifetime = 0
            )
        );
    }
}
