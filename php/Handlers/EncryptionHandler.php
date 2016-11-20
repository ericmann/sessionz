<?php
/**
 * Encryption Middleware
 *
 * Allow or sessions to be encrypted at rest by wrapping all reads/writes with
 * an openssl-powered layer of encryption. A passkey must be supplied when the
 * handler is instantiated and will be normalized and used for all data storage.
 *
 * @package Sessionz
 * @subpackage Handlers
 * @since 1.0.0
 */

namespace EAMann\Sessionz\Handlers;

/**
 * Extend the standard "noop" handler so that normal functionality for managing
 * sessions passes through unchanged to other layers in the stack. However, be sure
 * to intercept all reads/writes to transparently decrypt/encrypt data as it
 * passes between various storage handlers and the application itself.
 */
class EncryptionHandler extends NoopHandler  {

    private $key;

    public function __construct( $key )
    {
        $this->key = $key;
    }

    /**
     * Attempt to decrypt the ciphertext passed in given the key supplied by the
     * constructor.
     *
     * Code derived from examples available in the PHP documentation
     * @see http://php.net/manual/en/class.sessionhandler.php
     *
     * @param string $ciphertext
     *
     * @return string
     */
    protected function decrypt( $ciphertext )
    {
        $data = base64_decode($ciphertext);
        $salt = substr($data, 0, 16);
        $encrypted = substr($data, 16);

        // Regenerate the key and initialization vector given available data
        $rounds = 3;
        $data00 = $this->key . $salt;
        $hash = array();
        $hash[0] = hash('sha256', $data00, true);
        $result = $hash[0];
        for ($i = 1; $i < $rounds; $i++) {
            $hash[$i] = hash('sha256', $hash[$i - 1].$data00, true);
            $result .= $hash[$i];
        }
        $key = substr($result, 0, 32);
        $iv  = substr($result, 32,16);

        return openssl_decrypt($encrypted, 'AES-256-CBC', $key, true, $iv);
    }

    /**
     * Encrypt the plain text and return a ciphertext encrypted with the key supplied
     * by the constructor.
     *
     * Code derived from examples available in the PHP documentation
     * @see http://php.net/manual/en/class.sessionhandler.php
     *
     * @param string $plaintext
     *
     * @return string
     */
    protected function encrypt( $plaintext )
    {
        // Generate a random salt to be used in encryption
        $salt = openssl_random_pseudo_bytes(16);

        // Generate a uniform key and initialization vector from the supplied key
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = hash('sha256', $dx . $this->key . $salt, true);
            $salted .= $dx;
        }

        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);

        // Do the actual encryption
        $encrypted_data = openssl_encrypt($plaintext, 'AES-256-CBC', $key, true, $iv);

        return base64_encode($salt . $encrypted_data);
    }

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
        $encrypted = $next( $id );

        return empty( $encrypted ) ? $encrypted : $this->decrypt( $next( $id ) );
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
        $return = empty( $data ) ? $data : $this->encrypt( $data );
        return $next( $id, $return );
    }
}