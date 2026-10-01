<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_root_renders_public_portal(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSeeText('Calzado para avanzar con confianza.');
    }
}
