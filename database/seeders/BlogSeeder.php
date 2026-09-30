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
