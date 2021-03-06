<?php

namespace Caprice;

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

use Caprice\Contracts\CapriceInterface;

class Caprice implements CapriceInterface
{
    /**
     * caprice trait.
     */
    use CapriceTrait;

    /**
     * rules array.
     *
     * @var array
     */
    protected $rules;

    /**
     * parser.
     *
     * @var object
     */
    protected $parser;

    /**
     * compile from directory.
     *
     * @var string
     */
    protected $compileFromDir = './';

    /**
     * compile to directory.
     *
     * @var string
     */
    protected $compileToDir = './';

    /**
     * recompile mode.
     *
     * @var bool
     */
    protected $recompile = false;

    /**
     * set up.
     */
    public function __construct()
    {
        $this->rules = new CapriceRules();
        $this->parser = new RuleParser();
    }

    /**
     * add directive method.
     *
     * @param string $directive
     * @param mixed  $callback
     * @param bool   $custom
     *
     * @return CapriceRules
     */
    public function directive(string $directive, $callback, $custom = false): CapriceRules
    {
        return $this->rules->add($directive, $callback, $custom);
    }

    /**
     * compile cap file.
     *
     * @param string $filename
     *
     * @return string
     */
    public function compile(string $filename): string
    {
        defined('COMPILE_FROM') || define('COMPILE_FROM', $this->compileFromDir);
        defined('RE_COMPILE') || define('RE_COMPILE', $this->recompile);

        $compiler = new Compiler($this->parser, $this->rules);

        return $compiler->compile(
            $this->compileFromDir.dotPath($filename),
            $this->compileToDir
        );
    }
}
