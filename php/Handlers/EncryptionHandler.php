<?php
namespace EAMann\Sessionz\Handlers;

use EAMann\Sessionz\Handler;

class MemcacheHandler extends NoopHandler  {

    /**
     * Read all data from farther down the stack (i.e. earlier-added handlers)
     * and then decrypt the data given specified keys.
     *
     * @param string   $id   ID of the session to read
     * @param callable $next Callable to invoke the next layer in the stack
     *
     * @return string
     */
    public function read($id, $next)
    {
        // TODO: Implement read() method.
    }

    /**
     * Encrypt the incoming data payload, then pass it along to the next handler
     * in the stack.
     *
     * @param string   $id   ID of the session to write
     * @param string   $data Data to be written
     * @param callable $next Callable to invoke the next layer in the stack
     *
     * @return bool
     */
    public function write($id, $data, $next)
    {
        // TODO: Implement write() method.
    }
}