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
     * NameSpace and Name of the class to mock
     *
     * @var null
     */
    protected $className = null;
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
     * Over-ride this for custom mock building
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @throws \Exception
     */
    public function buildMock()
    {
        if (empty($this->className)) {
            throw new \Exception('Class name is required for default buildMock');
        }
        $config = $this->config;
        $mock = $this->testCase->getMockBuilder($this->className)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($config as $key => $returnValue) {
            $mock->method($key)
                ->will($this->testCase->returnValue($returnValue));
        }

        return $mock;
    }
}
