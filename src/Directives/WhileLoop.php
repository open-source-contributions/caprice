<?php

namespace Caprice\Directives;

/*
 * This file is a part of Caprice package
 *
 * @package     Caprice
 * @version     0.1.0
 * @author      Lotfio Lakehal <contact@lotfio.net>
 * @copyright   Lotfio Lakehal 2019
 * @license     MIT
 * @link        https://github.com/lotfio/caprice
 *
 */

use Caprice\Contracts\DirectiveInterface;

class WhileLoop implements DirectiveInterface
{
    /**
     * pattern property.
     *
     * @var string
     */
    public $pattern = '/#while\s*\(([\$\w+\d+\s*\<\=\>\!]+)\)(.*?)#endwhile/s';

    /**
     * directive replace method
     *
     * @param  array  $match
     * @param  string $file original file
     * @return string
     */
    public function replace(array $match, string $file) : string
    {
        return '<?php while('.trim($match[1]).'):?>'.trim($match[2]).'<?php endwhile;?>';
    }
}
