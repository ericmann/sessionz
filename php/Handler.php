<?php
namespace EAMann\Sessionz;

abstract class Handler {
    /**
     * Action to be run when closing the current session.
     *
     * @param callable $next
     *
     * @return bool
     */
    abstract public function close($next);

    /**
     * Action to be run when destroying a session based on its ID.
     *
     * @param string   $id
     * @param callable $next
     *
     * @return bool
     */
    abstract public function destroy($id, $next);

    /**
     * Action to be run when cleaning up expired sessions.
     *
     * @param int      $maxlifetime
     * @param callable $next
     *
     * @return bool
     */
    abstract public function gc($maxlifetime, $next);

    /**
     * Action to be run when creating a new session.
     *
     * @param string   $path
     * @param string   $name
     * @param callable $next
     *
     * @return bool
     */
    abstract public function open($path, $name, $next);

    /**
     * Action to be run when reading session data from storage.
     *
     * @param string   $id
     * @param callable $next
     *
     * @return string
     */
    abstract public function read($id, $next);

    /**
     * Action to be run when writing session data to storage.
     *
     * @param string   $id
     * @param string   $data
     * @param callable $next
     *
     * @return bool
     */
    abstract public function write($id, $data, $next);
}