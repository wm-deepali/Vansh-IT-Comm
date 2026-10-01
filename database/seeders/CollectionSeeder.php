<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Run AFTER ProductSeeder:
 *   $this->call([ProductSeeder::class, CollectionSeeder::class]);
 *
 * sort_order decides which badge wins when a product is in several collections
 * (lowest number = shown on the card).
 */
class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $defs = [
            [
                'name' => 'Hot Deal', 'slug' => 'hot-deal', 'color' => '#dc2626',
                'skus' => ['VIC-LAP-02', 'VIC-LAP-04', 'VIC-LAP-07', 'VIC-LAP-09', 'VIC-MOB-02', 'VIC-ACC-01', 'VIC-ACC-10'],
            ],
            [
                'name' => 'Best Seller', 'slug' => 'best-seller', 'color' => '#d97706',
                'skus' => ['VIC-LAP-01', 'VIC-LAP-03', 'VIC-MOB-01', 'VIC-MOB-05', 'VIC-ACC-02', 'VIC-ACC-09'],
            ],
            [
                'name' => 'New Arrival', 'slug' => 'new-arrival', 'color' => '#2563eb',
                'skus' => ['VIC-LAP-06', 'VIC-MOB-03', 'VIC-MOB-04', 'VIC-ACC-04', 'VIC-ACC-08'],
            ],
            [
                'name' => 'Budget Pick', 'slug' => 'budget-pick', 'color' => '#059669',
                'skus' => ['VIC-LAP-05', 'VIC-LAP-08', 'VIC-LAP-10', 'VIC-MOB-06', 'VIC-MOB-10', 'VIC-ACC-03'],
            ],
        ];

        foreach ($defs as $i => $def) {
            $collection = Collection::updateOrCreate(
                ['slug' => $def['slug']],
                $this->only([
                    'name'             => $def['name'],
                    'code'             => strtoupper($def['slug']),
                    'badge_color'      => $def['color'],
                    'meta_title'       => $def['name'] . ' | VANSH IT & COMM',
                    'meta_description' => 'Shop our ' . strtolower($def['name']) . ' collection of laptops, mobiles and accessories.',
                    'status'           => 1,
                    'sort_order'       => $i + 1,
                ])
            );

            $collection->products()->syncWithoutDetaching(
                Product::whereIn('sku', $def['skus'])->pluck('id')->all()
            );
        }
    }

    /** Keep only columns that exist, so the seeder never breaks on optional ones. */
    private function only(array $data): array
    {
        $table = (new Collection)->getTable();

        return array_filter(
            $data,
            fn ($v, $col) => Schema::hasColumn($table, $col),
            ARRAY_FILTER_USE_BOTH
        );
    }
}