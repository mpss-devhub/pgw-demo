<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_shoe_can_be_added_to_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();


        $response = $this
            ->actingAs($user)
            ->from('/home')
            ->post('/cart', [
                'product_id' => $product->id
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/home');
    }
    public function test_cart_item_removed_from_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $product->users()->attach($user->id, ['created_at' => now(), 'updated_at' => now()]);


        $response = $this
            ->actingAs($user)
            ->from('/home')
            ->delete('/cart', [
                'product_id' => $product->id
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/home');
    }
}
