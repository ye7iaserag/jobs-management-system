<?php

declare(strict_types=1);

namespace Tests\Unit\App;

use App\Console\Kernel;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Contracts\Events\Dispatcher;

final class KernelTest extends TestCase
{
    use WithFaker;

    function test_kernel_load_empty_array()
    {
        $kernel = new class($this->app, $this->app->make(Dispatcher::class)) extends Kernel {
            public function loadTest() {
                return $this->load([], false);
            }
        };

        $loaded = $kernel->loadTest();

        $this->assertNull($loaded);
    }

    
}
