<?php

namespace PhpUnitMock;

/**
 * Class Loader
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
class Loader
{
    /**
     * MAX_AUTOLOAD_DEPTH
     */
    const MAX_AUTOLOAD_DEPTH = 8;

    /**
     * load
     *
     * @param string $dir
     * @param int    $depth
     *
     * @return void
     */
    public static function load($dir = null, $depth = 0)
    {
        if ($depth > self::MAX_AUTOLOAD_DEPTH) {
            return;
        }

        $scan = glob("$dir/*");

        foreach ($scan as $path) {
            if (preg_match('/\Mock.php$/', $path)) {
                require_once($path);
            } elseif (is_dir($path)) {
                self::autoload($path, $depth + 1);
            }
        }
    }
}
