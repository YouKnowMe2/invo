<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => 'INVO'.rand(244,354534),
            'client_id' => Client::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'download_url' => 'https://picsum.photos/300?random='.rand(1,100)

        ];
    }
}
