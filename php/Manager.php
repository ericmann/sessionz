<?php
namespace EAMann\Sessionz;

use EAMann\Sessionz\Handlers\BaseHandler;

class Manager implements \SessionHandlerInterface {
    protected static $manager;

    /**
     * Session handler call stack
     *
     * @var \SplStack
     */
    protected $stack;

    /**
     * Handler stack lock
     *
     * @var bool
     */
    protected $handlerLock;

    public function __construct()
    {

    }

    /**
     * Add a handler to the stack.
     *
     * @param Handler $handler
     *
     * @return static
     */
    public function addHandler($handler)
    {
        if ($this->handlerLock) {
            throw new \RuntimeException('Session handlers can’t be added once the stack is dequeuing');
        }
        if (is_null($this->stack)) {
            $this->seedHandlerStack();
        }

        $next = $this->stack->top();
        $this->stack[] = function ($method, $args) use ($handler, $next) {
            array_push( $args, $next );
            return call_user_func_array( array( $handler, $method ), $args );
        };

        return $this;
    }

    /**
     * Seed handler stack with first callable
     *
     * @param callable $kernel The last item to run as a session handler
     *
     * @throws \RuntimeException if the stack is seeded more than once
     */
    protected function seedHandlerStack($kernel = null)
    {
        if (!is_null($this->stack)) {
            throw new \RuntimeException('HandlerStack can only be seeded once.');
        }
        if ($kernel === null) {
            $kernel = $this;
        }
        $this->stack = new \SplStack;
        $this->stack->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_KEEP);
        $this->stack[] = $kernel;

        $this->addHandler(new BaseHandler());
    }

    /**
     * Initialize the session manager.
     *
     * Invoking this function multiple times will reset the manager itself
     * and purge any handlers already registered with the system.
     *
     * @return Manager
     */
    public static function initialize()
    {
        $manager = self::$manager = new self();
        $manager->seedHandlerStack();

        session_set_save_handler($manager);

        return $manager;
    }

    /**
     * Generate a function that can invoke a specific action by name, automatically
     * passing in an array of arguments.
     *
     * @param string $action Action to invoke
     *
     * @return \Closure
     */
    protected function do_action( $action )
    {
        return function() use ($action) {
            if (is_null($this->stack)) {
                $this->seedHandlerStack();
            }

            /** @var callable $start */
            $start = $this->stack->top();
            $this->handlerLock = true;
            $data = $start($action, func_get_args());
            $this->handlerLock = false;
            return $data;
        };
    }

    /**
     * Close the current session.
     *
     * Will iterate through all handlers registered to the manager and
     * remove them from the stack. This has the effect of removing the
     * objects from scope and triggering their destructors. Any cleanup
     * should happen there.
     *
     * @return true
     */
    public function close()
    {
        $this->handlerLock = true;
        $this->stack->pop();
        $this->handlerLock = false;
        return true;
    }

    /**
     * Destroy a session by either invalidating it or forcibly removing
     * it from session storage.
     *
     * @param string $session_id ID of the session to destroy.
     *
     * @return bool
     */
    public function destroy($session_id)
    {
        return ($this->do_action('delete'))($session_id);
    }

    /**
     * Clean up any potentially expired sessions (sessions with an age
     * greater than the specified maximum-allowed lifetime).
     *
     * @param int $maxlifetime Max number of seconds for which a session is valid.
     *
     * @return bool
     */
    public function gc($maxlifetime)
    {
        return ($this->do_action('clean'))($maxlifetime);
    }

    /**
     * Create a new session storage.
     *
     * @param string $save_path File location/path where sessions should be written.
     * @param string $name      Unique name of the storage instance.
     *
     * @return bool
     */
    public function open($save_path, $name)
    {
        return ($this->do_action('create'))($save_path, $name);
    }

    /**
     * Read data from the specified session.
     *
     * @param string $session_id ID of the session to read.
     *
     * @return string
     */
    public function read($session_id)
    {
        return ($this->do_action('read'))($session_id);
    }

    /**
     * Write data to a specific session.
     *
     * @param string $session_id   ID of the session to write.
     * @param string $session_data Serialized string of session data.
     *
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        return ($this->do_action('write'))($session_id, $session_data);
    }
}