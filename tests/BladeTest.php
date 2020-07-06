<?php

use Chr15k\Blade\Blade;
use PHPUnit\Framework\TestCase;

class BladeTest extends TestCase
{
    /**
     * Clear cached blade files before testing.
     */
    protected function setUp(): void
    {
        parent::setUp();

        foreach (glob(__DIR__ . '/cache/*.php') as $file) {
            unlink($file);
        }
    }

    public function testBladeCompiles()
    {
        $blade = new Blade(__DIR__ . '/views', __DIR__ . '/cache');
        $foo = 'bar';

        $output = $blade
            ->view()
            ->make('test', ['foo' => $foo])
            ->render();

        $this->assertContains($foo, [$output]);
    }
}