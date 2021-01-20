<?php

namespace Tests\Unit;

/*
 * This file is a part of Caprice package
 *
 * @package     Caprice
 * @version     1.0.0
 * @author      Lotfio Lakehal <contact@lotfio.net>
 * @copyright   Lotfio Lakehal 2019
 * @license     MIT
 * @link        https://github.com/lotfio/caprice
 *
 */

use Caprice\CapriceRules;
use Caprice\Compiler;
use Caprice\Exception\CapriceException;
use Caprice\RuleParser;
use PHPUnit\Framework\TestCase;

class CompilerTest extends TestCase
{
    /**
     * compiler.
     *
     * @var object
     */
    protected $compiler;

    /**
     * set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $rules = new CapriceRules();
        $rules->add('#test', function () { return '<?php?>'; }, false);
        $this->compiler = new Compiler(new RuleParser(), $rules);
    }

    /**
     * compile no file.
     *
     * @return void
     */
    public function testCompileNoFile()
    {
        $this->expectException(CapriceException::class);
        $compiled = $this->compiler->compile('test.cap.php', '.');
    }

    /**
     * test compile.
     *
     * @return void
     */
    public function testCompileMethod()
    {
        $dir = dirname(__DIR__).'/stub/';

        $compiled = $this->compiler->compile($dir.'test.cap.php', $dir.'cache/');

        $this->assertSame($dir.'cache/'.sha1($dir.'test.cap.php').'.php', $compiled);

        $content = file_get_contents($compiled);
        $this->assertSame('<?php?>', $content);
    }
}
