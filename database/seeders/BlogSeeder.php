<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Blog posts, illustrated with the same product artwork used across the store:
 *  - Interactive flat panels in the classroom
 *  - The story of television in India
 *  - The evolution of promotion: hand-painted walls to digital standees
 *  - TV buying guide: size, viewing distance and panel type
 *  - AC buying guide: tonnage, star rating and ISEER
 *  - Washing machine buying guide: semi automatic, top load or front load
 *  - LED video walls: choosing the right pixel pitch
 *
 * Images are copied from database/seeders/assets/* to storage/blog. Idempotent (matched by slug).
 *
 *   php artisan db:seed --class=BlogSeeder
 */
class BlogSeeder extends Seeder
{
    private const ASSETS = __DIR__ . '/assets';

    public function run(): void
    {
        $this->interactivePanels();
        $this->televisionStory();
        $this->promotionStory();
        $this->tvBuyingGuide();
        $this->acBuyingGuide();
        $this->washingMachineGuide();
        $this->ledPixelPitchGuide();
    }

    // ------------------------------------------------------------------ 1. Interactive panels

    private function interactivePanels(): void
    {
        $cover = $this->publish('interactive-panels/home-banner.jpg', 'blog/interactive-panels-cover.jpg');
        $highlights = $this->publish('interactive-panels/products/yara-ifp-75-highlights.jpg', 'blog/content/ifp-75-highlights.jpg');
        $classroom = $this->publish('interactive-panels/explore/ifp-classroom.jpg', 'blog/content/ifp-classroom.jpg');
        $science = $this->publish('interactive-panels/explore/ifp-wall-science.png', 'blog/content/ifp-lesson-science.png');
        $ports = $this->publish('interactive-panels/products/yara-ifp-65-ports.jpg', 'blog/content/ifp-65-ports.jpg');
        $stand = $this->publish('interactive-panels/explore/ifp-stand-chemistry.png', 'blog/content/ifp-stand.png');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => 'how-interactive-flat-panels-transform-classrooms'],
            [
                'title' => 'How Interactive Flat Panels Are Transforming Classrooms',
                'category' => 'Interactive Panels',
                'author' => 'Yara Electronics',
                'excerpt' => 'From chalkboards to 4K touch screens: how teachers use an interactive flat panel to explain, show and involve every student, and how to pick the right size for your classroom.',
                'cover_image' => $cover,
                'meta_title' => 'Interactive Flat Panels for Classrooms – A Teacher\'s Guide',
                'meta_description' => 'How 4K interactive flat panels with 20-point touch, a built-in whiteboard and wireless sharing improve teaching, and which size (55" to 100") suits your classroom.',
                'is_published' => true,
                'published_at' => Post::where('slug', 'how-interactive-flat-panels-transform-classrooms')->value('published_at') ?? now()->subDays(6),
                'content' => <<<HTML
                <p>Walk into a modern classroom today and there's a good chance the chalkboard and projector have been replaced by a single large touch screen. <strong>Interactive flat panels (IFPs)</strong> combine a 4K display, a digital whiteboard and a computer in one device, and they are quickly becoming the centre of how teachers explain and how students learn.</p>

                {$img($classroom, 'A Yara Interactive Panel replacing the chalkboard at the front of the class')}

                <h2>What is an interactive flat panel?</h2>
                <p>An interactive flat panel is a large touch display, usually 55" to 100", that teachers write on, draw on and control directly with a finger or a pen. Unlike a projector, there is no bulb to replace, no shadow when the teacher stands in front of it, and the picture stays bright and sharp even with the classroom lights on.</p>

                {$img($highlights, 'Yara 75" Interactive Flat Panel – 4K UHD, 20-point touch and a built-in whiteboard')}

                <h2>A lesson in four moments</h2>
                <ol>
                    <li><strong>Explain.</strong> Write and draw naturally with the pen or a finger, over any app, video or PDF. Auto shape and text recognition turn rough sketches into clean diagrams.</li>
                    <li><strong>Show.</strong> Play videos, 3D models and PhET science simulations in 4K, and split the screen to compare two ideas side by side.</li>
                    <li><strong>Involve.</strong> 20-point touch means several students can come up and solve a problem together, not one at a time.</li>
                    <li><strong>Share.</strong> Save the whole lesson as a PDF and share it by QR code, so absent students never miss the notes.</li>
                </ol>

                {$img($science, 'A science lesson on the solar system, explained live on the panel')}

                <blockquote>Tip: before buying, measure the distance from the board to the last bench. It is the single best guide to choosing the right panel size.</blockquote>

                <h2>No PC required, and connects to everything</h2>
                <p>A built-in Android 14 system with 8 GB RAM and 128 GB storage runs the whiteboard, a browser, Google Play apps and simulations on its own. When you do want a laptop, share it wirelessly in seconds, or plug in over HDMI, USB-C, USB 3.0 and LAN. An OPS slot adds a full Windows PC inside the panel.</p>

                {$img($ports, 'Front ports: HDMI, USB-C, USB 3.0 and more within easy reach')}

                <h2>Which size is right for your classroom?</h2>
                <ul>
                    <li><strong>55"</strong> – primary classrooms and tuition rooms, up to 30 students</li>
                    <li><strong>65"</strong> – standard classrooms and smart labs, up to 40 students</li>
                    <li><strong>75"</strong> – large classrooms and seminar rooms, up to 60 students</li>
                    <li><strong>85"</strong> – lecture halls and teacher training, up to 80 students</li>
                    <li><strong>100"</strong> – auditoriums and lecture theatres, 100+ students</li>
                </ul>

                <h2>Wall-mounted or on a stand?</h2>
                <p>Every Yara panel comes with a wall-mount bracket. To share one panel between classrooms and labs, pair it with our trolley stand and roll it wherever the lesson is.</p>

                {$img($stand, 'Yara Interactive Panel on its trolley stand, ready to move between classrooms')}

                <h2>See one in a real class</h2>
                <p>Explore our <a href="/interactive-panels">interactive panels for smart classrooms</a> from 55" to 100", or <a href="/book-a-demo">book a free classroom demo</a> and our team will bring a panel to your school.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 2. Television in India

    private function televisionStory(): void
    {
        $cover = $this->publish('televisions/category-google-tv.jpg', 'blog/tv-story-cover.jpg');
        $smart = $this->publish('televisions/products/tv-43sf24n-info.jpg', 'blog/content/tv-smart.jpg');
        $google = $this->publish('televisions/products/tv-55su23g-info.jpg', 'blog/content/tv-google.jpg');
        $family = $this->publish('televisions/banner-televisions.jpg', 'blog/content/tv-range.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => 'story-of-how-tv-changed-in-india'],
            [
                'title' => 'From One Channel to a Thousand Choices: The Story of How TV Changed in India',
                'category' => 'Televisions',
                'author' => 'Yara Electronics',
                'excerpt' => 'Black-and-white Doordarshan in 1959, colour for the 1982 Asian Games, the LED shift of 2009 and today\'s 4K Google TVs: four turning points that changed how India watches.',
                'cover_image' => $cover,
                'meta_title' => 'The History of Television in India: From Doordarshan to 4K Google TV',
                'meta_description' => 'How TV changed in India: the 1959 Doordarshan broadcast, colour TV in 1982, satellite channels in the 1990s, LED TVs in 2009 and today\'s Smart and 4K Google TVs.',
                'is_published' => true,
                'published_at' => Post::where('slug', 'story-of-how-tv-changed-in-india')->value('published_at') ?? now()->subDays(3),
                'content' => <<<HTML
                <blockquote><strong>Quick answer:</strong> Television in India has moved through four real turning points: black-and-white Doordarshan broadcasts from 1959, colour TV's arrival in 1982 for the Asian Games, the LCD-to-LED shift in the late 2000s, and today's Smart and 4K TVs built for streaming and OTT. Each shift changed not just the screen, but how Indian households actually watched. Yara Electronics' 4K Smart LED TVs and Google TVs are built for this current chapter.</blockquote>

                <p>Think about what's playing on a television today, in any home, at any given hour. A news channel in one tab, a web series queued up for later, someone's phone mirrored onto the big screen to show a reel from this morning. It feels effortless now. It was not always this way.</p>
                <p>Go back far enough, and television in an Indian home wasn't a given. It was an event.</p>

                <h2>When a TV was the whole neighbourhood's television</h2>
                <p>India's first television broadcast went out from Delhi in 1959, and for over two decades after that it stayed mostly what it started as: an educational tool for schools and farmers, broadcasting for a few hours a day, in black and white, reaching only a handful of cities.</p>
                <p>Owning a TV set in the 1970s and early 80s meant something. It wasn't a household item, it was a status symbol. One set per street was common, and neighbours would gather in the one house lucky enough to have one, especially when something worth watching was on.</p>
                <p>The real turning point came in 1982. India was preparing to host the Asian Games in Delhi, and the government decided to broadcast the games in colour, something Indian television had never done before. Doordarshan ran its first colour test transmission on 25 April 1982, with full colour broadcasts of the Asian Games following that November. Almost overnight, black-and-white sets started to feel old. Colour didn't just change what was on the screen, it changed how badly people wanted one.</p>

                <h2>The 1990s: when TV stopped belonging to one channel</h2>
                <p>For most of its first three decades, Indian television meant Doordarshan and nothing else. That changed through the 1990s, as economic liberalisation opened the door to private and satellite broadcasters. Channels like Zee TV, Sun TV and Asianet arrived alongside international names like CNN and STAR, and for the first time Indian viewers had something Doordarshan never offered them: a choice of what to watch.</p>
                <p>This is also when many regional markets, including Tamil Nadu, saw their own entertainment ecosystems take shape, with local-language channels growing alongside national ones.</p>

                <h2>A local chapter: TVs for homes that didn't have one</h2>
                <p>Tamil Nadu has its own place in this story. In 2006 the state government launched a free colour TV scheme aimed at households that didn't already own one, distributing sets in phases over the following years.</p>
                <p>Whatever the politics around it, the scheme reflects something real about this period: by the mid-2000s television had stopped being a luxury and become a basic household expectation, which pushed manufacturers to build cheaper, better and more efficient screens.</p>

                <h2>Flat, then bright: the LCD-to-LED shift</h2>
                <p>While much of the world had moved to flat-screen LCD TVs by the late 1990s, the technology reached the Indian market in the mid-2000s. LCDs were thinner, lighter and came in larger sizes than the boxy CRT sets they replaced, but they were only the warm-up act.</p>
                <p>The real shift came in 2009, when LED-backlit TVs arrived in India: slimmer, sharper and more power-efficient. Over the next few years LED became the default, prices fell as brands competed, and 32-inch, 40-inch and eventually 55-inch screens became realistic for an ordinary household.</p>

                {$img($smart, 'A Yara Full HD Smart LED TV: slim, bright and connected')}

                <h2>Smart TVs and the OTT generation</h2>
                <p>By the early 2010s the television had quietly turned into a connected device. Smart TVs brought the internet, app stores and eventually Netflix, Amazon Prime Video and a dozen other OTT platforms straight onto the living-room screen.</p>
                <p>This is the chapter most of us are still living in. A television today isn't judged by whether it shows a clear picture, that's assumed. It's judged by how smoothly it switches between live news, a streaming show and a video pulled straight off someone's phone. The remote control has quietly become a search bar.</p>

                {$img($google, 'Yara 55" 4K UHD Google TV with Dolby Audio and voice control')}

                <h2>Where Yara fits into this story</h2>
                <p>At Yara Electronics, our <a href="/category/smart-tv">Smart LED TVs</a> and <a href="/category/google-tv">4K Google TVs</a> are built for exactly this everyday reality: a household that moves between news, OTT and content from a phone, often within the same hour. Google TV brings a familiar, app-based interface and built-in Chromecast, so switching between live TV and a streaming platform doesn't need a second remote or a second device.</p>
                <p>As a Coimbatore-based, India-focused private-label electronics maker, Yara designs and sells its own TVs directly, with after-sales support through our own partner-technician network rather than a chain of resellers. When a household needs help, there's a clear line back to the company that built the set.</p>

                {$img($family, 'The Yara TV range, from 24" HD to 100" Mini QLED')}

                <h2>The next chapter hasn't been written yet</h2>
                <p>Television in India has already reinvented itself four times: from an educational broadcast experiment, to a colour status symbol, to a flat LED screen, to a connected smart device. None of those shifts were really about the screen itself. Each one was about what people could finally do with it: watch together, watch more, and eventually watch whatever they wanted, whenever they wanted.</p>
                <p>The next shift is already underway, on the same screen that's probably on in the next room right now.</p>

                <h2>Frequently asked questions</h2>
                <h3>When did television first start in India?</h3>
                <p>India's first television broadcast began in Delhi in 1959, as an educational service for schools and farmers. It stayed limited to a few cities and a few broadcast hours a day for over two decades.</p>
                <h3>When did colour TV come to India?</h3>
                <p>Colour television arrived in 1982, timed to the Asian Games in Delhi. Doordarshan ran its first colour test broadcast in April 1982, with full colour coverage of the Games that November.</p>
                <h3>When were LED TVs introduced in India?</h3>
                <p>LED-backlit televisions reached the Indian market in 2009, offering slimmer designs and better energy efficiency than the LCD TVs before them, and quickly became the standard.</p>
                <h3>What is the difference between an LED TV and a Smart TV?</h3>
                <p>LED refers to the display technology: how the screen is lit and how the picture is produced. Smart refers to the software: whether the TV connects to the internet, runs apps and streams OTT platforms. Most TVs sold today, including Yara's range, are both.</p>
                <h3>Is a 4K Google TV worth buying for home use?</h3>
                <p>For households that regularly stream OTT content, yes. It combines a sharper picture with a familiar, app-based interface and built-in casting from a phone, without needing a separate streaming device.</p>
                <h3>Does Yara Electronics provide after-sales support for its TVs?</h3>
                <p>Yes. Yara supports its Smart LED TVs and Google TVs through its own partner-technician network for installation and after-sales service.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 3. Promotion: walls to standees

    private function promotionStory(): void
    {
        $cover = $this->publish('t-standees/t-standee-banner.jpg', 'blog/promotion-cover.jpg');
        $mall = $this->publish('t-standees/poster-mall.jpg', 'blog/content/standee-mall.jpg');
        $aTrio = $this->publish('a-standees/a-standee-trio.png', 'blog/content/a-standee-trio.png');
        $tTrio = $this->publish('t-standees/t-standee-trio.png', 'blog/content/t-standee-trio.png');
        $boutique = $this->publish('a-standees/poster-boutique.jpg', 'blog/content/a-standee-boutique.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => 'hand-painted-walls-to-digital-standees'],
            [
                'title' => 'From Hand-Painted Walls to Digital Standees: The Evolution of Promotion in India',
                'category' => 'Digital Signage',
                'author' => 'Yara Electronics',
                'excerpt' => 'Every era of Indian advertising has a texture. The 90s had wet paint. The 2000s had FLEX. Today has pixels.',
                'cover_image' => $cover,
                'meta_title' => 'Hand-Painted Signs to Digital Standees: How Promotion Changed in India',
                'meta_description' => 'How shop promotion in India moved from hand-painted walls to FLEX printing to digital standees, kiosks and LED walls, and why digital signage pays off for businesses.',
                'is_published' => true,
                'published_at' => Post::where('slug', 'hand-painted-walls-to-digital-standees')->value('published_at') ?? now()->subDay(),
                'content' => <<<HTML
                <p class="lead"><strong>Every era of Indian advertising has a texture. The 90s had wet paint. The 2000s had FLEX. Today has pixels.</strong></p>

                <h2>The hand-painted era: when promotion was a craft</h2>
                <p>Before printers and screens, promotion was drawn by hand, line by line, wall by wall.</p>
                <p>Artists mixed their own paint to get colours that would survive sun and rain. A single shop signboard or movie poster could take hours, sometimes days. This wasn't decoration. It was a livelihood, and the artist's skill decided whether a shop, hospital or cinema caught the public eye.</p>
                <p>Through the 90s, this was the visual language of Indian streets: shopfronts, hoardings and movie posters, each one a small, handmade performance aimed at pulling in an audience.</p>

                <h2>The print era: FLEX and poster machines take over</h2>
                <p><strong>What replaced hand-painted billboards in India?</strong> FLEX printing and poster machines, starting around the mid-2000s, turned days of manual work into hours of machine output.</p>
                <p>Colour that once took an artist's hand to mix became pixels: sharp, repeatable and fast. The artist's role shifted from painting the wall to designing what would go on it. Print became the main format for shop signage, mall pamphlets and outdoor billboards, and it stayed dominant for over a decade.</p>

                <h2>The digital era: displays that update by the minute</h2>
                <p>Now promotion is moving again, from print to pixels that move.</p>

                {$img($mall, 'A Yara T-Standee drawing shoppers in a mall atrium')}

                <p>Digital standees, kiosks, interactive flat panels and LED video walls are replacing static print in malls, hospitals, showrooms and retail storefronts. A message that once took a week to paint, or a day to print, can now be updated in seconds from a single screen, without reprinting anything.</p>
                <p>This is where products like Yara's <a href="/t-standees">T-Standees</a>, <a href="/a-standees">A-Standees</a> and <a href="/interactive-panels">interactive panels</a> fit in: not as a replacement for the artist's instinct, but as its modern tool. The goal hasn't changed: make it clear, make it neat, make people stop and look. Only the medium has.</p>

                {$img($tTrio, 'Yara T-Standees in 55", 65" and 75"')}

                <h2>Why this shift matters for your business</h2>
                <ul>
                    <li><strong>Speed:</strong> change your offer, price or message instantly. No reprinting, no waiting.</li>
                    <li><strong>Cost over time:</strong> one digital standee replaces dozens of printed posters across a year.</li>
                    <li><strong>Consistency:</strong> private-label manufacturing means every panel meets the same quality and colour standard.</li>
                    <li><strong>Local support:</strong> Coimbatore-engineered displays, installed and serviced through a partner-technician network across India.</li>
                </ul>

                {$img($aTrio, 'Portable Yara A-Standees in 32", 43" and 55": fold, carry and set up anywhere')}

                {$img($boutique, 'A digital A-Standee welcoming customers at a boutique entrance')}

                <h2>Frequently asked questions</h2>
                <h3>What replaced hand-painted billboards in India?</h3>
                <p>FLEX printing in the mid-2000s, followed by digital displays like standees, kiosks and interactive flat panels from the 2020s onward.</p>
                <h3>Are digital standees replacing printed posters completely?</h3>
                <p>Not completely, but they're becoming the default for malls, hospitals and retail spaces that need to update their messaging often.</p>
                <h3>Is a digital standee cost-effective for a small shop?</h3>
                <p>Yes, over time. One display replaces repeated printing costs and can be updated instantly for new offers or seasons.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 4. TV buying guide

    private function tvBuyingGuide(): void
    {
        $slug = 'tv-buying-guide-size-distance-panel';
        $cover = $this->publish('televisions/banner-televisions.jpg', 'blog/tv-buying-guide-cover.jpg');
        $qled = $this->publish('televisions/banner-qled-tv.jpg', 'blog/content/tv-qled.jpg');
        $miniQled = $this->publish('televisions/banner-mini-qled-tv.jpg', 'blog/content/tv-mini-qled.jpg');
        $antiGlare = $this->publish('televisions/banner-anti-glare-tv.jpg', 'blog/content/tv-anti-glare.jpg');
        $google = $this->publish('televisions/banner-google-tv.jpg', 'blog/content/tv-google-tv.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => 'Which TV Should You Buy? Size, Viewing Distance and Panel Type Explained',
                'category' => 'Buying Guide',
                'author' => 'Yara Electronics',
                'excerpt' => 'A simple guide to picking the right TV: how big to go for your room, HD vs Full HD vs 4K, and when QLED, Mini QLED, Google TV or an anti-glare screen is worth it.',
                'cover_image' => $cover,
                'meta_title' => 'TV Buying Guide: Size, Viewing Distance, 4K, QLED and Mini QLED',
                'meta_description' => 'How to choose a TV size for your room, whether you need 4K, and the difference between Smart, Google TV, QLED, Mini QLED and anti-glare TVs, with Yara models from 24" to 100".',
                'is_published' => true,
                'published_at' => Post::where('slug', $slug)->value('published_at') ?? now()->subHours(9),
                'content' => <<<HTML
                <p>Buying a TV used to mean choosing a size and a brand. Today there are HD, Full HD and 4K screens, Smart TVs and Google TVs, QLED and Mini QLED panels, and sizes from 24" all the way to 100". This guide walks through the three decisions that matter most, so you get a TV that suits your room, not just the showroom.</p>

                <h2>1. Start with your room: size and viewing distance</h2>
                <p>Measure the distance from where you sit to the wall where the TV will go. A bigger screen only looks better if you sit far enough back for it, and with a 4K screen you can sit closer without seeing pixels.</p>
                <ul>
                    <li><strong>Up to 1.5 m (bedroom, study):</strong> 24" to 32"</li>
                    <li><strong>1.5 to 2 m (small living room):</strong> 40" to 43"</li>
                    <li><strong>2 to 2.5 m (living room):</strong> 50" to 55"</li>
                    <li><strong>2.5 to 3.5 m (large living room):</strong> 65" to 75"</li>
                    <li><strong>3.5 m and more (home theatre, hall):</strong> 85" to 100"</li>
                </ul>
                <blockquote>Tip: if you are torn between two sizes, most people who buy the smaller one wish they had gone bigger. Once you're used to it, a TV almost always looks smaller at home than in the shop.</blockquote>

                <h2>2. Resolution: HD, Full HD or 4K UHD?</h2>
                <p><strong>HD</strong> is fine for 24" and 32" screens in bedrooms and kitchens. <strong>Full HD</strong> suits 40" to 43". From <strong>43" upwards, choose 4K UHD</strong>: it has four times the pixels of Full HD, so large screens stay sharp, and most streaming apps already offer 4K content.</p>

                <h2>3. Panel and software: what the names mean</h2>
                <h3>Smart TV</h3>
                <p>Streaming apps, screen casting from your phone and USB media playback built in. Yara Smart TVs run from 32" to 98". If you only watch cable or a set-top box, a simple <a href="/category/non-smart-tv">non-smart HD LED TV</a> in 24" or 32" does the job.</p>

                <h3>Google TV</h3>
                <p>A Smart TV with Google built in: the Google Play Store, Chromecast built-in and voice search with the remote. It brings together recommendations from all your apps on one home screen. <a href="/category/google-tv">Yara Google TVs</a> come in HD, Full HD and 4K UHD.</p>
                {$img($google, 'Yara Google TVs with Google Play, Chromecast built-in and voice search')}

                <h3>QLED</h3>
                <p>QLED TVs add a layer of quantum dots that produce purer, brighter colours, over a billion shades, than a standard LED panel. Reds and greens look richer, and colours hold up better in a bright room. <a href="/category/qled-tv">Yara QLED TVs</a> run from 32" to 85" with Dolby Audio.</p>
                {$img($qled, 'Yara QLED TVs: quantum-dot colour from 32" to 85"')}

                <h3>Mini QLED</h3>
                <p>Mini QLED uses thousands of tiny LEDs behind the screen, grouped into local dimming zones. Bright parts of the picture get brighter and dark parts stay truly dark, which is what makes HDR films look their best. <a href="/category/mini-qled-tv">Yara Mini QLED Google TVs</a> come in 75", 86" and 100", with up to 700 nits and 10,000:1 contrast.</p>
                {$img($miniQled, 'Yara Mini QLED: local dimming for deeper blacks and brighter highlights')}

                <h3>Anti-glare</h3>
                <p>Living rooms with big windows or bright lights opposite the TV suffer from reflections. A matte, <a href="/category/anti-glare-tv">anti-glare QLED</a> screen scatters that light so the picture stays clear during the day. Yara anti-glare TVs come in 65", 75", 86" and 100".</p>
                {$img($antiGlare, 'Yara Anti-Glare QLED: a matte screen that stays clear in bright rooms')}

                <h2>Quick checklist before you buy</h2>
                <ul>
                    <li>Measured seating distance and wall space (or stand width)</li>
                    <li>4K for anything 43" and above</li>
                    <li>Google TV if you want apps, Chromecast and voice search in one place</li>
                    <li>QLED or Mini QLED if colour and HDR matter to you</li>
                    <li>Anti-glare if the room gets a lot of daylight</li>
                    <li>Enough HDMI and USB ports for your set-top box, console and soundbar</li>
                </ul>
                <p>Still not sure? Browse the full <a href="/category/televisions">Yara TV range</a> or talk to our team on WhatsApp, and we'll help you pick the right one.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 5. AC buying guide

    private function acBuyingGuide(): void
    {
        $slug = 'ac-buying-guide-tonnage-star-rating';
        $cover = $this->publish('air-conditioners/home-banner.jpg', 'blog/ac-buying-guide-cover.jpg');
        $oneTon = $this->publish('air-conditioners/banner-1-ton-ac.jpg', 'blog/content/ac-1-ton.jpg');
        $oneHalf = $this->publish('air-conditioners/banner-1-5-ton-ac.jpg', 'blog/content/ac-1-5-ton.jpg');
        $twoTon = $this->publish('air-conditioners/banner-2-ton-ac.jpg', 'blog/content/ac-2-ton.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => '1 Ton, 1.5 Ton or 2 Ton? How to Choose the Right AC for Your Room',
                'category' => 'Buying Guide',
                'author' => 'Yara Electronics',
                'excerpt' => 'Choosing an AC comes down to two numbers: tonnage and star rating. Here is how to match the tonnage to your room size, and when a 5 star inverter AC pays for itself.',
                'cover_image' => $cover,
                'meta_title' => 'AC Buying Guide: Tonnage by Room Size, 3 Star vs 5 Star and ISEER',
                'meta_description' => 'Which AC tonnage suits your room (1, 1.5 or 2 ton), what the BEE star rating and ISEER mean, and why inverter compressors, copper coils and R-32 gas matter.',
                'is_published' => true,
                'published_at' => Post::where('slug', $slug)->value('published_at') ?? now()->subHours(7),
                'content' => <<<HTML
                <p>An AC that is too small runs flat out all afternoon and still can't cool the room. One that is too big cools too fast, switches off and leaves the air damp. Getting the size right is the single biggest decision, and the star rating decides what you pay every month after that.</p>

                <h2>Step 1: Match the tonnage to your room</h2>
                <p>"Tonnage" is cooling capacity, not weight. A 1 ton AC removes about 12,000 BTU of heat per hour. As a starting point for a room with a normal 10 ft ceiling:</p>
                <ul>
                    <li><strong>1 Ton:</strong> bedrooms and small rooms up to about 120 sq ft</li>
                    <li><strong>1.5 Ton:</strong> living rooms and large bedrooms of 120 to 180 sq ft</li>
                    <li><strong>2 Ton:</strong> halls, shops and offices of 180 to 250 sq ft</li>
                </ul>
                {$img($oneTon, 'Yara 1 Ton inverter split AC for bedrooms and small rooms')}
                <p><strong>Go one size up if</strong> the room is on the top floor, faces west, has large windows, is a kitchen-facing hall, or usually has more than four people in it. Each of these adds heat the AC has to remove.</p>

                <h2>Step 2: 3 star or 5 star?</h2>
                <p>The BEE star label tells you how efficient the AC is, measured as <strong>ISEER</strong> (Indian Seasonal Energy Efficiency Ratio): how much cooling you get for each unit of electricity across a typical Indian year. The higher the ISEER, the lower the bill.</p>
                <ul>
                    <li>Yara <strong>3 star</strong> inverter ACs have an ISEER of 3.6 to 3.9.</li>
                    <li>Yara <strong>5 star</strong> inverter ACs have an ISEER of 5.0 to 5.1, roughly a quarter less electricity for the same cooling.</li>
                </ul>
                {$img($oneHalf, 'Yara 1.5 Ton inverter split AC: the most popular size for Indian homes')}
                <blockquote>Rule of thumb: if the AC will run 8 hours or more a day, for most of the year, a 5 star model usually earns back its higher price in electricity savings. For a guest room used a few weeks a year, 3 star is enough.</blockquote>

                <h2>Step 3: Check what is inside</h2>
                <ul>
                    <li><strong>Inverter compressor:</strong> slows down instead of switching on and off, so the temperature stays steady and power use drops. Every Yara split AC is an inverter AC.</li>
                    <li><strong>100% copper condenser coil:</strong> transfers heat better than aluminium and is easier to repair.</li>
                    <li><strong>Anti-corrosion (blue fin) evaporator:</strong> protects the coil from humidity and coastal air.</li>
                    <li><strong>R-32 refrigerant:</strong> cools efficiently with a lower environmental impact than older gases.</li>
                    <li><strong>PM 2.5 filter:</strong> traps fine dust, smoke and pollen.</li>
                    <li><strong>BLDC fan motors:</strong> quieter and use less power than conventional fan motors.</li>
                </ul>
                {$img($twoTon, 'Yara 2 Ton inverter split AC for halls, shops and offices')}

                <h2>Getting the most out of your AC</h2>
                <ul>
                    <li>Set it to <strong>24°C</strong>. Each degree lower adds noticeably to your bill without much extra comfort.</li>
                    <li>Clean the filter every two weeks in summer.</li>
                    <li>Close curtains on sunny windows and keep doors shut while it runs.</li>
                    <li>Get it serviced once a year, ideally before summer.</li>
                </ul>
                <p>Explore the <a href="/category/air-conditioners">Yara inverter AC range</a> in 1, 1.5 and 2 ton, 3 star and 5 star.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 6. Washing machine guide

    private function washingMachineGuide(): void
    {
        $slug = 'washing-machine-guide-semi-automatic-top-front-load';
        $cover = $this->publish('washing-machines/blog-guide-cover.jpg', 'blog/washing-machine-guide-cover.jpg');
        $semi = $this->publish('washing-machines/banner-semi-automatic.jpg', 'blog/content/wm-semi-automatic.jpg');
        $fully = $this->publish('washing-machines/fully-automatic-banner.jpg', 'blog/content/wm-fully-automatic.jpg');
        $highlights = $this->publish('washing-machines/products/wm-wt70c1mt-highlights.jpg', 'blog/content/wm-7kg-semi-highlights.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => 'Semi Automatic, Top Load or Front Load? Choosing the Right Washing Machine',
                'category' => 'Buying Guide',
                'author' => 'Yara Electronics',
                'excerpt' => 'Semi automatic, fully automatic top load and front load machines all wash clothes, but they suit very different homes. Here is how to pick the type and the capacity that fit yours.',
                'cover_image' => $cover,
                'meta_title' => 'Washing Machine Buying Guide: Semi Automatic vs Top Load vs Front Load',
                'meta_description' => 'The difference between semi automatic, fully automatic top load and front load washing machines, and which capacity (6.5 kg to 11 kg) suits your family size.',
                'is_published' => true,
                'published_at' => Post::where('slug', $slug)->value('published_at') ?? now()->subHours(5),
                'content' => <<<HTML
                <p>The right washing machine depends on three things: how much water and time you have, how much space there is, and how many people you are washing for. Here is how the three main types compare.</p>

                <h2>Semi automatic (twin tub)</h2>
                <p>A semi automatic machine has two tubs side by side: one washes, the other spins the clothes dry. You move the clothes from one tub to the other and fill the water yourself.</p>
                <ul>
                    <li><strong>Best for:</strong> homes with irregular water supply, large families, and anyone who wants the lowest price per kilogram.</li>
                    <li><strong>Good to know:</strong> uses less water and power, and you can wash and spin two loads at the same time.</li>
                </ul>
                {$img($semi, 'Yara semi automatic twin tub washing machines')}
                <p>Yara semi automatic machines range from 7 kg to 11 kg, with rust-free bodies, lint filters and built-in spin dryers.</p>
                {$img($highlights, 'Yara 7 kg twin tub semi automatic washing machine')}

                <h2>Fully automatic top load</h2>
                <p>Load the clothes, choose a programme and walk away. A top load machine fills, washes, rinses and spins on its own, and you can add a forgotten sock mid-wash.</p>
                <ul>
                    <li><strong>Best for:</strong> busy households with a steady water supply that want convenience at a sensible price.</li>
                    <li><strong>Good to know:</strong> needs a tap connection; easy to load without bending down.</li>
                </ul>

                <h2>Fully automatic front load</h2>
                <p>A front load machine tumbles clothes through a small amount of water instead of agitating them in a full tub. That is gentler on fabric and uses the least water of the three types.</p>
                <ul>
                    <li><strong>Best for:</strong> the cleanest wash, delicate clothes, and fitting under a counter.</li>
                    <li><strong>Good to know:</strong> costs more up front and cycles take longer, but water and detergent use are lowest. Yara front loaders use quiet, efficient BLDC motors.</li>
                </ul>
                {$img($fully, 'Yara fully automatic front load and top load washing machines')}

                <h2>Which capacity do you need?</h2>
                <ul>
                    <li><strong>6.5 to 7 kg:</strong> 2 to 3 people</li>
                    <li><strong>7.5 to 8.5 kg:</strong> 3 to 5 people</li>
                    <li><strong>9 kg and above:</strong> 5 or more people, or if you wash bedsheets, blankets and curtains at home</li>
                </ul>
                <blockquote>Tip: capacity is the weight of dry clothes the drum can take. A slightly bigger drum than you need gives clothes room to move, so they come out cleaner and less creased.</blockquote>

                <h2>In short</h2>
                <ul>
                    <li>Limited water or budget, or a big family: <a href="/category/semi-automatic">semi automatic</a></li>
                    <li>Convenience at a fair price: <a href="/category/fully_automatic">fully automatic top load</a></li>
                    <li>Best wash quality and lowest water use: <a href="/category/fully_automatic">fully automatic front load</a></li>
                </ul>
                <p>See the full <a href="/category/washing-machine">Yara washing machine range</a>, from compact 6.5 kg washers to 11 kg twin tubs.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ 7. LED wall pixel pitch

    private function ledPixelPitchGuide(): void
    {
        $slug = 'led-video-wall-pixel-pitch-guide';
        $cover = $this->publish('led-video-walls/home-banner.jpg', 'blog/led-pixel-pitch-cover.jpg');
        $indoor = $this->publish('led-video-walls/home-indoor.jpg', 'blog/content/led-indoor.jpg');
        $outdoor = $this->publish('led-video-walls/home-outdoor.jpg', 'blog/content/led-outdoor.jpg');
        $stage = $this->publish('led-video-walls/home-stage.jpg', 'blog/content/led-stage.jpg');
        $img = $this->figure(...);

        Post::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => 'P1.25 to P10: How to Choose the Right Pixel Pitch for an LED Video Wall',
                'category' => 'LED Walls',
                'author' => 'Yara Electronics',
                'excerpt' => 'Pixel pitch decides how sharp an LED wall looks and how much it costs. Here is how to choose it from one number: how far away your audience will stand.',
                'cover_image' => $cover,
                'meta_title' => 'LED Video Wall Pixel Pitch Guide: P1.25, P2.5, P4, P10 Explained',
                'meta_description' => 'What pixel pitch means, how viewing distance decides the right pitch, and which LED wall suits boardrooms, retail, events and outdoor billboards.',
                'is_published' => true,
                'published_at' => Post::where('slug', $slug)->value('published_at') ?? now()->subHours(3),
                'content' => <<<HTML
                <p>When you ask for an LED video wall quote, the first question is always "which pitch?". Pixel pitch is the one number that decides how sharp the wall looks, where it works best and a large part of its price.</p>

                <h2>What is pixel pitch?</h2>
                <p>Pixel pitch is the distance, in millimetres, from the centre of one LED pixel to the next. A <strong>P2.5</strong> wall has pixels 2.5 mm apart; a <strong>P10</strong> wall, 10 mm apart. The smaller the number, the more pixels fit in each square metre, the sharper the picture up close, and the higher the cost.</p>

                <h2>The simple rule: distance decides pitch</h2>
                <p>Your audience's viewing distance tells you which pitch you need:</p>
                <ul>
                    <li><strong>Closest comfortable distance:</strong> about 1 metre for every 1 mm of pitch. A P2.5 wall looks seamless from about 2.5 m away.</li>
                    <li><strong>Best viewing distance:</strong> about 3 times that. A P2.5 wall looks its very best from around 7.5 m.</li>
                </ul>
                <blockquote>Paying for a finer pitch than your audience can see is the most common way to overspend on an LED wall. If nobody stands closer than 5 m, P4 or P5 will look just as sharp as P2.5, for a lot less.</blockquote>

                <h2>Which pitch for which space</h2>
                <h3>Fine pitch indoor: P1.25 to P1.86</h3>
                <p>For boardrooms, control rooms, TV studios, corporate lobbies and experience centres, where people stand or sit within a few metres and the wall shows text, dashboards and video calls.</p>
                {$img($indoor, 'A fine-pitch Yara LED wall in a corporate interior')}

                <h3>Indoor: P2.5</h3>
                <p>The all-rounder for retail stores, malls, auditoriums and places of worship: sharp at a few metres and affordable at large sizes.</p>

                <h3>Rental and stage: P2.6 indoor and P3.91 outdoor</h3>
                <p>Built in die-cast aluminium cabinets (500 × 500 mm indoor, 500 × 1000 mm IP65 outdoor) that lock together quickly, for events, weddings, conferences, concerts and open-air stages.</p>
                {$img($stage, 'A Yara rental LED wall as a concert stage backdrop')}

                <h3>Outdoor: P4 to P10</h3>
                <p>High-brightness, weatherproof walls for storefronts and building facades (P4 to P5), and roadside billboards, highway hoardings and stadium scoreboards (P8 to P10), where the audience is tens of metres away and brightness matters more than pixel density.</p>
                {$img($outdoor, 'A Yara outdoor LED wall on a building facade')}

                <h2>Other things to check</h2>
                <ul>
                    <li><strong>Brightness (nits):</strong> indoor walls need far less than outdoor walls in direct sun. Yara indoor walls run at 600 to 900 nits, outdoor walls at 4,500 to 7,000 nits.</li>
                    <li><strong>Refresh rate:</strong> 3840 Hz and above avoids flicker on camera, important for stages and studios.</li>
                    <li><strong>Front or rear maintenance:</strong> front-serviceable walls can be mounted flat against a wall.</li>
                    <li><strong>Size and aspect ratio:</strong> LED walls are built from modules, so they can be made to almost any size.</li>
                </ul>
                <p>Use the <a href="/led-wall-calculator">LED wall calculator</a> to work out the size, resolution and module count for your space, or explore the <a href="/led-video-walls">Yara LED video wall range</a> from P1.25 to P10.</p>
                HTML,
            ]
        );
    }

    // ------------------------------------------------------------------ helpers

    private function figure(string $path, string $caption): string
    {
        return '<figure><img src="/storage/' . $path . '" alt="' . e($caption) . '"><figcaption>' . e($caption) . '</figcaption></figure>';
    }

    /**
     * Copy an asset to the public disk and return its stored path.
     */
    private function publish(string $asset, string $target): string
    {
        Storage::disk('public')->put($target, file_get_contents(self::ASSETS . '/' . $asset));

        return $target;
    }
}
