<?php

namespace Caprice\Directives;

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

use Caprice\Contracts\DirectiveInterface;

class ForDirective implements DirectiveInterface
{
    /**
     * replace.
     *
     * @param string $expression
     *
     * @return string
     */
    public function replace(string $expression, ?string $file = null): string
    {
        if (preg_match('/\(((.*)(in)(.*))\)/', $expression, $match)) {
            return '<?php foreach('.$match[4].' as '.$match[2].'):?>';
        }

        return '<?php for'.$expression.':?>';
    }
}
