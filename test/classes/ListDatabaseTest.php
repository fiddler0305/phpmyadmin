<?php
/**
 * tests for ListDatabase class
 */
declare(strict_types=1);

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\ListDatabase;
use ReflectionClass;

/**
 * tests for ListDatabase class
 */
class ListDatabaseTest extends PmaTestCase
{
    /**
     * ListDatabase instance
     *
     * @var ListDatabase
     */
    private $object;

    /**
     * SetUp for test cases
     *
     * @return void
     */
    protected function setUp(): void
    {
        $GLOBALS['server'] = 1;
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['Server']['only_db'] = ['single\\_db'];
        $this->object = new ListDatabase();
    }

    /**
     * Call protected functions by setting visibility to public.
     *
     * @param string $name   method name
     * @param array  $params parameters for the invocation
     *
     * @return mixed the output from the protected method.
     */
    private function _callProtectedFunction($name, $params)
    {
        $class = new ReflectionClass(ListDatabase::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($this->object, $params);
    }

    /**
     * Test for ListDatabase::getEmpty
     *
     * @return void
     */
    public function testEmpty()
    {
        $arr = new ListDatabase();
        $this->assertEquals('', $arr->getEmpty());
    }

    /**
     * Test for ListDatabase::exists
     *
     * @return void
     */
    public function testExists()
    {
        $arr = new ListDatabase();
        $this->assertEquals(true, $arr->exists('single_db'));
    }

    /**
     * Test for ListDatabase::getHtmlOptions
     *
     * @return void
     */
    public function testHtmlOptions()
    {
        $arr = new ListDatabase();
        $this->assertEquals(
            '<option value="single_db">single_db</option>' . "\n",
            $arr->getHtmlOptions()
        );
    }

    /**
     * Test for checkHideDatabase
     *
     * @return void
     */
    public function testCheckHideDatabase()
    {
        $GLOBALS['cfg']['Server']['hide_db'] = 'single\\_db';
        $this->assertEquals(
            $this->_callProtectedFunction(
                'checkHideDatabase',
                []
            ),
            ''
        );
    }

    /**
     * Test for getDefault
     *
     * @return void
     */
    public function testGetDefault()
    {
        $GLOBALS['db'] = '';
        $this->assertEquals(
            $this->object->getDefault(),
            ''
        );

        $GLOBALS['db'] = 'mysql';
        $this->assertEquals(
            $this->object->getDefault(),
            'mysql'
        );
    }
}
