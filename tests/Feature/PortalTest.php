<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_landing_renders_active_catalog_content_and_public_navigation(): void
    {
        $category = Category::factory()->create(['name' => 'Calzado urbano']);
        $product = Product::factory()->for($category)->create(['name' => 'Bota Aurora']);
        Inventory::factory()->for($product)->create(['stock' => 5]);

        $response = $this->get(route('inicio'));

        $response
            ->assertOk()
            ->assertSeeText('Calzado para avanzar con confianza.')
            ->assertSeeText($category->name)
            ->assertSeeText($product->name)
            ->assertSee(route('catalogo.index'), false)
            ->assertSee(route('carrito.index'), false)
            ->assertSee(route('contacto.create'), false);
    }

    public function test_existing_ecommerce_entry_points_remain_accessible(): void
    {
        $this->get(route('catalogo.index'))->assertOk();
        $this->get(route('carrito.index'))->assertOk();

        $this->get(route('checkout.create'))
            ->assertRedirectToRoute('carrito.index');
    }
}
