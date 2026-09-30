<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

/**
 * Yara's certifications and registrations (from the About page). Upload each certificate document
 * from Admin → Certifications to make it downloadable on /certifications.
 *
 * Idempotent: matched by title; uploaded files and admin edits to status/order are kept.
 *
 *   php artisan db:seed --class=CertificationSeeder
 */
class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $logo = fn (string $file) => "images/certifications/{$file}";

        $items = [
            ['BIS', 'Bureau of Indian Standards (BIS)', 'Bureau of Indian Standards', 'Products tested and certified to Indian safety standards.', 'shield-check', $logo('bis.png')],
            ['ISO 9001', 'ISO 9001:2015 Quality Management', 'International Organization for Standardization', 'Certified quality management processes.', 'badge-check', $logo('iso-9001.png')],
            ['ISO 14001', 'ISO 14001 Environmental Management', 'International Organization for Standardization', 'Responsible, environment-conscious manufacturing.', 'leaf', $logo('iso-14001.png')],
            ['ISO 27001', 'ISO 27001 Information Security', 'International Organization for Standardization', 'Secure handling of customer and business data.', 'lock', $logo('iso-27001.png')],
            ['BEE', 'BEE Model Approval', 'Bureau of Energy Efficiency, Ministry of Power', 'Energy-efficiency rated appliances.', 'zap', $logo('bee.png')],
            ['CE', 'CE Conformity', 'Conformité Européenne', 'Meets European health, safety and environmental norms.', 'badge-check', $logo('ce.png')],
            ['RoHS', 'RoHS Certificate of Compliance', 'RoHS Directive 2011/65/EU', 'Free from restricted hazardous substances.', 'leaf', $logo('rohs.png')],
            ['LMPC', 'Legal Metrology (LMPC) Registration', 'Legal Metrology Department', 'Registered for packaged commodities.', 'scale', $logo('lmpc.png')],
            ['MSME', 'Udyam (MSME) Registration', 'Ministry of MSME, Govt. of India', 'Recognised Indian micro, small & medium enterprise.', 'building-2', $logo('msme.png')],
            ['QRO', 'QRO Quality Certification', 'Quality Research Organization', 'Independently certified quality systems.', 'award', $logo('qro.png')],
            ['DPIIT', 'Startup India Recognition', 'DPIIT, Govt. of India', 'Recognised under the Startup India initiative.', 'rocket', null],
            ['CPCB', 'CPCB E-Waste (EPR) Registration', 'Central Pollution Control Board', 'Registered for responsible e-waste management.', 'recycle', null],
            ['Factory', 'Licence to Work a Factory', 'Directorate of Industrial Safety & Health, Govt. of Tamil Nadu', 'Our Coimbatore factory is licensed to operate.', 'factory', null],
            ['MCA', 'Certificate of Incorporation', 'Ministry of Corporate Affairs, Govt. of India', 'Registered company under the Companies Act.', 'landmark', null],
            ['LEI', 'LEI Certificate', 'Legal Entity Identifier · 894500BQCFJ437NZAR23', 'Globally recognised legal entity identifier.', 'globe', null],
        ];

        foreach ($items as $i => [$code, $title, $issuer, $description, $icon, $logoPath]) {
            $certification = Certification::firstOrNew(['title' => $title]);

            $certification->fill([
                'code' => $code,
                'issuer' => $issuer,
                'description' => $description,
                'icon' => $icon,
                'logo' => $certification->logo ?: $logoPath,
            ]);

            if (! $certification->exists) {
                $certification->sort_order = $i + 1;
                $certification->status = true;
            }

            $certification->save();
        }
    }
}
