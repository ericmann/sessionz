<?php
/**
 * In-memory Session Handler
 *
 * Rather than storing session data in an external storage system, keep
 * track of things in an in-memory array within the application itself.
 *
 * @package Sessionz
 * @subpackage Handlers
 * @since 1.0.0
 */
namespace EAMann\Sessionz\Handlers;

use EAMann\Sessionz\Handler;

/**
 * Use an associative array to store session data so we can cut down on
 * round trips to an external storage mechanism (or just leverage an in-
 * memory cache for read performance).
 */
class MemoryHandler implements Handler {

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