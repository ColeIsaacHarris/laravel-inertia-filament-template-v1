<?php

namespace Database\Factories;

use App\Enums\PaymentTerms;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'po_number' => fake()->unique()->bothify('PO-####'),
            'supplier_id' => Supplier::factory(),
            'currency' => 'USD',
            'payment_terms' => fake()->randomElement(PaymentTerms::cases())->value,
            'fob_cost_total_cents' => fake()->numberBetween(100000, 5000000),
            'freight_cost_total_cents' => fake()->numberBetween(10000, 500000),
        ];
    }
}
