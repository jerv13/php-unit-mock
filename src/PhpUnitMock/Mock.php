<?php

namespace PhpUnitMock;

/**
 * Class Mock
 *
 * PHP version 5
 *
 * @category  PHPUnit
 * @package   PhpUnitMock
 * @author    James Jervis <james@jervdesign.com>
 * @copyright 2015 JervDesign
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/jerv13
 */
abstract class Mock extends \PHPUnit_Framework_TestCase
{
    /**
     * Autoload flag
     * @var bool
     */
    protected static $autoloadComplete = false;

    /**
     * Factory method
     *
     * @param array $config Config values
     *
     * @return mixed
     */
    public static function build($config = [])
    {
        $class = get_called_class();
        $mock = new $class($config);

        return $mock->buildMock();
    }

    /**
     * Actual values for mock
     *
     * @var array
     */
    protected $config = [];

    /**
     * Construct with specific config values
     *
     * @param array $config Configs for over-riding default config
     */
    public function __construct($config = [])
    {
        $defaultConfig = $this->buildDefaultConfig();
        $this->config = array_merge($defaultConfig, $config);
    }

    /**
     * Build the default mock configuration
     * - Over-ride this in your mock class
     *
     * @return array
     */
    public function buildDefaultConfig()
    {
        return [];
    }

    /**
     * Build PHPUnit Mock in this method using $this->config for return values
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|mixed
     */
    abstract public function buildMock();
}
