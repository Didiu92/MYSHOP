<?php
namespace Database\Seeders;
use App\Models\Offer;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;
class OfferSeeder extends Seeder
{
 use LoadsMockData;
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
 $offers = $this->getOffers();
 foreach ($offers as $offer) {
 Offer::create($offer);
 }
 }
}