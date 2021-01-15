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

use Caprice\Exception\CapriceException;

trait CapriceTrait
{
    /**
     * set compile locations.
     *
     * @param string $compileFromDir
     * @param string $compileToDir
     *
     * @return Caprice
     */
    public function setCompileLocations(string $compileFromDir, string $compileToDir): self
    {
        if (!is_dir($compileFromDir) || !is_writable($compileFromDir)) {
            throw new CapriceException("input location $compileFromDir is not a valid writable directory.");
        }
        if (!is_dir($compileToDir) || !is_writable($compileToDir)) {
            throw new CapriceException("input location $compileToDir is not a valid writable directory.");
        }
        $this->compileFromDir = rtrim($compileFromDir, '/').'/';
        $this->compileToDir = rtrim($compileToDir, '/').'/';

        return $this;
    }

    /**
     * load predefined directives.
     *
     * @return Caprice
     */
    public function loadPredefinedDirectives(): self
    {
        $caprice = $this;
        require_once 'rules.php';

        return $this;
    }

    /**
     * enable recompile.
     *
     * @return Caprice
     */
    public function enableRecompile(): self
    {
        $this->recompile = true;

        return $this;
    }
}
