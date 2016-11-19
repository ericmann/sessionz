<?php
namespace EAMann\Sessionz\Handlers;

use EAMann\Sessionz\Handler;

class MemcacheHandler extends Handler {

    /**
     * Noop function for closing a session.
     *
     * @param callable $next
     *
     * @return bool
     */
    public function close($next)
    {
        return $next();
    }

    /**
     * Noop function for destroying a session.
     *
     * @param string   $id
     * @param callable $next
     *
     * @return bool
     */
    public function destroy($id, $next)
    {
        return $next( $id );
    }

    /**
     * Noop function for cleaning up expired sessions.
     *
     * @param int      $maxlifetime
     * @param callable $next
     *
     * @return bool
     */
    public function gc($maxlifetime, $next)
    {
        return $next( $maxlifetime );
    }

    /**
     * Noop function for creating a session.
     *
     * @param string   $path
     * @param string   $name
     * @param callable $next
     *
     * @return bool
     */
    public function open($path, $name, $next)
    {
        return $next( $path, $name );
    }

    public function read($id, $next)
    {
        // TODO: Implement read() method.
    }

    public function write($id, $data, $next)
    {
        // TODO: Implement write() method.
    }
}