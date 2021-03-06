<?php

/**
 * Test: Nette\Caching\Storages\MemcachedStorage expiration test.
 *
 * @author     David Grudl
 * @package    Nette\Caching
 * @subpackage UnitTests
 */

use Nette\Caching\Storages\MemcachedStorage,
	Nette\Caching\Cache;



require __DIR__ . '/../bootstrap.php';



if (!MemcachedStorage::isAvailable()) {
	TestHelpers::skip('Requires PHP extension Memcache.');
}



$key = 'nette';
$value = 'rulez';

$cache = new Cache(new MemcachedStorage('localhost'));


// Writing cache...
$cache->save($key, $value, array(
	Cache::EXPIRATION => time() + 3,
));


// Sleeping 1 second
sleep(1);
Assert::true( isset($cache[$key]), 'Is cached?' );



// Sleeping 3 seconds
sleep(3);
Assert::false( isset($cache[$key]), 'Is cached?' );
