<?php
namespace EAMann\Sessionz\Handlers;

use EAMann\Sessionz\Handler;

class MemcacheHandler implements Handler {

    /**
     * @param string $id
     * @param callable $next
     * @return mixed
     */
    public function delete($id, $next)
    {
        // TODO: Implement destroy() method.
    }

    /**
     * @param int $maxlifetime
     * @param callable $next
     * @return mixed
     */
    public function clean($maxlifetime, $next)
    {
        // TODO: Implement gc() method.
    }

    /**
     * @param string $path
     * @param string $name
     * @param callable $next
     * @return mixed
     */
    public function create($path, $name, $next)
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