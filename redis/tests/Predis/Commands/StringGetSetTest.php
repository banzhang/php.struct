<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Commands;

use \PHPUnit_Framework_TestCase as StandardTestCase;

/**
 * @group commands
 * @group realm-string
 */
class StringGetSetTest extends CommandTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getExpectedCommand()
    {
        return 'Predis\Commands\StringGetSet';
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedId()
    {
        return 'GETSET';
    }

    /**
     * @group disconnected
     */
    public function testFilterArguments()
    {
        $arguments = array('key', 'value');
        $expected = array('key', 'value');

        $command = $this->getCommand();
        $command->setArguments($arguments);

        $this->assertSame($expected, $command->getArguments());
    }

    /**
     * @group disconnected
     */
    public function testParseResponse()
    {
        $this->assertSame('value', $this->getCommand()->parseResponse('value'));
    }

    /**
     * @group disconnected
     */
    public function testPrefixKeys()
    {
        $arguments = array('key', 'value');
        $expected = array('prefix:key', 'value');

        $command = $this->getCommandWithArgumentsArray($arguments);
        $command->prefixKeys('prefix:');

        $this->assertSame($expected, $command->getArguments());
    }

    /**
     * @group connected
     */
    public function testReturnsPreviousValueOfKey()
    {
        $redis = $this->getClient();

        $this->assertNull($redis->getset('foo', 'bar'));
        $this->assertSame('bar', $redis->getset('foo', 'barbar'));

        $redis->set('hoge', 'piyo');
        $this->assertSame('piyo', $redis->getset('hoge', 'piyopiyo'));
    }

    /**
     * @group connected
     * @expectedException Predis\ServerException
     * @expectedExceptionMessage ERR Operation against a key holding the wrong kind of value
     */
    public function testThrowsExceptionOnWrongType()
    {
        $redis = $this->getClient();

        $redis->lpush('metavars', 'foo');
        $redis->getset('metavars', 'foo');
    }
}
