<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\PubSub;

use \PHPUnit_Framework_TestCase as StandardTestCase;

use Predis\Client;
use Predis\Profiles\ServerProfile;

/**
 * @group realm-pubsub
 */
class DispatcherLoopTest extends StandardTestCase
{
    // ******************************************************************** //
    // ---- INTEGRATION TESTS --------------------------------------------- //
    // ******************************************************************** //

    /**
     * @group connected
     */
    public function testDispatcherLoopAgainstRedisServer()
    {
        $parameters = array(
            'host' => REDIS_SERVER_HOST,
            'port' => REDIS_SERVER_PORT,
            'database' => REDIS_SERVER_DBNUM,
            // Prevents suite from handing on broken test
            'read_write_timeout' => 2,
        );

        $producer = new Client($parameters, REDIS_SERVER_VERSION);
        $producer->connect();

        $consumer = new Client($parameters, REDIS_SERVER_VERSION);
        $consumer->connect();

        $dispatcher = new DispatcherLoop($consumer);

        $function01 = $this->getMock('stdClass', array('__invoke'));
        $function01->expects($this->exactly(2))
                   ->method('__invoke')
                   ->with($this->logicalOr(
                       $this->equalTo('01:argument'),
                       $this->equalTo('01:quit')
                   ))
                   ->will($this->returnCallback(function($arg) use($dispatcher) {
                       if ($arg === '01:quit') {
                           $dispatcher->stop();
                       }
                   }));

        $function02 = $this->getMock('stdClass', array('__invoke'));
        $function02->expects($this->once())
                   ->method('__invoke')
                   ->with('02:argument');

        $function03 = $this->getMock('stdClass', array('__invoke'));
        $function03->expects($this->never())
                   ->method('__invoke');

        $dispatcher->attachCallback('function:01', $function01);
        $dispatcher->attachCallback('function:02', $function02);
        $dispatcher->attachCallback('function:03', $function03);

        $producer->publish('function:01', '01:argument');
        $producer->publish('function:02', '02:argument');
        $producer->publish('function:01', '01:quit');

        $dispatcher->run();

        $this->assertTrue($consumer->ping());
    }
}
