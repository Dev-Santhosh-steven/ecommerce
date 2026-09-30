<?php

namespace App\Services\Search;

/**
 * The words people actually type, mapped to what the catalogue calls things.
 *
 * Edit here to teach the search new words: a synonym, a room, a use, a product type.
 */
final class Vocabulary
{
    /** Words that carry no meaning for search. */
    public const STOP_WORDS = [
        'a', 'an', 'the', 'is', 'are', 'am', 'was', 'be', 'to', 'of', 'in', 'on', 'for', 'and', 'or', 'with', 'from',
        'i', 'me', 'my', 'we', 'our', 'you', 'your', 'it', 'its', 'this', 'that', 'these', 'those', 'do', 'does', 'did',
        'can', 'could', 'would', 'should', 'will', 'please', 'pls', 'plz', 'want', 'wanted', 'need', 'needed', 'looking',
        'look', 'search', 'searching', 'find', 'show', 'give', 'get', 'buy', 'purchase', 'some', 'any', 'all', 'which',
        'what', 'whats', 'how', 'where', 'there', 'have', 'has', 'had', 'like', 'good', 'nice', 'suggest', 'recommend',
        'option', 'options', 'product', 'products', 'item', 'items', 'one', 'ones', 'model', 'models', 'yara', 'at',
        'by', 'about', 'tell', 'know', 'also', 'just', 'only', 'very', 'really', 'something', 'thing', 'things', 'kind',
        'type', 'types', 'sir', 'madam', 'hi', 'hello', 'price', 'prices', 'priced', 'cost', 'costs', 'rate', 'rs',
        'rupees', 'rupee', 'inr', 'budget', 'range', 'online', 'available', 'sale', 'offer', 'offers', 'deal', 'deals',
        'home', 'house', 'use', 'using', 'used', 'which', 'new', 'latest',
    ];

    /**
     * Product types: phrase → category slugs (a parent slug includes its sub-categories).
     * Longer phrases are matched first.
     */
    public const PRODUCT_TYPES = [
        // televisions
        'television' => ['televisions'], 'televisions' => ['televisions'], 'tv' => ['televisions'], 'tvs' => ['televisions'],
        'telly' => ['televisions'], 'tele' => ['televisions'], 'led tv' => ['televisions'], 'lcd tv' => ['televisions'],
        'smart tv' => ['televisions'], 'android tv' => ['televisions'], 'google tv' => ['televisions'],
        'qled' => ['televisions'], 'mini qled' => ['mini-qled-tv'], 'oled' => ['televisions'],
        // air conditioners
        'ac' => ['air-conditioners'], 'acs' => ['air-conditioners'], 'air conditioner' => ['air-conditioners'],
        'air conditioners' => ['air-conditioners'], 'airconditioner' => ['air-conditioners'], 'aircon' => ['air-conditioners'],
        'air conditioning' => ['air-conditioners'], 'split ac' => ['air-conditioners'], 'inverter ac' => ['air-conditioners'],
        'cooler' => ['air-conditioners'], 'ac machine' => ['air-conditioners'],
        'chiller' => ['chillers'], 'chillers' => ['chillers'], 'central ac' => ['chillers'], 'hvac' => ['chillers'],
        'cassette ac' => ['chillers'], 'central air conditioning' => ['chillers'],
        // washing machines
        'washing machine' => ['washing-machine'], 'washing machines' => ['washing-machine'], 'washer' => ['washing-machine'],
        'washers' => ['washing-machine'], 'washing' => ['washing-machine'], 'wm' => ['washing-machine'],
        'laundry' => ['washing-machine'], 'cloth washer' => ['washing-machine'], 'clothes washer' => ['washing-machine'],
        'dryer' => ['washing-machine'], 'spin dryer' => ['washing-machine'],
        'only washer' => ['only-washer'], 'washer only' => ['only-washer'],
        'commercial washer' => ['commercial-washing-machine'], 'commercial washing machine' => ['commercial-washing-machine'],
        'industrial washing machine' => ['commercial-washing-machine'], 'laundry machine' => ['commercial-washing-machine'],
        // interactive panels
        'interactive panel' => ['interactive-panels'], 'interactive panels' => ['interactive-panels'],
        'interactive flat panel' => ['interactive-panels'], 'ifp' => ['interactive-panels'], 'smart board' => ['interactive-panels'],
        'smartboard' => ['interactive-panels'], 'digital board' => ['interactive-panels'], 'smart class' => ['interactive-panels'],
        'digital whiteboard' => ['interactive-panels'], 'interactive whiteboard' => ['interactive-panels'],
        'teaching board' => ['interactive-panels'], 'touch board' => ['interactive-panels'], 'panel' => ['interactive-panels'],
        'panels' => ['interactive-panels'],
        // video walls
        'led wall' => ['led-video-walls'], 'led walls' => ['led-video-walls'], 'led video wall' => ['led-video-walls'],
        'led screen' => ['led-video-walls'], 'led display' => ['led-video-walls'], 'billboard' => ['led-video-walls'],
        'hoarding' => ['led-video-walls'], 'stage screen' => ['led-video-walls'],
        'video wall' => ['led-video-walls', 'lcd-video-walls'], 'video walls' => ['led-video-walls', 'lcd-video-walls'],
        'lcd wall' => ['lcd-video-walls'], 'lcd video wall' => ['lcd-video-walls'],
        // commercial displays
        'standee' => ['t-standees', 'a-standees', 'table-top-standee'], 'standees' => ['t-standees', 'a-standees', 'table-top-standee'],
        't standee' => ['t-standees'], 'a standee' => ['a-standees'], 'table top standee' => ['table-top-standee'],
        'tabletop standee' => ['table-top-standee'], 'l standee' => ['table-top-standee'],
        'kiosk' => ['stand-alone-kiosk', 'printing-kiosk'], 'kiosks' => ['stand-alone-kiosk', 'printing-kiosk'],
        'touch kiosk' => ['stand-alone-kiosk'], 'printing kiosk' => ['printing-kiosk'], 'self order kiosk' => ['printing-kiosk'],
        'token machine' => ['printing-kiosk'], 'billing kiosk' => ['printing-kiosk'],
        'signage' => ['commercial-display-solutions'], 'digital signage' => ['commercial-display-solutions'],
        'commercial display' => ['commercial-displays'], 'commercial displays' => ['commercial-displays'],
        'menu board' => ['commercial-displays'], 'advertising display' => ['commercial-display-solutions'],
        'digital poster' => ['a-standees'], 'glass display' => ['glass-displays'], 'industrial display' => ['glass-displays'],
        'podium' => ['digital-podium'], 'digital podium' => ['digital-podium'], 'lectern' => ['digital-podium'],
        // audio
        'speaker' => ['home-audio'], 'speakers' => ['home-audio'], 'soundbar' => ['soundbars'], 'sound bar' => ['soundbars'],
        'soundbars' => ['soundbars'], 'subwoofer' => ['home-audio'], 'woofer' => ['home-audio'], 'home theatre' => ['home-audio'],
        'home theater' => ['home-audio'], 'music system' => ['home-audio'], 'tower speaker' => ['twin-tower-speakers', 'single-tower-speakers'],
        'audio' => ['home-audio'],
    ];

    /** Things people search for that Yara does not make; answered honestly instead of showing random products. */
    public const NOT_SOLD = [
        'fridge', 'refrigerator', 'microwave', 'oven', 'mobile', 'phone', 'phones', 'smartphone', 'laptop', 'laptops',
        'computer', 'fan', 'fans', 'geyser', 'heater', 'mixer', 'grinder', 'iron', 'camera', 'watch', 'earphones',
        'headphones', 'printer', 'dishwasher', 'purifier', 'chimney', 'induction',
    ];

    /**
     * Features: phrase → flag. Flags are read from each product's name, category and specs (see ProductIndex).
     */
    public const FEATURES = [
        '4k' => '4k', 'uhd' => '4k', 'ultra hd' => '4k', '4k uhd' => '4k', '2160p' => '4k',
        'full hd' => 'fhd', 'fullhd' => 'fhd', 'fhd' => 'fhd', '1080p' => 'fhd',
        'hd ready' => 'hd', '720p' => 'hd',
        'qled' => 'qled', 'quantum dot' => 'qled', 'mini qled' => 'mini_qled', 'mini led' => 'mini_qled',
        'google tv' => 'google_tv', 'google' => 'google_tv', 'chromecast' => 'google_tv', 'google play' => 'google_tv',
        'smart' => 'smart', 'smart tv' => 'smart', 'android' => 'smart', 'android tv' => 'smart', 'wifi' => 'smart', 'wi fi' => 'smart',
        'internet' => 'smart', 'netflix' => 'smart', 'youtube' => 'smart', 'ott' => 'smart', 'apps' => 'smart',
        'non smart' => 'non_smart', 'nonsmart' => 'non_smart', 'normal tv' => 'non_smart', 'basic tv' => 'non_smart',
        'without internet' => 'non_smart', 'simple tv' => 'non_smart',
        'anti glare' => 'anti_glare', 'antiglare' => 'anti_glare', 'matte' => 'anti_glare', 'no reflection' => 'anti_glare',
        'dolby' => 'dolby', 'dolby vision' => 'dolby', 'dolby audio' => 'dolby', 'dolby atmos' => 'dolby',
        'voice' => 'voice', 'voice remote' => 'voice', 'voice control' => 'voice',
        'inverter' => 'inverter',
        'front load' => 'front_load', 'front loading' => 'front_load', 'front loader' => 'front_load',
        'top load' => 'top_load', 'top loading' => 'top_load', 'top loader' => 'top_load',
        'fully automatic' => 'fully_auto', 'full automatic' => 'fully_auto', 'automatic' => 'fully_auto', 'auto' => 'fully_auto',
        'semi automatic' => 'semi_auto', 'semiautomatic' => 'semi_auto', 'semi auto' => 'semi_auto', 'twin tub' => 'semi_auto', 'semi' => 'semi_auto',
        'indoor' => 'indoor', 'outdoor' => 'outdoor', 'rental' => 'rental',
        'touch' => 'touch', 'touchscreen' => 'touch', 'touch screen' => 'touch',
        'bluetooth' => 'bluetooth', 'portable' => 'portable', 'foldable' => 'portable',
        'stainless steel' => 'steel_drum', 'steel drum' => 'steel_drum',
    ];

    /** Human labels for feature flags (chips on the results page). */
    public const FEATURE_LABELS = [
        '4k' => '4K UHD', 'fhd' => 'Full HD', 'hd' => 'HD', 'qled' => 'QLED', 'mini_qled' => 'Mini QLED',
        'google_tv' => 'Google TV', 'smart' => 'Smart', 'non_smart' => 'Non-smart', 'anti_glare' => 'Anti-glare',
        'dolby' => 'Dolby', 'voice' => 'Voice control', 'inverter' => 'Inverter', 'front_load' => 'Front load',
        'top_load' => 'Top load', 'fully_auto' => 'Fully automatic', 'semi_auto' => 'Semi automatic', 'indoor' => 'Indoor',
        'outdoor' => 'Outdoor', 'rental' => 'Rental', 'touch' => 'Touch', 'bluetooth' => 'Bluetooth',
        'portable' => 'Portable', 'steel_drum' => 'Stainless steel drum',
    ];

    /**
     * Rooms and uses → what fits them. Each rule may set categories, a screen size range, AC tonnage
     * or a wash capacity range; the label explains it on the results page.
     */
    public const USES = [
        'bedroom' => ['label' => 'For a bedroom', 'inch' => [32, 43], 'ton' => [1, 1]],
        'bed room' => ['label' => 'For a bedroom', 'inch' => [32, 43], 'ton' => [1, 1]],
        'small room' => ['label' => 'For a small room', 'inch' => [24, 43], 'ton' => [1, 1]],
        'kids room' => ['label' => 'For a kids room', 'inch' => [32, 43], 'ton' => [1, 1]],
        'kitchen' => ['label' => 'For a kitchen', 'inch' => [24, 32]],
        'living room' => ['label' => 'For a living room', 'inch' => [50, 65], 'ton' => [1.5, 1.5]],
        'hall' => ['label' => 'For a hall', 'inch' => [55, 75], 'ton' => [1.5, 2]],
        'drawing room' => ['label' => 'For a living room', 'inch' => [50, 65], 'ton' => [1.5, 1.5]],
        'big hall' => ['label' => 'For a large hall', 'inch' => [65, 100], 'ton' => [2, 2]],
        'large room' => ['label' => 'For a large room', 'inch' => [65, 100], 'ton' => [2, 2]],
        'home theatre' => ['label' => 'For a home theatre', 'inch' => [65, 100]],
        'home theater' => ['label' => 'For a home theatre', 'inch' => [65, 100]],
        'gaming' => ['label' => 'For gaming', 'features' => ['4k']],
        'movies' => ['label' => 'For movies', 'inch' => [55, 100]],
        'sports' => ['label' => 'For sports', 'inch' => [55, 100]],
        'classroom' => ['label' => 'For classrooms', 'categories' => ['interactive-panels']],
        'class room' => ['label' => 'For classrooms', 'categories' => ['interactive-panels']],
        'school' => ['label' => 'For schools', 'categories' => ['interactive-panels', 'digital-podium']],
        'schools' => ['label' => 'For schools', 'categories' => ['interactive-panels', 'digital-podium']],
        'college' => ['label' => 'For colleges', 'categories' => ['interactive-panels', 'digital-podium']],
        'teaching' => ['label' => 'For teaching', 'categories' => ['interactive-panels']],
        'education' => ['label' => 'For education', 'categories' => ['interactive-panels', 'digital-podium']],
        'coaching' => ['label' => 'For coaching centres', 'categories' => ['interactive-panels']],
        'tuition' => ['label' => 'For tuition', 'categories' => ['interactive-panels']],
        'online class' => ['label' => 'For online classes', 'categories' => ['interactive-panels']],
        'meeting room' => ['label' => 'For meeting rooms', 'categories' => ['interactive-panels', 'commercial-displays']],
        'boardroom' => ['label' => 'For boardrooms', 'categories' => ['interactive-panels', 'commercial-displays']],
        'conference' => ['label' => 'For conferences', 'categories' => ['interactive-panels', 'digital-podium']],
        'auditorium' => ['label' => 'For auditoriums', 'categories' => ['digital-podium']],
        'office' => ['label' => 'For offices', 'categories' => ['interactive-panels', 'commercial-displays', 'air-conditioners']],
        'shop' => ['label' => 'For shops', 'categories' => ['commercial-display-solutions']],
        'store' => ['label' => 'For stores', 'categories' => ['commercial-display-solutions']],
        'retail' => ['label' => 'For retail', 'categories' => ['commercial-display-solutions']],
        'showroom' => ['label' => 'For showrooms', 'categories' => ['commercial-display-solutions']],
        'mall' => ['label' => 'For malls', 'categories' => ['commercial-display-solutions', 'chillers']],
        'advertising' => ['label' => 'For advertising', 'categories' => ['commercial-display-solutions']],
        'advertisement' => ['label' => 'For advertising', 'categories' => ['commercial-display-solutions']],
        'promotion' => ['label' => 'For promotions', 'categories' => ['commercial-display-solutions']],
        'restaurant' => ['label' => 'For restaurants', 'categories' => ['printing-kiosk', 'table-top-standee', 'commercial-displays']],
        'cafe' => ['label' => 'For cafes', 'categories' => ['printing-kiosk', 'table-top-standee', 'commercial-displays']],
        'hotel' => ['label' => 'For hotels', 'categories' => ['commercial-display-solutions', 'commercial-washing-machine']],
        'jewellery' => ['label' => 'For jewellery stores', 'categories' => ['table-top-standee']],
        'jewelry' => ['label' => 'For jewellery stores', 'categories' => ['table-top-standee']],
        'hospital' => ['label' => 'For hospitals', 'categories' => ['commercial-washing-machine', 'stand-alone-kiosk']],
        'hostel' => ['label' => 'For hostels', 'categories' => ['commercial-washing-machine']],
        'party' => ['label' => 'For parties', 'categories' => ['home-audio']],
        'music' => ['label' => 'For music', 'categories' => ['home-audio']],
    ];

    /** Numbers written as words. */
    public const NUMBER_WORDS = [
        'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8,
        'nine' => 9, 'ten' => 10, 'eleven' => 11, 'twelve' => 12, 'fifteen' => 15, 'twenty' => 20, 'twenty five' => 25,
        'thirty' => 30, 'forty' => 40, 'fifty' => 50, 'sixty' => 60, 'seventy' => 70, 'eighty' => 80, 'ninety' => 90,
        'hundred' => 100,
    ];

    /** Common misspellings that edit distance alone gets wrong. */
    public const SPELLING = [
        'tele' => 'tv', 'tellivision' => 'television', 'telivision' => 'television', 'televison' => 'television',
        'washin' => 'washing', 'wasing' => 'washing', 'mashine' => 'machine', 'machin' => 'machine', 'mechine' => 'machine',
        'a c' => 'ac', 'airconditioner' => 'air conditioner', 'aircondition' => 'air conditioner',
        'fridg' => 'fridge', 'speeker' => 'speaker', 'spekar' => 'speaker',
        'kisok' => 'kiosk', 'kiosque' => 'kiosk', 'standy' => 'standee', 'standi' => 'standee',
        'inch' => 'inch', 'inchs' => 'inch', 'inches' => 'inch', 'tonne' => 'ton', 'tons' => 'ton',
        'cheep' => 'cheap', 'chepest' => 'cheapest', 'cheapst' => 'cheapest', 'afordable' => 'affordable',
        'qlde' => 'qled', 'q led' => 'qled', 'led tv' => 'led tv', 'andriod' => 'android', 'andoid' => 'android',
        'semiautomatic' => 'semi automatic', 'fullyautomatic' => 'fully automatic', 'frontload' => 'front load',
        'topload' => 'top load', 'smartboard' => 'smart board',
    ];
}
