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
abstract class Mock
{
    /**
     * Test Case
     *
     * @var \PHPUnit_Framework_TestCase
     */
    protected $testCase;

    /**
     * Factory method
     *
     * @param \PHPUnit_Framework_TestCase $testCase Test Case
     * @param array                       $config   Config values
     *
     * @return mixed
     */
    public static function get(\PHPUnit_Framework_TestCase $testCase, $config = [])
    {
        $class = get_called_class();

        return new $class($testCase, $config);
    }

    /**
     * Mock Factory method
     *
     * @param \PHPUnit_Framework_TestCase $testCase Test Case
     * @param array                       $config   Config values
     *
     * @return mixed
     */
    public static function build(\PHPUnit_Framework_TestCase $testCase, $config = [])
    {
        $mock = static::get($testCase, $config);

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
     * @param \PHPUnit_Framework_TestCase $testCase Test Case
     * @param array                       $config   Configs for over-riding defaults
     */
    public function __construct(\PHPUnit_Framework_TestCase $testCase, $config = [])
    {
        $this->testCase = $testCase;
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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    abstract public function buildMock();
}
