<?php

namespace Database\Seeders;

use App\Models\ChatbotFaq;
use Illuminate\Database\Seeder;

/**
 * Starter "training" for the website chatbot, taken from the site's own pages
 * (contact, delivery, warranty, products). Edit or extend it from Admin → Chatbot.
 *
 * Idempotent: re-running updates entries with the same question.
 *
 * php artisan db:seed --class=ChatbotFaqSeeder
 */
class ChatbotFaqSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->faqs() as $i => $faq) {
            ChatbotFaq::updateOrCreate(
                ['question' => $faq['question']],
                [...$faq, 'status' => true, 'sort_order' => $i + 1],
            );
        }
    }

    private function faqs(): array
    {
        $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp');

        return [
            // --- Conversation ---------------------------------------------------------
            [
                'question' => 'Hi',
                'keywords' => 'hi, hello, hey, hii, hai, helo, good morning, good afternoon, good evening, vanakkam, namaste, anyone there',
                'answer' => "Hello! 👋 I'm the Yara Assistant.\n\nI can help you with our products and prices, delivery, warranty, booking a demo or a service call. What would you like to know?",
            ],
            [
                'question' => 'Thank you',
                'keywords' => 'thanks, thank you, thankyou, thx, tnx, ok thanks, great, super, nice, awesome, helpful',
                'answer' => "You're welcome! 😊 Is there anything else I can help you with?",
            ],
            [
                'question' => 'Bye',
                'keywords' => 'bye, goodbye, see you, tata, that is all, thats all, nothing else, no thanks',
                'answer' => 'Thanks for visiting Yara Electronics! Have a great day. Just open this chat again if you need anything.',
            ],

            // --- Products -------------------------------------------------------------
            [
                'question' => 'What products do you sell?',
                'keywords' => 'products, what do you sell, what you sell, product range, range, items, catalogue, catalog, brochure, all products, what are your products',
                'answer' => "Yara Electronics designs and manufactures display solutions and home appliances:\n\n• TVs from 24\" to 100\": Smart, Google TV, QLED, Mini QLED, Anti-Glare and Non-Smart\n• Interactive Flat Panels, 55\" to 100\"\n• LED Video Walls (indoor & outdoor) and LCD Video Walls\n• Commercial displays: T-Standees, A-Standees, kiosks, table top standees, glass displays and digital podiums\n• Air Conditioners (1, 1.5 & 2 ton) and chiller-based AC systems\n• Washing Machines: fully automatic, semi automatic, only washer and commercial washers\n• Home Audio: tower speakers and soundbars\n\nAsk me about any of them, e.g. \"65 inch interactive panel price\" or a model number like \"55SU23G\".",
                'button_text' => 'View Catalogue',
                'button_url' => '/catalogue',
                'show_as_suggestion' => true,
            ],
            [
                'question' => 'Tell me about interactive panels',
                'keywords' => 'interactive panel, interactive panels, interactive flat panel, ifp, smart board, smartboard, digital board, smart class, classroom display, teaching board, digital whiteboard',
                'answer' => "Our Interactive Flat Panels come in 55\", 65\", 75\", 85\" and 100\". All have:\n\n• 4K UHD display with 20-point multi-touch\n• Built-in Android 14 (8 GB RAM / 128 GB), no PC needed\n• Wireless screen sharing from laptops & phones\n• 4 mm anti-glare toughened glass\n• OPS slot for Windows / Linux\n• Built-in PhET science simulations\n\nThey're ideal for classrooms, meeting rooms and training halls.",
                'button_text' => 'See Interactive Panels',
                'button_url' => '/category/interactive-panels',
            ],
            [
                'question' => 'Tell me about LED video walls',
                'keywords' => 'led wall, led walls, video wall, led video wall, led screen, led display, outdoor display, stage screen, big screen, pixel pitch, p1.25, p1.53, p2.5',
                'answer' => "We make indoor and outdoor LED Video Walls for stages, lobbies, control rooms and advertising, from P1.25 fine pitch to P10 outdoor.\n\nEvery LED wall is measured and quoted for your space. Use our LED Wall Calculator to plan the size, resolution and module count, then request a quote and our team will send the full price with installation and support.",
                'button_text' => 'Open LED Wall Calculator',
                'button_url' => '/led-wall-calculator',
            ],
            [
                'question' => 'Do you sell TVs?',
                'keywords' => 'tv, tvs, television, televisions, smart tv, google tv, led tv, 4k tv, android tv',
                'answer' => 'Yes! We make LED, Smart and Google TVs in a range of sizes. Tell me the size you need (e.g. "43 inch TV") or browse the full range.',
                'button_text' => 'Browse Televisions',
                'button_url' => '/category/televisions',
            ],
            [
                'question' => 'Do you sell air conditioners?',
                'keywords' => 'ac, acs, air conditioner, air conditioners, aircon, split ac, inverter ac, ton ac, 1.5 ton, 1 ton, cooling',
                'answer' => 'Yes, we offer air conditioners for homes and offices. Browse the range to compare capacity and features, or ask me for a specific tonnage.',
                'button_text' => 'Browse Air Conditioners',
                'button_url' => '/category/air-conditioners',
            ],
            [
                'question' => 'Do you have chillers for commercial buildings?',
                'keywords' => 'chiller, chillers, chiller ac, chiller based ac, central ac, central air conditioning, hvac, cassette ac, cassette, commercial ac, mall ac, office ac, building cooling, vrf, ducted',
                'answer' => "Yes! Yara chiller-based AC systems cool malls, offices, showrooms and large spaces from one central plant, with ceiling cassette units in each area.\n\n• Up to 50% less power\n• Quick chill with steady temperature\n• Built for 24/7 commercial duty\n\nEvery system is designed for your site. Book a free site survey and our team will size it for you.",
                'button_text' => 'Explore Chillers',
                'button_url' => '/chillers',
            ],
            [
                'question' => 'Do you have digital standees?',
                'keywords' => 't standee, t-standee, standee, standees, digital standee, digital signage, signage, kiosk, totem, floor standing display, advertising display, menu display, directory display, commercial display',
                'answer' => "Yes! Yara T-Standees are floor-standing digital signage displays in 55\", 65\" and 75\", perfect for malls, fashion stores, car & bike showrooms and hotel lobbies.\n\n• Touch & non-touch options\n• Easy content updates\n• Custom branding\n\nPrices are on request. Tell us where it will stand and we'll recommend the right size.",
                'button_text' => 'Explore T-Standees',
                'button_url' => '/t-standees',
            ],
            [
                'question' => 'Do you have portable A-standees?',
                'keywords' => 'a standee, a-standee, a frame, a-frame, portable standee, portable display, digital poster, poster display, foldable display, easel display, sandwich board',
                'answer' => "Yes! Yara A-Standees are portable A-frame digital posters in 32\", 43\" and 55\". Fold them out at shop entrances, beauty counters, lobbies and events, and fold them away when you're done.\n\n• Portable & foldable\n• Update content in minutes\n• Custom branding\n\nPrices are on request.",
                'button_text' => 'Explore A-Standees',
                'button_url' => '/a-standees',
            ],
            [
                'question' => 'Do you have table top standees?',
                'keywords' => 'table top standee, tabletop standee, table top display, tabletop display, counter display, table display, 10 inch standee, 10 inch display, virtual try on, try-on, try on, jewellery display, jewelry display, digital menu, table menu, menu display',
                'answer' => "Yes! The Yara 10\" Table Top Standee is a compact portrait touchscreen for counters and tables.\n\n• Virtual jewellery try-on with the front camera\n• Digital menus & table ordering\n• Promotions at billing counters\n\nPerfect for jewellery stores, restaurants, retail counters and hotel receptions. Price on request.",
                'button_text' => 'Explore the Standee',
                'button_url' => '/table-top-standee',
            ],
            [
                'question' => 'Do you have stand alone touch kiosks?',
                'keywords' => 'kiosk, kiosks, stand alone kiosk, standalone kiosk, stand-alone kiosk, touch kiosk, touchscreen kiosk, touch screen kiosk, information kiosk, info kiosk, interactive kiosk, wayfinding, directory kiosk, mall directory, check-in kiosk, check in kiosk, visitor kiosk',
                'answer' => "Yes! Yara Stand Alone Kiosks are floor-standing touchscreen kiosks with a tilted display, in 32\", 43\" and 55\".\n\n• Mall wayfinding & store directories\n• Showroom product catalogues\n• Hotel & hospital self check-in\n• Visitor info in corporate lobbies\n\nNeed printing too? See our 21.5\" Printing Kiosk. Prices are on request.",
                'button_text' => 'Explore the Kiosk',
                'button_url' => '/stand-alone-kiosk',
            ],
            [
                'question' => 'Do you have self-order or printing kiosks?',
                'keywords' => 'printing kiosk, self order, self-order, self ordering, self service, self-service, billing kiosk, token, token printing, token machine, queue, receipt printer, ordering machine, restaurant kiosk, food court',
                'answer' => "Yes! The Yara 21.5\" Printing Kiosk lets customers browse, order and pay themselves, then prints the receipt or token instantly.\n\n• 21.5\" touchscreen\n• Built-in receipt & token printer\n• QR / barcode scanner\n\nPerfect for restaurants, food courts, retail billing and clinics. Price on request.",
                'button_text' => 'Explore the Kiosk',
                'button_url' => '/printing-kiosk',
            ],
            [
                'question' => 'Do you sell washing machines?',
                'keywords' => 'washing machine, washing machines, washer, fully automatic, semi automatic, top load, front load, laundry',
                'answer' => 'Yes, we manufacture fully automatic and semi-automatic washing machines. Browse the range to compare capacities.',
                'button_text' => 'Browse Washing Machines',
                'button_url' => '/category/washing-machine',
            ],
            [
                'question' => 'Which washing machine should I buy?',
                'keywords' => 'fully or semi, semi or fully, fully automatic vs semi automatic, semi automatic vs fully automatic, difference between fully and semi, top load or front load, front load or top load, top load vs front load, which washing machine, best washing machine, washing machine for family, what kg, how many kg',
                'answer' => "It depends on your home:\n\n• Fully automatic (6.5–10 kg): washes, rinses and spins by itself. Top load or front load. Best for convenience.\n• Semi automatic (7–11 kg): twin tub with separate wash and spin, uses less water and costs less.\n• Only washer (6.5 kg): compact wash-only unit for small homes.\n\nRough guide: 6.5–7 kg for 2–3 people, 8–9 kg for 4–5, 10 kg+ for large families.",
                'button_text' => 'Browse Washing Machines',
                'button_url' => '/category/washing-machine',
            ],
            [
                'question' => 'Do you have semi automatic washing machines?',
                'keywords' => 'semi automatic, semi-automatic, semiautomatic, twin tub, twin-tub, two tub, semi automatic washing machine',
                'answer' => 'Yes! Our semi automatic twin-tub washing machines come in 7, 8, 9, 10.2 and 11 kg, with separate wash and spin tubs, rust-proof bodies and knob timers. Prices start from ₹15,400.',
                'button_text' => 'See Semi Automatic',
                'button_url' => '/category/semi-automatic',
            ],
            [
                'question' => 'Do you have fully automatic washing machines?',
                'keywords' => 'fully automatic, fully-automatic, automatic washing machine, top load washing machine, front load washing machine, front loader, top loader, stainless steel drum',
                'answer' => 'Yes! Our fully automatic washing machines come in top load (6.5, 7.5, 8.5 and 10 kg) and front load (7 and 8 kg), with stainless steel drums and electronic controls. Prices start from ₹25,900.',
                'button_text' => 'See Fully Automatic',
                'button_url' => '/category/fully_automatic',
            ],
            [
                'question' => 'Do you have an only washer?',
                'keywords' => 'only washer, washer only, wash only, washing only, without dryer, no spin',
                'answer' => 'Yes, the Yara 6.5 kg Only Washer (Pink Flower) is a compact wash-only machine for small homes, with a rust-proof body, lint filter and soak / heavy / regular wash. Pair it with any spin dryer. Price ₹8,900.',
                'button_text' => 'See the Only Washer',
                'button_url' => '/category/only-washer',
            ],
            [
                'question' => 'Do you have commercial washing machines?',
                'keywords' => 'commercial washing machine, commercial washer, commercial washers, industrial washing machine, laundry machine, hotel laundry, hospital laundry, hostel laundry, 15 kg washer, 20 kg washer, 25 kg washer, heavy duty washer',
                'answer' => "Yes! Yara fully automatic commercial washers come in 10, 12, 15, 20 and 25 kg for hotels, hospitals, laundries, hostels and institutions.\n\n• Large stainless steel drum\n• Programmable computer control\n• 1150 rpm high-speed extraction\n• Optional coin operation\n\nPrices are on request.",
                'button_text' => 'Explore Commercial Washers',
                'button_url' => '/commercial-washing-machines',
            ],
            [
                'question' => 'Which AC tonnage do I need?',
                'keywords' => 'which ac, which tonnage, what tonnage, how many ton, ac for my room, room size, sq ft, square feet, sqft, ac size, 1 ton or 1.5 ton, 1.5 ton or 2 ton, bedroom ac, hall ac',
                'answer' => "A simple guide for Yara inverter split ACs:\n\n• 1 Ton: bedrooms and small rooms up to about 120 sq ft\n• 1.5 Ton: living rooms and bedrooms of 120–180 sq ft\n• 2 Ton: large halls and offices of 180–250 sq ft\n\nPick 5 star for the lowest power bills, 3 star for a lower price. All have 100% copper coils, R-32 gas and PM 2.5 filters.",
                'button_text' => 'Browse Air Conditioners',
                'button_url' => '/category/air-conditioners',
            ],
            [
                'question' => 'Do you have QLED TVs?',
                'keywords' => 'qled, qled tv, qled tvs, quantum dot, quantum dot tv',
                'answer' => 'Yes! Yara QLED TVs come in 32", 43", 50", 55", 65" and 85", with quantum-dot colour (over a billion colours) and Dolby Audio. The 55" and bigger models are 4K UHD Google TVs. Prices start from ₹29,900.',
                'button_text' => 'See QLED TVs',
                'button_url' => '/category/qled-tv',
            ],
            [
                'question' => 'Do you have Mini QLED TVs?',
                'keywords' => 'mini qled, mini-qled, miniqled, mini led, mini qled tv, flagship tv, best tv',
                'answer' => 'Yes! Our flagship Mini QLED Google TVs come in 75", 86" and 100": 4K UHD, up to 700 nits brightness, 10,000:1 contrast, Dolby Vision and a 20 W woofer. Prices start from ₹2,29,900.',
                'button_text' => 'See Mini QLED TVs',
                'button_url' => '/category/mini-qled-tv',
            ],
            [
                'question' => 'Do you have Google TVs?',
                'keywords' => 'google tv, google tvs, chromecast, google play, google assistant, voice search tv',
                'answer' => 'Yes! Yara Google TVs come in 32" HD, 43" Full HD and 55", 65", 75" 4K UHD, with Google Play, Chromecast built-in and a voice remote. Prices start from ₹29,900.',
                'button_text' => 'See Google TVs',
                'button_url' => '/category/google-tv',
            ],
            [
                'question' => 'Do you have anti-glare TVs?',
                'keywords' => 'anti glare, anti-glare, antiglare, matte screen, no reflection, reflection, sunlight tv, bright room tv',
                'answer' => 'Yes! Yara Anti-Glare QLED TVs have a matte, anti-reflective screen that stays clear even in bright, sunlit rooms. Available in 65", 75", 86" and 100" 4K UHD with Dolby Vision.',
                'button_text' => 'See Anti-Glare TVs',
                'button_url' => '/anti-glare-tv',
            ],
            [
                'question' => 'Do you have non-smart TVs?',
                'keywords' => 'non smart, non-smart, normal tv, basic tv, simple tv, led tv without internet, 24 inch tv',
                'answer' => 'Yes, our plug-and-play HD LED TVs come in 24" and 32", with HDMI and USB media playback. The 24" starts at ₹13,900.',
                'button_text' => 'See Non-Smart TVs',
                'button_url' => '/category/non-smart-tv',
            ],
            [
                'question' => 'Do you have a 100 inch TV?',
                'keywords' => '100 inch, 100 inch tv, centum, biggest tv, largest tv, big tv, huge tv, home theatre tv',
                'answer' => "Yes! Yara makes 100\" 4K TVs:\n\n• Yara Centum 100: 4K UHD Smart LED TV\n• 100\" Anti-Glare QLED Google TV\n• 100\" Mini QLED Google TV\n\nWe also make a 100\" Interactive Flat Panel for classrooms and boardrooms.",
                'button_text' => 'Discover Centum',
                'button_url' => '/centum',
            ],
            [
                'question' => 'Do you have LCD video walls?',
                'keywords' => 'lcd video wall, lcd wall, lcd video walls, narrow bezel, thin bezel, 0.88 mm, control room display, video wall panel',
                'answer' => 'Yes! Yara LCD video walls use 32" to 100" panels with ultra-narrow bezels from 3.5 mm down to 0.88 mm, Full HD per panel and 24/7 rating, for control rooms, retail, corporate lobbies and broadcast studios. Each wall is configured and quoted for your space.',
                'button_text' => 'Build Your Wall',
                'button_url' => '/lcd-video-walls',
            ],
            [
                'question' => 'Do you have commercial signage displays?',
                'keywords' => 'commercial display, commercial displays, signage display, menu board, digital menu board, 24/7 display, lobby display, wall mounted signage, advertising screen',
                'answer' => 'Yes! Yara Commercial Displays are slim 24/7 digital signage screens in 32", 43", 55", 65", 75" and 86", landscape or portrait, with a built-in Android media player for playlists and scheduling. Great for retail promotions, menu boards, lobbies and transit. Prices on request.',
                'button_text' => 'Explore Commercial Displays',
                'button_url' => '/commercial-displays',
            ],
            [
                'question' => 'Do you have glass displays?',
                'keywords' => 'glass display, glass displays, rugged display, scanner display, canteen display, touch display with scanner',
                'answer' => 'Yes! The Yara Glass Display is a rugged touch display with a sleek glass front and built-in scanner, designed for 24/7 use in offices, canteens, retail and commercial spaces. Size, glass, branding and housing can be customised. Price on request.',
                'button_text' => 'Explore Glass Displays',
                'button_url' => '/glass-displays',
            ],
            [
                'question' => 'Do you have a digital podium?',
                'keywords' => 'podium, digital podium, smart podium, lectern, smart lectern, auditorium podium, conference podium, speech podium',
                'answer' => "Yes! The Yara 27\" Touchscreen Digital Podium is an all-in-one podium for auditoriums, classrooms, boardrooms and events:\n\n• 27\" touchscreen (Android or Windows i5)\n• Two wireless gooseneck microphones\n• Electric height adjustment\n• 360° casters for easy moving\n\nPrice on request.",
                'button_text' => 'Explore the Podium',
                'button_url' => '/digital-podium',
            ],
            [
                'question' => 'Do you have a rotatable display?',
                'keywords' => 'rotatable display, rotating display, rotating screen, portable display, movable display, display on wheels, stand by me, standbyme, portrait landscape screen, battery display',
                'answer' => "Yes! The Yara 27\" Rotatable Display is a Full HD screen on a wheeled stand:\n\n• Rotates 90° either way, landscape to portrait\n• Tilts 20° front and back\n• Rolls anywhere on its wheeled base\n• 9600 mAh battery with Type-C charging\n• Google EDLA certified, 6GB + 128GB, 16MP camera\n\nAvailable in 27\" only. Price on request.",
                'button_text' => 'Explore the Display',
                'button_url' => '/rotatable-display',
            ],
            [
                'question' => 'Do you have industrial displays?',
                'keywords' => 'industrial display, industrial displays, panel pc, touch panel pc, hmi, industrial touch screen, machine display, factory display, automation display',
                'answer' => "Yes! The Yara 8\" Industrial Display is a compact, frameless metal-body Android touch panel for machines, factories and control points:\n\n• 8\" touch screen, Android 11\n• 4 × USB, HDMI, LAN and 4 Phoenix terminal connectors\n• 12V DC power, wall mount included\n\nAvailable in 8\" only. Price on request.",
                'button_text' => 'Explore Industrial Displays',
                'button_url' => '/industrial-displays',
            ],
            [
                'question' => 'Do you have a double side display?',
                'keywords' => 'double side display, double sided display, dual side display, two sided display, window display, shop window display, hanging display, ceiling display, vertical display',
                'answer' => "Yes! The Yara 43\" Double Side Vertical Display has a Full HD screen on each face, so people inside and outside your store both see your message:\n\n• Ultra-bright, sunlight-readable panel\n• Built for reliable 24/7 operation\n• Android with Wi-Fi, ready for remote content management\n• Hangs in a window or from the ceiling (rods and hooks included)\n\nAvailable in 43\" only. Price on request.",
                'button_text' => 'Explore the Display',
                'button_url' => '/double-side-vertical-display',
            ],
            [
                'question' => 'Do you sell speakers or soundbars?',
                'keywords' => 'speaker, speakers, soundbar, sound bar, soundbars, subwoofer, woofer, home audio, tower speaker, music system, bluetooth speaker, home theatre, party speaker',
                'answer' => "Yes! Yara Home Audio includes:\n\n• Twin Tower Multimedia Speakers\n• Single Tower Speakers with LED display\n• Soundbars with Subwoofer\n\nAll play over Bluetooth, USB and AUX with deep bass for music, movies and parties. Prices on request.",
                'button_text' => 'Explore Home Audio',
                'button_url' => '/home-audio',
            ],
            [
                'question' => 'What is the price?',
                'keywords' => 'price, prices, cost, rate, how much, pricing, price list, quotation, quote, offer, discount, best price, bulk price',
                'answer' => "Prices depend on the model and size. Tell me the product and size (e.g. \"75 inch interactive panel price\") and I'll show you the matching models.\n\nFor bulk or institutional orders, our sales team can send a quotation.",
                'button_text' => 'Request a Quote on WhatsApp',
                'button_url' => $whatsapp,
                'show_as_suggestion' => true,
            ],

            // --- Demo & service ----------------------------------------------------------
            [
                'question' => 'How do I book a demo?',
                'keywords' => 'demo, book demo, book a demo, demonstration, free demo, trial, see product, live demo, presentation',
                'answer' => "We'd love to show you our products in action! Fill in the short demo form and our team will contact you to schedule a demo at your school, office or our showroom.",
                'button_text' => 'Book a Free Demo',
                'button_url' => '/book-a-demo',
                'show_as_suggestion' => true,
            ],
            [
                'question' => 'How do I book a service call?',
                'keywords' => 'service, service call, repair, not working, complaint, problem, issue, technician, broken, fault, defect, support ticket, customer care, servicing',
                'answer' => "Sorry to hear you're having trouble. Book a service call online and our technician will get in touch. Please keep your invoice and product serial number handy.",
                'button_text' => 'Book a Service Call',
                'button_url' => 'https://erp.yaraelectronics.com/book-service-call',
            ],
            [
                'question' => 'Do you provide installation?',
                'keywords' => 'installation, install, installing, fitting, setup, set up, wall mount, mounting, bracket, stand, trolley',
                'answer' => 'Interactive panels come with a wall-mount bracket, and a mobile trolley stand is also available. For installation of your product, please contact our team with your location and they will guide you.',
                'button_text' => 'Ask on WhatsApp',
                'button_url' => $whatsapp,
            ],

            // --- Orders ------------------------------------------------------------------
            [
                'question' => 'How long does delivery take?',
                'keywords' => 'delivery, deliver, shipping, ship, dispatch, how long, when will i get, delivery time, courier, arrive',
                'answer' => "Delivery usually takes 7–10 business days from purchase (excluding national and public holidays). Remote areas may take a little longer.\n\nDelivery charges are included in the price, so there's nothing extra to pay.",
                'button_text' => 'Delivery & Returns',
                'button_url' => '/delivery-and-returns',
                'show_as_suggestion' => true,
            ],
            [
                'question' => 'Which areas do you deliver to?',
                'keywords' => 'deliver to, delivery area, pincode, pin code, my city, my area, location, deliver in, available in, international, outside india',
                'answer' => "We currently deliver within select cities in India, and to select pin codes within those cities. We don't deliver internationally.\n\nSend us your pin code on WhatsApp and we'll confirm.",
                'button_text' => 'Check on WhatsApp',
                'button_url' => $whatsapp,
            ],
            [
                'question' => 'What if my product arrives damaged?',
                'keywords' => 'damaged, damage, broken on arrival, return, returns, refund, replace, replacement, exchange, wrong product',
                'answer' => 'Please contact us right away with your order details and photos of the damage, and our team will help you. See our Delivery & Returns page for full details.',
                'button_text' => 'Delivery & Returns',
                'button_url' => '/delivery-and-returns',
            ],

            // --- Warranty ----------------------------------------------------------------
            [
                'question' => 'What is the warranty?',
                'keywords' => 'warranty, guarantee, guaranty, warranty period, how many years, years warranty, warranty claim, extended warranty',
                'answer' => "Yara products carry a manufacturer's warranty against manufacturing defects from the date of purchase. For example, LED TVs have 1 year (B Series) or 2 years (all other models) comprehensive warranty.\n\nA valid invoice with the serial number is needed to claim warranty.",
                'button_text' => 'Warranty Terms',
                'button_url' => '/warranty-terms',
                'show_as_suggestion' => true,
            ],

            // --- Contact -----------------------------------------------------------------
            [
                'question' => 'Talk to a person',
                'keywords' => 'human, agent, person, executive, representative, talk to someone, speak to someone, call me, contact sales, sales team, real person, customer support, whatsapp',
                'answer' => 'Sure! Our team is happy to help. Chat with us on WhatsApp or call +91 96777 12000.',
                'button_text' => 'Chat on WhatsApp',
                'button_url' => $whatsapp,
                'show_as_suggestion' => true,
            ],
            [
                'question' => 'What is your contact number?',
                'keywords' => 'contact, contact number, contact details, phone number, mobile number, your number, call you, email, mail id, email id, email address, reach you',
                'answer' => "You can reach us at:\n\n📞 +91 98420 88300\n📞 +91 96777 12000\n✉️ sales@yaraelectronics.com\n✉️ info@yaraelectronics.com",
                'button_text' => 'Contact Us',
                'button_url' => '/contact-us',
            ],
            [
                'question' => 'Where is your showroom?',
                'keywords' => 'address, location, showroom, office, where are you, where is, visit, directions, map, coimbatore, store near',
                'answer' => "Visit our showroom at:\n\nPVG Towers, Third Floor, 473 Avinashi Road, Peelamedu, Coimbatore – 641004, Tamil Nadu.\n\nOur team will walk you through the full range.",
                'button_text' => 'Get Directions',
                'button_url' => 'https://www.google.com/maps/dir/?api=1&destination=PVG+Towers%2C+473+Avinashi+Road%2C+Peelamedu%2C+Coimbatore%2C+Tamil+Nadu+641004',
            ],
            [
                'question' => 'About Yara Electronics',
                'keywords' => 'about, about you, who are you, company, yara, manufacturer, made in india, factory, brand, your company',
                'answer' => 'Yara Electronics Private Limited was founded in 2018. We are a Coimbatore-based manufacturer of display solutions and home appliances, including TVs from 24" to 100", interactive flat panels from 55" to 100", LED & LCD video walls, digital signage, ACs, washing machines and home audio, serving businesses, education, healthcare, retail and homes. Every product is built at Ceezet Electronics, our own factory in Coimbatore (since 2021).',
                'button_text' => 'About Us',
                'button_url' => '/about-us',
            ],
            [
                'question' => 'Do you have a catalogue?',
                'keywords' => 'catalogue, catalog, brochure, pdf, download, spec sheet, datasheet',
                'answer' => 'Yes! You can view and download our product catalogues online.',
                'button_text' => 'View Catalogue',
                'button_url' => '/catalogue',
            ],
        ];
    }
}
