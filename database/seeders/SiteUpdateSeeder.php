<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Runs every catalogue / content seeder in the order they depend on each other, for a deploy:
 *
 *   php artisan migrate --force
 *   php artisan db:seed --class=SiteUpdateSeeder --force
 *
 * 1. Product seeders (they create categories, products, explore-page art and reset specifications)
 * 2. Category art (runs after the products; Glass Displays after CategoryArtSeeder)
 * 3. Specs from the B2B catalogue and the specification sheets (after the product seeders)
 * 4. Catalogues, certifications, blog, testimonials and chatbot answers (product FAQs last, they read the specs)
 *
 * Every seeder here is idempotent, so this is safe to re-run.
 */
class SiteUpdateSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // 1. products
            ApplianceCatalogueSeeder::class,
            CentumSeeder::class,
            ChillerSeeder::class,
            TStandeeSeeder::class,
            AStandeeSeeder::class,
            CommercialDisplaySeeder::class,
            PrintingKioskSeeder::class,
            StandAloneKioskSeeder::class,
            TableTopStandeeSeeder::class,
            DigitalPodiumSeeder::class,
            DoubleSideVerticalDisplaySeeder::class,
            IndustrialDisplaySeeder::class,
            RotatableDisplaySeeder::class,
            InteractivePanelSeeder::class,
            LedWallSeeder::class,
            LcdVideoWallSeeder::class,
            HomeAudioSeeder::class,
            CommercialWasherSeeder::class,

            // 2. category art
            CategoryArtSeeder::class,
            GlassDisplaySeeder::class,

            // 3. specifications
            CatalogueSpecSeeder::class,
            SpecSheetSeeder::class,

            // 4. content and chatbot
            CatalogueSeeder::class,
            CertificationSeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            ChatbotFaqSeeder::class,
            ProductChatbotFaqSeeder::class,
        ]);
    }
}
