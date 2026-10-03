<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Home page testimonials: real customer reviews of Yara Electronics (Peelamedu, Coimbatore),
 * quoted word for word from its public Justdial listing (checked 3 Oct 2026). Never invent or
 * reword a review here; add new ones from Admin → Testimonials as customers leave them.
 *
 * Also removes the placeholder testimonials ("test", "Sample Customer A/B") and their photos.
 * Idempotent: matched by name + message.
 *
 *   php artisan db:seed --class=TestimonialSeeder
 */
class TestimonialSeeder extends Seeder
{
    private const REVIEWS = [
        // name, star rating, review text (verbatim)
        ['Arul', 5, 'Super products good one to use'],
        ['Kavi', 5, 'High quality products'],
        ['Vivek', 4, 'All products are super'],
    ];

    public function run(): void
    {
        Testimonial::where(fn ($q) => $q->where('message', 'test')->orWhere('name', 'like', 'Sample Customer%'))
            ->get()
            ->each(function (Testimonial $placeholder) {
                if ($placeholder->photo) {
                    Storage::disk('public')->delete($placeholder->photo);
                }
                $placeholder->delete();
            });

        foreach (self::REVIEWS as $i => [$name, $rating, $message]) {
            Testimonial::updateOrCreate(
                ['name' => $name, 'message' => $message],
                ['designation' => 'Yara customer', 'company' => 'Review on Justdial', 'rating' => $rating, 'sort_order' => $i, 'status' => true]
            );
        }
    }
}
