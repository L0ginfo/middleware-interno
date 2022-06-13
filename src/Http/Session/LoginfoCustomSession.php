<?php
namespace App\Http\Session;

use App\Util\DeviceDetectUtil;
use Cake\Http\Session\DatabaseSession;

use Cake\ORM\Entity;
use Cake\ORM\Locator\LocatorAwareTrait;

class LoginfoCustomSession extends DatabaseSession
{
    use LocatorAwareTrait;

    /**
     * Reference to the table handling the session data
     *
     * @var \Cake\ORM\Table
     */
    protected $_table;

    /**
     * Number of seconds to mark the session as expired
     *
     * @var int
     */
    protected $_timeout;

    /**
     * Constructor. Looks at Session configuration information and
     * sets up the session model.
     *
     * @param array $config The configuration for this engine. It requires the 'model'
     * key to be present corresponding to the Table to use for managing the sessions.
     */
    public function __construct(array $config = [])
    {
        if (isset($config['tableLocator'])) {
            $this->setTableLocator($config['tableLocator']);
        }
        $tableLocator = $this->getTableLocator();

        if (empty($config['model'])) {
            $config = $tableLocator->exists('Sessions') ? [] : ['table' => 'sessions'];
            $this->_table = $tableLocator->get('Sessions', $config);
        } else {
            $this->_table = $tableLocator->get($config['model']);
        }

        $this->_timeout = (int)ini_get('session.gc_maxlifetime');
    }

    /**
     * Set the timeout value for sessions.
     *
     * Primarily used in testing.
     *
     * @param int $timeout The timeout duration.
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;

        return $this;
    }

    /**
     * Method called on open of a database session.
     *
     * @param string $savePath The path where to store/retrieve the session.
     * @param string $name The session name.
     * @return bool Success
     */
    public function open($savePath, $name)
    {
        return true;
    }

    /**
     * Method called on close of a database session.
     *
     * @return bool Success
     */
    public function close()
    {
        return true;
    }

    /**
     * Method used to read from a database session.
     *
     * @param string|int $id ID that uniquely identifies session in database.
     * @return string Session data or empty string if it does not exist.
     */
    public function read($id)
    {
        $result = $this->_table
            ->find('all')
            ->select(['data'])
            ->where([$this->_table->getPrimaryKey() => $id])
            ->disableHydration()
            ->first();
            
        if (empty($result)) {
            return '';
        }

        if (is_string($result['data'])) {
            return $result['data'];
        }

        $session = stream_get_contents($result['data']);

        if ($session === false) {
            return '';
        }

        return $session;
    }

    /**
     * Helper function called on write for database sessions.
     *
     * @param string|int $id ID that uniquely identifies session in database.
     * @param mixed $data The data to be saved.
     * @return bool True for successful write, false otherwise.
     */
    public function write($id, $data)
    {
        if (!$id) {
            return false;
        }
        $expires = time() + $this->_timeout;
        $record = compact('data', 'expires');
        $record[$this->_table->getPrimaryKey()] = $id;

        $record['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];
        $record['external_ip'] = @$_SERVER['REMOTE_ADDR'];
        $record['usuario_id'] = @$_SESSION['Auth']['User']['id'];
        $record['id_token_hashed'] = sha1($id);

        $result = $this->_table->save(new Entity($record));

        // Limpa as sessões expiradas
        $this->gc(0);

        return (bool)$result;
    }

    /**
     * Method called on the destruction of a database session.
     * 
     * O $this é do Controller, exemplo de call: $this->getRequest()->getSession()->destroy()
     * 
     * @param string|int $id ID that uniquely identifies session in database.
     * @return bool True for successful delete, false otherwise.
     */
    public function destroy($id)
    {
        $this->_table->delete(new Entity(
            [$this->_table->getPrimaryKey() => $id],
            ['markNew' => false]
        ));

        return true;
    }

    /**
     * Helper function called on gc for database sessions.
     *
     * @param int $maxlifetime Sessions that have not updated for the last maxlifetime seconds will be removed.
     * @return bool True on success, false on failure.
     */
    public function gc($maxlifetime)
    {
        $this->_table->deleteAll(['expires <' => time()]);

        return true;
    }
}
