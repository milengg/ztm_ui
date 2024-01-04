<?php

namespace App\View;

/**
 * Blade compiler
 * Fixes bug with empty compiled views
 */
class BladeCompiler extends \Illuminate\View\Compilers\BladeCompiler
{
    /**
     * Determine if the view at the given path is expired.
     *
     * @param  string  $path
     * @return bool
     */
    public function isExpired($path)
    {
        if(! $this->shouldCache)
        {
            return true;
        }

        $compiled = $this->getCompiledPath($path);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if(!$this->files->exists($compiled))
        {
            return true;
        }

        //Bug fix - empty compiled views
        if($this->files->size($compiled) == 0)
        {
            return true;
        }

        return $this->files->lastModified($path) >=
               $this->files->lastModified($compiled);
    }
}
