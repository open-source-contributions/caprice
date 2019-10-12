<?php

namespace Caprice;

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

use Caprice\Contracts\CompilerInterface;
use Caprice\Exception\DirNotFoundException;
use Caprice\Exception\FileNotFoundException;

class Compiler implements CompilerInterface
{
    /**
     * files directory.
     *
     * @var string
     */
    private $filesDir;

    /**
     * cache directory.
     *
     * @var string
     */
    private $cacheDir;

    /**
     * file to compile.
     *
     * @var string
     */
    private $file;


    public function __construct(string $filesDir, string $cacheDir)
    {
        if (!is_dir($filesDir)) {
            throw new DirNotFoundException("$filesDir is not a valid directory", 4);
        }
        if (!is_dir($cacheDir)) {
            throw new DirNotFoundException("$cacheDir is not a valid directory", 4);
        }

        $this->filesDir = rtrim(rtrim($filesDir, "\\"), "/") . DIRECTORY_SEPARATOR;
        $this->cacheDir = rtrim(rtrim($cacheDir, "\\"), "/") . DIRECTORY_SEPARATOR;
    }

    /**
     * compile caprice file method.
     *
     * @param string $file
     * @param string $cache
     *
     * @return string compiled file
     */
    public function compile(string $fileName) : string
    {
        $capFile = $this->filesDir . $fileName;

        if (!file_exists($capFile)) {
            throw new FileNotFoundException("file $capFile not found", 4);
        }

        //cache file
        $cacheFile = $this->cacheDir . md5($capFile).'.php';

        // create cache file if not exists to prevent filemtime check error
        if (!file_exists($cacheFile)) {
            touch($cacheFile);
        }

        if ($this->isModified($capFile, $cacheFile)) { // if modifed recompile
            // read caprice file
            $this->file = file_get_contents($capFile);

            // parse caprice file
            $parser = new Parser($this->filesDir);
            $this->file = $parser->parseFile($this->file);

            file_put_contents($cacheFile, $this->removeExtraLines($this->file));
            touch($capFile, time()); // update caprice time to be the same as cahed file to detect any changes later
        }

        return $cacheFile;
    }

    /**
     * check if caprice file eis modified.
     *
     * @param string $file
     * @param string $cached
     *
     * @return bool
     */
    public function isModified(string $file, string $cached) : bool
    {
        $template  = filemtime($file);
        $generated = @filemtime($cached); // just ignore and generate a file if no file exists

        return $template !== $generated;
    }

    /**
     * remove extra lines on a file.
     *
     * @param string $file
     *
     * @return void
     */
    public function removeExtraLines(string $file) : string
    {
        return preg_replace("~[\r\n]+~", "\r\n", trim($file)); //remove extra lines
    }
}
