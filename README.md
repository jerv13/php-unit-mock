PhpUnitMock
===========

Base Class for creating reusable PHPUnit Mock Objects
- Allows for simple sharing of mocks (build them once)
- Allows simple array config for any mock return
- Mock can follow class structure of your project

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

#### Mock Setup ####

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
     * @override
     * Build PHPUnit Mock in this method
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|mixed
     */
    public function buildMock() 
    {
            /** @var \MyPackage\MyClass $mock */
            $mock = $this->getMockBuilder('\MyPackage\MyClass')
                ->disableOriginalConstructor()
                ->getMock();
    
            $mock->method('myMethod')
                ->will($this->returnValue($this->config['myMethod']));
                
            return $mock;
    }
}
```

#### Usage ####


```php
namespace MyPackage;

class MyClassTest extends \PHPUnit_Framework_TestCase 
{
    public function testMyMethod() 
    {
        // Default Mock - returns 'SOME_TEST_VALUE'
        $mock = MyClassMock::build();
        
        // Returns 'SOME_TEST_VALUE'
        $mock->myMethod();
        
        // Over-ride Mock return value
        $mock = MyClassMock::build(
            [
                'myMethod' => 'DIFFERENT_TEST_VALUE'
            ];
        );
        
        // Returns 'DIFFERENT_TEST_VALUE'
        $mock->myMethod();
    }
}

```

## ToDo ##

- Finish composer setup
