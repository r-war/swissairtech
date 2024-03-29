<?php
/**
 * HTTP_Session2_Container_Memcache
 *
 * PHP Version 5
 *
 * @category HTTP
 * @package  HTTP_Session2
 * @author   Chad Wagner <chad.wagner@gmail.com>
 * @author   Torsten Roehr <torsten.roehr@gmx.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  CVS: $Id: Memcache.php,v 1.3 2008/02/17 13:05:36 till Exp $
 * @link     http://pear.php.net/package/HTTP_Session2
 */

require_once 'Container.php';

/**
 * HTTP/Session2/Exception.php
 */
require_once 'Exception.php';

/**
 * Memcache container for session data
 *
 * @category HTTP
 * @package  HTTP_Session2
 * @author   Chad Wagner <chad.wagner@gmail.com>
 * @author   Torsten Roehr <torsten.roehr@gmx.de>
 * @license  http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/HTTP_Session2
 * @since    Class available since Release 0.6.2
 */
class HTTP_Session2_Container_Memcache extends HTTP_Session2_Container
{
    /**
     * Memcache connection object
     *
     * @var object Memcache
     */
    private $mc;

    /**
     * Constructor method
     *
     * $options is an array with the options.<br>
     * The options are:
     * <ul>
     * <li>'memcache' - Memcache object
     * <li>'prefix'   - Key prefix, default is 'sessiondata:'</li>
     * </ul>
     *
     * @param array $options Options
     *
     * @return object
     */
    public function __construct($options)
    {
        parent::__construct($options);
    }

    /**
     * Connect by using the given DSN string
     *
     * @param object $mc Memcache object
     *
     * @return boolean
     * @throws HTTP_Session2_Exception
     */
    protected function connect($mc)
    {
        if ($mc instanceof Memcache) {
            $this->mc = $mc;
        } else {
            throw new HTTP_Session2_Exception(
                'The given memcache object was not valid in file '
                . __FILE__ . ' at line ' . __LINE__, 41);
        }

        return true;
    }

    /**
     * Set some default options
     *
     * @return void
     */
    protected function setDefaults()
    {
        $this->options['prefix']   = 'sessiondata:';
        $this->options['memcache'] = null;
    }

    /**
     * Establish connection to a database
     *
     * @param string $save_path    Save path
     * @param string $session_name Session name
     *
     * @return boolean
     */
    public function open($save_path, $session_name)
    {
        return $this->connect($this->options['memcache']);
    }

    /**
     * Free resources
     *
     * @return boolean
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data
     *
     * @param string $id Session id
     *
     * @return mixed
     */
    public function read($id)
    {
        return $this->mc->get($this->options['prefix'] . $id);
    }

    /**
     * Write session data
     *
     * @param string $id   Session id
     * @param mixed  $data Session data
     *
     * @return boolean
     */
    public function write($id, $data)
    {
        $this->mc->set($this->options['prefix'] . $id,
                       $data,
                       MEMCACHE_COMPRESSED,
                       time() + ini_get('session.gc_maxlifetime'));

        return true;
    }

    /**
     * Destroy session data
     *
     * @param string $id Session id
     *
     * @return boolean
     */
    public function destroy($id)
    {
        $this->mc->delete($this->options['prefix'] . $id);
        return true;
    }

    /**
     * Garbage collection
     *
     * @param int $maxlifetime Maximum lifetime
     *
     * @return boolean
     */
    public function gc($maxlifetime)
    {
        return true;
    }

    /**
     * Replicate session data to specified target
     *
     * @param string $target Target to replicate to
     * @param string $id     Id of record to replicate,
     *                       if not specified current session id will be used
     *
     * @return boolean
     */
    public function replicate($target, $id = null)
    {
        $msg  = 'The replicate feature is not available yet';
        $msg .= ' for the Memcache container.';

        throw new HTTP_Session2_Exception($msg);
    }
}
?>
