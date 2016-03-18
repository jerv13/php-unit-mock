PhpUnitMock
===========

Base Class for creating reusable PHPUnit Mock Objects
- Allows for simple sharing of mocks (build them once)
- Allows simple array config for any mock return
- Mocks can follow class structure of your project

```
    - src
    -- MyPackage
    --- MyClass
    - mocks
    -- MyPackage
    --- MyClass
```

## Example ##


#### Test Target ####

```php
namespace MyPackage;

class MyClass 
{
    public function myMethod() 
    {
        return 'someValue'
    }
}
```

#### Simple Mock Setup ####

Use this when your config is one-to-one with the mocks methods and results

```php
namespace MyPackage;

class MyClassMock extends \PhpUnitMock\Mock 
{
    /**
     * NameSpace and Name of the class to mock
     *
     * @var null
     */
    protected $className = '\MyPackage\MyClass';
    
    /**
     * Build the default mock configuration
     *
     * @return array
     */
    public function buildDefaultConfig()
    {
        return [
            'myMethod' => 'SOME_TEST_VALUE'
        ];
    }

    /**
     * @override to show proper type hinting in IDE
     * Build PHPUnit Mock in this method
     *
     * @return \MyPackage\MyClass
     */
    public function buildMock() 
    {
            return parent::buildMock();
    }
}
```

#### Custom Mock Setup ####

Use this when you require special cases for you mock results

```php
namespace MyPackage;

class MyClassMock extends \PhpUnitMock\Mock 
{
    /**
     * Build the default mock configuration
     *
     * @return array
     */
    public function buildDefaultConfig()
    {
        return [
            'myMethod' => 'SOME_TEST_VALUE'
        ];
    }

    /**
     * @override to show proper type hinting in IDE
     * Build PHPUnit Mock in this method
     *
     * @return \MyPackage\MyClass
     */
    public function buildMock() 
    {
            /** @var \MyPackage\MyClass $mock */
            $mock = $this->testCase->getMockBuilder('\MyPackage\MyClass')
                ->disableOriginalConstructor()
                ->getMock();
    
            $mock->method('myMethod')
                ->will($this->returnValue($this->config['myMethod']));
                
            // Custom mock building here
                
            return $mock;
    }
}
```

#### Simple Usage ####

```php
namespace MyPackage;

class MyClassTest extends \PHPUnit_Framework_TestCase 
{
    public function testMyMethod() 
    {
        // Default Mock with default config 
        $mock = MyClassMock::build($this);
        
        // Returns 'SOME_TEST_VALUE' from default config
        $mock->myMethod();
        
        // Over-ride Mock return value
        $mock = MyClassMock::build(
            $this,
            // Add local config, this will be merged with the default config
            [
                'myMethod' => 'DIFFERENT_TEST_VALUE'
            ];
        );
        
        // Returns 'DIFFERENT_TEST_VALUE' from local config
        $mock->myMethod();
    }
}
```

#### Usage with Type Hints in IDE ####

```php
namespace MyPackage;

class MyClassTest extends \PHPUnit_Framework_TestCase 
{
    public function testMyMethod() 
    {
        // Default Mock with default config 
        $mock = MyClassMock::get($this)->buildMock();
        
        // Returns 'SOME_TEST_VALUE' from default config
        $mock->myMethod();
        
        // Over-ride Mock return value
        $mock = MyClassMock::get(
            $this,
            // Add local config, this will be merged with the default config
            [
                'myMethod' => 'DIFFERENT_TEST_VALUE'
            ];
        )->buildMock();
        
        // Returns 'DIFFERENT_TEST_VALUE' from local config
        $mock->myMethod();
    }
}
```
