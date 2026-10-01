<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class PageController extends Controller
{
    /**
     * Yara Centum 100" showcase page.
     */
    public function centum()
    {
        $product = Product::where('sku', 'YE-CENTUM-100')
            ->with(['images', 'features'])
            ->firstOrFail();

        return view('store.centum', compact('product'));
    }

    /**
     * Yara Chillers (chiller-based AC) showcase page.
     */
    public function chillers()
    {
        $product = Product::where('sku', 'YE-CHILLER-AC')
            ->with(['images', 'features', 'category'])
            ->firstOrFail();

        return view('store.chillers', compact('product'));
    }

    /**
     * Yara T-Standees explore page (Commercial Display Solutions).
     */
    public function tStandees()
    {
        $products = Product::where('sku', 'like', 'YE-TST-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        $category = Category::where('slug', 't-standees')->first();

        return view('store.t-standees', compact('products', 'category'));
    }

    /**
     * Yara A-Standees explore page (Commercial Display Solutions).
     */
    public function aStandees()
    {
        $products = Product::where('sku', 'like', 'YE-AST-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.a-standees', compact('products'));
    }

    /**
     * Yara Anti-Glare QLED TV explore page (65" – 100").
     */
    public function antiGlareTv()
    {
        $products = Product::whereIn('sku', Product::ANTI_GLARE_SKUS)
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->get()
            ->sortBy(fn ($p) => (int) ($p->specifications['Screen Size'] ?? 0))
            ->values();

        abort_if($products->isEmpty(), 404);

        return view('store.anti-glare-tv', compact('products'));
    }

    /**
     * Yara LED Video Walls explore page (P1.25 – P10, indoor, outdoor and rental).
     */
    public function ledVideoWalls()
    {
        // LED walls are sold on quote (like LCD walls): the products stay disabled in the shop,
        // and are used here only as the model range (pitch, brightness, photos). No prices or product links.
        $products = Product::where('sku', 'like', 'YE-LED-%')
            ->with(['primaryImage'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.led-video-walls', compact('products'));
    }

    /**
     * Yara LCD Video Walls explore page with the wall builder.
     */
    public function lcdVideoWalls()
    {
        // No fixed models: panels from 32" to 100" are configured per project on the page itself.
        return view('store.lcd-video-walls');
    }

    /**
     * Yara Home Audio explore page (twin tower, single tower, soundbar with subwoofer).
     */
    public function homeAudio()
    {
        $products = Product::where('sku', 'like', 'YE-HA-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.home-audio', compact('products'));
    }

    /**
     * Yara Commercial Displays explore page (32" – 86" digital signage).
     */
    public function commercialDisplays()
    {
        $products = Product::where('sku', 'like', 'YE-CD-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.commercial-displays', compact('products'));
    }

    /**
     * Yara Interactive Flat Panels explore page (55" – 98" / 100", education first).
     */
    public function interactivePanels()
    {
        $products = Product::where('sku', 'like', 'YE-IFP-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.interactive-panels', compact('products'));
    }

    /**
     * Yara Printing Kiosk explore page (Commercial Display Solutions).
     */
    public function printingKiosk()
    {
        $product = Product::where('sku', 'YE-KIOSK-215')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.printing-kiosk', compact('product'));
    }

    public function standAloneKiosk()
    {
        $products = Product::where('sku', 'like', 'YE-SAK-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.stand-alone-kiosk', compact('products'));
    }

    public function tableTopStandee()
    {
        $product = Product::where('sku', 'YE-TTS-10')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.table-top-standee', compact('product'));
    }

    /**
     * Yara Glass Displays explore page (Commercial Display Solutions).
     */
    public function glassDisplays()
    {
        $product = Product::where('sku', 'YE-GD-01')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.glass-displays', compact('product'));
    }

    /**
     * Yara Fully Automatic Commercial Washer explore page (SWQ-10 … SWQ-25).
     */
    public function commercialWashers()
    {
        $products = Product::where('sku', 'like', 'YE-CWM-%')
            ->where('status', true)
            ->with(['primaryImage', 'features'])
            ->orderBy('sort_order')
            ->get();

        abort_if($products->isEmpty(), 404);

        return view('store.commercial-washers', compact('products'));
    }

    /**
     * Yara 27" Touchscreen Digital Podium explore page (Commercial Display Solutions).
     */
    public function digitalPodium()
    {
        $product = Product::where('sku', 'YE-POD-27')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.digital-podium', compact('product'));
    }

    /**
     * Yara 43" Double Side Vertical Display explore page (Commercial Display Solutions).
     */
    public function doubleSideVerticalDisplay()
    {
        $product = Product::where('sku', 'YE-HD-43')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.double-side-vertical-display', compact('product'));
    }

    /**
     * Yara 8" Industrial Display explore page (Commercial Display Solutions).
     */
    public function industrialDisplays()
    {
        $product = Product::where('sku', 'YE-IND-08')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.industrial-displays', compact('product'));
    }

    /**
     * Yara 27" Rotatable Display explore page (Commercial Display Solutions).
     */
    public function rotatableDisplay()
    {
        $product = Product::where('sku', 'YE-RD-27')
            ->where('status', true)
            ->with(['features'])
            ->firstOrFail();

        return view('store.rotatable-display', compact('product'));
    }

    public function about()
    {
        // Product range cards on the About page use the live categories and their images.
        $categories = Category::active()
            ->topLevel()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('store.about', compact('categories'));
    }

    public function eWaste()
    {
        $collectionCentres = [
            ['state' => 'Delhi', 'location' => 'Raangpuri', 'address' => '198, G/F Malikpur Kohi, Next to hero honda Service Station, Rangpuri, Mahipalpur EXT. New Delhi, Delhi – 110037'],
            ['state' => 'Haryana', 'location' => 'Gurugram', 'address' => 'J-171, New Palam Vihar Phase-1, Gurgaon, Gurugram, Haryana 122017'],
            ['state' => 'Jharkhand', 'location' => 'Dhanbad', 'address' => 'Sardar Patel Nagar, Dhanbad, Jharkhand – 826004'],
            ['state' => 'Uttar Pradesh', 'location' => 'Noida', 'address' => 'BH-122, Sector -70, Noida, Uttar Pradesh 201301'],
            ['state' => 'Manipur', 'location' => 'Manipur', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Maharashtra', 'location' => 'Mumbai', 'address' => 'Plot-92, gala no.-01, Sector 19C Vashi Navi, Mumbai – 400705'],
            ['state' => 'Maharashtra', 'location' => 'Pune', 'address' => 'Plot No-24, Sec No-4, Shikshak Colony, Near Spine City, Moshi Pradhikaran, Pune – 412105'],
            ['state' => 'Odisha', 'location' => 'Cuttack', 'address' => '1st Floor Deltahouse, Rajendra Nagar, Madhupatna Cuttack, Bhubaneshwar'],
            ['state' => 'Manipur', 'location' => 'Manipur', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Telangana', 'location' => 'Hyderabad', 'address' => '4, Block-3, 4th Shatter at 179, MPR Estates near Old check post Old Bowaenpally Secunderabad, Hyderabad – 500011'],
            ['state' => 'Arunachal Pradesh', 'location' => 'Arunachal Pradesh', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Karnataka', 'location' => 'Bangalore', 'address' => 'No.43 1st Floor 2nd main D.D.U.T.T.L. Yeshwantpur, Bangalore – 560022'],
            ['state' => 'Karnataka', 'location' => 'Mangalore', 'address' => 'Opp. Hindustan Lever Ltd, Sulthan, Bhathery road Boloor Mangalore (KA) – 575003'],
            ['state' => 'Jharkhand', 'location' => 'Ranchi', 'address' => 'Ranchi, Jharkhand. # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Tamil Nadu', 'location' => 'Chennai', 'address' => '27, Sakthi Nagar Phase II, Sennerkuppam, Near Bisleri Water Plant, Chennai – 600056'],
            ['state' => 'Rajasthan', 'location' => 'Jaipur', 'address' => 'A-81, 200 ft. By Pass, Heerapura, Jaipur, Rajasthan – 302021'],
            ['state' => 'Sikkim', 'location' => 'Sikkim', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Odisha', 'location' => 'Bokaro', 'address' => '1st Floor Deltahouse, Rajendra Nagar, Madhupatna Cuttack, Bhubaneshwar'],
            ['state' => 'Assam', 'location' => 'Guwahati', 'address' => 'HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati – 781029'],
            ['state' => 'Tripura', 'location' => 'Tripura', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Uttar Pradesh', 'location' => 'Lucknow', 'address' => 'S-317, Transport Nagar, Behind RTO Office, Lucknow, Uttar Pradesh 226012'],
            ['state' => 'Madhya Pradesh', 'location' => 'Indore', 'address' => '284 AS-3 Scheme No – 78, Vijay Nagar, Indore, Madhya Pradesh'],
            ['state' => 'West Bengal', 'location' => 'Siliguri', 'address' => 'Siliguri, West Bengal. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Gujarat', 'location' => 'Ahmedabad', 'address' => 'Shop No D18, Pushp Penament, Behind Mony Hotel, Isanpur, Ahmedabad'],
            ['state' => 'Bihar', 'location' => 'Patna', 'address' => 'Dr. A.K Pandey (IPS), Malyanil Buddha Colony, Patna, Bihar – 800001'],
            ['state' => 'Nagaland', 'location' => 'Nagaland', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Meghalaya', 'location' => 'Shillong', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Mizoram', 'location' => 'Mizoram', 'address' => 'Zonal office: HN-34 Kundli Nagar Basistha Chariali, Near Parbhat Apartment, Guwahati-781029. Contact: Rajkumar Puniya 9810053907, info@packersmovers.com'],
            ['state' => 'Andhra Pradesh', 'location' => 'Vishakhapatnam', 'address' => 'Shop No.8, New Gajuwaka, Opp. High School Road, Vishakhapatnam, Andhra Pradesh – 530026'],
            ['state' => 'Punjab', 'location' => 'Chandigarh', 'address' => 'Shop No. 15 & 16, Pabhat Road, Opp. Tennis Academy, Zirakpur, Chandigarh, Punjab – 140603'],
            ['state' => 'West Bengal', 'location' => 'Kolkata', 'address' => '156A/73, Northern Park, B.T. Road, Dunlop, Kolkata – 700108'],
            ['state' => 'Jharkhand', 'location' => 'Jamshedpur', 'address' => 'Jamshedpur, Jharkhand. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Chhattisgarh', 'location' => 'Raipur', 'address' => 'Raipur, Chhattisgarh. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Odisha', 'location' => 'Bhubaneshwar', 'address' => 'Acharya Vihar-Jaydev Vihar Road, Bhubaneshwar, Odisha, India'],
            ['state' => 'Maharashtra', 'location' => 'Nagpur', 'address' => 'Nagpur, Maharashtra. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'West Bengal', 'location' => 'Asansol', 'address' => 'Shop No-4, Asansol Station Bus Stand Road, Munshi Bazar, Asansol, West Bengal 713301'],
            ['state' => 'Andhra Pradesh', 'location' => 'Secunderabad', 'address' => 'Shop No.4, Block-3, 4th Shatter at 179, MPR Estates, Near Old Check Post, Old Bowenpally, Secunderabad, Hyderabad – 500011'],
            ['state' => 'Goa', 'location' => 'Goa', 'address' => 'Goa. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Himachal Pradesh', 'location' => 'Dharamshala', 'address' => 'Dharamshala, Himachal Pradesh. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Jammu & Kashmir', 'location' => 'Jammu', 'address' => 'Jammu, Jammu & Kashmir. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Kerala', 'location' => 'Cochin', 'address' => 'Cochin, Kerala. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
            ['state' => 'Uttarakhand', 'location' => 'Rudrapur', 'address' => 'Rudrapur, Uttarakhand. Rajkumar Poonia # 9810053907, 9312377788, info@packersmovers.com'],
        ];

        return view('store.ewaste', compact('collectionCentres'));
    }

    public function terms()
    {
        return view('store.terms');
    }

    public function warranty()
    {
        return view('store.warranty');
    }

    public function privacy()
    {
        return view('store.privacy');
    }

    public function delivery()
    {
        return view('store.delivery');
    }

    public function contact()
    {
        return view('store.contact');
    }
}
