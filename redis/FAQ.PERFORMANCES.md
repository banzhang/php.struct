# Some frequently asked questions about the performances of Predis #
____________________________________________


### Predis is a pure-PHP implementation: it can not be fast enough! ###

It really depends, but most of the times the answer is: _yes, it is fast enough_. I will give you
a couple of easy numbers using a single Predis client with PHP 5.3.5 (custom build) and Redis 2.2
(localhost) under Ubuntu 11.04 (running on a Intel Q6600):

    19600 SET/sec using 12 bytes for both key and value
    18900 GET/sec while retrieving the very same values
    0.200 seconds to fetch 30000 keys using _KEYS *_.

How does it compare with a nice C-based extension such as [__phpredis__](http://github.com/nicolasff/phpredis)?

    30500 SET/sec using 12 bytes for both key and value
    31000 GET/sec while retrieving the very same values
    0.030 seconds to fetch 30000 keys using "KEYS *"".

Wow, __phpredis__ looks so much faster! Well we are comparing a C extension with a pure-PHP library so
lower numbers are quite expected, but there is a fundamental flaw in them: is this really how you are
going to use Redis in your application? Are you really going to send thousands of commands in a for-loop
for each page request using a single client instance? If so, well I guess you are probably doing something
wrong. Also, if you need to SET or GET multiple keys you should definitely use commands such as MSET and
MGET. You can also use pipelining to get more performances when this technique can be used.

There is one more thing. We have tested the overhead of Predis by connecting on a localhost instance of
Redis, but how these numbers change when we hit the network by connecting to instances of Redis that
reside on other servers?

    Using Predis:
    3600 SET/sec using 12 bytes for both key and value
    3600 GET/sec while retrieving the very same values
    0.210 seconds to fetch 30000 keys using "KEYS *".

    Using phpredis:
    4000 SET/sec using 12 bytes for both key and value
    4000 GET/sec while retrieving the very same values
    0.051 seconds to fetch 30000 keys using "KEYS *".

There you go, you get almost the same average numbers and the reason is quite simple: network latency
is a real performance killer and you cannot do (almost) anything about that. As a disclaimer, please
remember that we are measuring the overhead of client libraries implementations and the effects of the
network round-trip time, we are not really measuring how fast Redis is. Redis shines the best with
thousands of concurrent clients doing requests! Also, actual performances should be measured according
to how your application will use Redis.


### I am convinced, but performances for multi-bulk replies (e.g. _KEYS *_) are still worse ###

Fair enough, but there is actually an option for you if you need even more speed and it consists on
installing __[phpiredis](http://github.com/seppo0010/phpiredis)__ (note the additional _i_ in the
name) and let Predis using it. __phpiredis__ is a C-based extension that wraps __hiredis__ (the
official Redis C client library) with a thin layer that exposes its features to PHP. You will now
get the benefits of a faster protocol parser just by adding a single line of code in your application:

    $client = new Predis\Client('tcp://127.0.0.1', array(
        'connections' => array('tcp' => 'Predis\Network\PhpiredisConnection')
    ));

As simple as it is, nothing will really change in the way you use the library in your application. So,
how fast is it now? There are not much improvements for inline or short bulk replies (e.g. _SET_ or
_GET_), but the speed for parsing multi-bulk replies is now on par with phpredis:

    Using Predis with a phpiredis-based connection to fetch 30000 keys using _KEYS *_:

    0.031 seconds from a local Redis instance
    0.058 seconds from a remote Redis instance


### If I need to install a C extension to get better performances, why not using phpredis? ###

Good question. Generically speaking, if you need absolute uber-speed using localhost instances of Redis
and you do not care about abstractions built around some Redis features such as MULTI / EXEC, or if you
do not need any kind of extensibility or guaranteed backwards compatibility with different versions of
Redis (Predis currently supports from 1.2 up to 2.2, and even the current development version), then
using __phpredis__ can make sense for you. Otherwise, Predis is for you. Using __phpiredis__ gives you
a nice speed bump, but it is not mandatory.
