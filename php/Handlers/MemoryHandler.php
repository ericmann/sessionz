<?php
namespace EAMann\Sessionz\Handlers;

use EAMann\Sessionz\Handler;

class MemoryHandler extends Handler {

    /**
     * @param callable $next
     * @return mixed
     */
    public function close($next)
    {
        // TODO: Implement close() method.
    }

    /**
     * @param string $id
     * @param callable $next
     * @return mixed
     */
    public function destroy($id, $next)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param int $maxlifetime
     * @param callable $next
     * @return mixed
     */
    public function gc($maxlifetime, $next)
    {
        // TODO: Implement gc() method.
    }

    /**
     * @param string $path
     * @param string $name
     * @param callable $next
     * @return mixed
     */
    public function open($path, $name, $next)
    {
        // TODO: Implement open() method.
    }

    /**
     * @param string $id
     * @param callable $next
     * @return mixed
     */
    public function read($id, $next)
    {
        // TODO: Implement read() method.
    }

    /**
     * @param string $id
     * @param string $data
     * @param callable $next
     * @return mixed
     */
    public function write($id, $data, $next)
    {
        // TODO: Implement write() method.
    }
}