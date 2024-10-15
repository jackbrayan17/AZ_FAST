<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;

class ClientOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_client_can_place_an_order()
    {
        $client = User::factory()->create(['role' => 'client']);
        $this->actingAs($client);

        // Create a product to associate with the order
        $product = Product::factory()->create();

        $response = $this->post('/orders', [
            'product_id' => $product->id,
            'quantity' => 3,
            'sender_name' => 'John Doe',
            'sender_phone' => '123456789',
            'sender_town' => 'Town A',
            'sender_quarter' => 'Quarter A',
            'receiver_name' => 'Jane Doe',
            'receiver_phone' => '987654321',
            'receiver_town' => 'Town B',
            'receiver_quarter' => 'Quarter B',
            'category_id' => $product->category_id,
            'product_price' => $product->price,
            'payment' => 'credit card',
            'payment_number' => '4111111111111111',
            'merchant_id' => 1,  // Use a valid merchant ID if needed
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'user_id' => $client->id,
            'status' => 'pending'
        ]);
    }
}
