<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    /** @test */
    public function it_calculates_total_order_cost()
    {
        $order = Order::factory()->create(['price' => 5000, 'quantity' => 2]);
        $this->assertEquals(10000, $order->totalCost());
    }
}

