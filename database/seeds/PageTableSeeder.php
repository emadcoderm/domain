<?php

use DomainProvider\Models\Page;
use Illuminate\Support\Str;

class PageTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aboutTitle = 'About Us';
        $aboutUs = Page::create([
            'title' => $aboutTitle,
            'slug' => Str::slug($aboutTitle),
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc vehicula lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In eu libero ligula.',
            'key' => 'page-about-us',
        ]);
        $this->set('page-about-us', $aboutUs);
    }

    public function remove()
    {
        Page::whereNotNull('id')->delete();
    }
}
