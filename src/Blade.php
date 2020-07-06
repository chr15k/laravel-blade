<?php

namespace Chr15k\Blade;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class Blade
{
    /**
     * Array containing blade files.
     *
     * @var array
     */
    public $viewPaths;

    /**
     * Location of cached view files.
     *
     * @var string
     */
    public $cachePath;

    /**
     * @var Illuminate\Container\Container
     */
    protected $container;

    /**
     * Blade constructor.
     *
     * @param array  $viewPaths
     * @param string $cachePath
     */
    function __construct($viewPaths = [], $cachePath)
    {
        $this->container = new Container;

        $this->viewPaths = (array) $viewPaths;

        $this->cachePath = $cachePath;

        $this->registerFactory();

        $this->registerFilesystem();

        $this->registerEvents();

        $this->registerViewFinder();

        $this->registerBladeCompiler();

        $this->registerEngineResolver();
    }

    /**
     * @return Illuminate\View\Factory
     */
    public function view()
    {
        return $this->container['view'];
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        $this->container->bind('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $factory = $this->createFactory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $factory->setContainer($app);

            $factory->share('app', $app);

            return $factory;
        });
    }

    /**
     * Create a new Factory Instance.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @param  \Illuminate\View\ViewFinderInterface     $finder
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return \Illuminate\View\Factory
     */
    protected function createFactory($resolver, $finder, $events)
    {
        return new Factory($resolver, $finder, $events);
    }

    /**
     * Register the Filesystem implementation.
     *
     * @return void
     */
    public function registerFilesystem()
    {
        $this->container->singleton('files', function() {
            return new Filesystem;
        });
    }

    /**
     * Register the events instance.
     *
     * @return void
     */
    public function registerEvents()
    {
        $this->container->singleton('events', function() {
            return new Dispatcher;
        });
    }

    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    public function registerEngineResolver()
    {
        $this->container->singleton('view.engine.resolver', function($app) {
            $resolver = new EngineResolver;

            // Next, we will register the various view engines with the resolver so that the
            // environment will resolve the engines needed for various views based on the
            // extension of view file. We call a method for each of the view's engines.
            foreach (['php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            return $resolver;
        });
    }

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function() {
            return new PhpEngine;
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        $resolver->register('blade', function() {
            return new CompilerEngine($this->container['blade.compiler']);
        });
    }

    /**
     * Register the Blade compiler implementation.
     *
     * @return void
     */
    public function registerBladeCompiler()
    {
        $this->container->singleton('blade.compiler', function ($app) {
            return new BladeCompiler($app['files'], $this->cachePath);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->container->bind('view.finder', function ($app) {
            return new FileViewFinder($app['files'], $this->viewPaths);
        });
    }
}
