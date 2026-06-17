<?php

use DomainProvider\Models\Setting;
use Illuminate\Support\Str;

class SettingTableSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'keyword' => 'free, domain, dns, management',
            'description' => 'Domain Provider - Free Domain and DNS Management',
            'page_title' => 'Domain Provider',
            'lead_text' => 'Get Free Domain & DNS Management',
            'middle_title' => 'Get Free Domain name with No Ads',
            'middle_body' => 'Support for A, AAAA, CNAME, MX, NS, TXT',
            'footer_left_title' => 'Contact',
            'footer_left_body' => '234 Hidden Pond Road, Ashland City, TN 37015<div>email: contact@example.com</div><div>GMT 09:00AM - 06:00PM</div>',
            'footer_right_title' => 'About Us',
            'footer_right_body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pellentesque neque eget diam posuere porta. Quisque ut nulla at nunc vehicula lacinia. Proin adipiscing porta tellus, ut feugiat nibh adipiscing sit amet. In eu justo a felis faucibus ornare vel id metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In eu libero ligula.',
            'footer_social_title' => 'Follow me',
            'footer_social_facebook' => 'http://facebook.com/studionesia',
            'footer_social_twitter' => 'http://twitter.com/studionesia',
            'footer_social_googleplus' => 'http://plus.google.com',
            'footer_social_pinterest' => 'http://pinterest.com',
            'footer_social_linkedin' => 'http://linkedin.com',
            'footer_social_instagram' => 'http://instagram.com',
            'footer_social_youtube' => 'http://youtube.com/',
        ]);

        $this->set('setting', $setting);
    }

    public function remove()
    {
        Setting::whereNotNull('id')->delete();
    }
}
