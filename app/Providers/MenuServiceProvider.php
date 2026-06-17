<?php
namespace DomainProvider\Providers;

use Auth;
use Cache;
use DomainProvider\Repositories\ContactRepository;
use DomainProvider\Repositories\PageRepository;
use Illuminate\Support\ServiceProvider;
use Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(ContactRepository $contactRepository, PageRepository $pageRepository)
    {
        // main menu
        view()->composer('front.partials.menu', function () use ($pageRepository) {
            Menu::make('main', function ($menu) use ($pageRepository) {
                $menu->add(trans('front.menu.home'), ['route' => 'home'])
                    ->data('permissions', ['guest', 'auth']);

                $pages = Cache::remember('menu_pages', env('CACHE_REMEMBER', 10), function () use ($pageRepository) {
                    return $pageRepository->all(['slug', 'title']);
                });

                foreach ($pages as $page) {
                    $menu->add($page->title, ['route' => ['page.show', 'slug' => $page->slug]])
                    ->data('permissions', ['guest', 'auth']);
                }

                $menu->add(trans('front.menu.contact_us'), ['route' => 'contact'])
                    ->data('permissions', ['guest', 'auth']);

                $menu->add(trans('front.menu.log_in'), ['route' => 'user.login'])
                    ->data('permissions', ['guest'])
                    ->data('class', 'btn');

                $menu->add(trans('front.menu.sign_up'), ['route' => 'user.register'])
                    ->data('permissions', ['guest'])
                    ->data('class', 'btn btn-action')
                    ->data('style', 'color: #FFFFFF;');

                $menu->add(Auth::user() ? Auth::user()->full_name : '', ['route' => 'user.dashboard'])
                    ->data('permissions', ['auth'])
                    ->data('class', 'btn');
            })
            ->filter(function ($item) {
                if (is_null(Auth::user())) {
                    return in_array('guest', $item->data('permissions'));
                } else {
                    return in_array('auth', $item->data('permissions'));
                }
            });
        });

        // user dashboard
        view()->composer('front.partials.dashboard_sidebar', function () {
            Menu::make('user_dashboard', function ($menu) {
                // $menu->add('Dashboard', ['route' => 'user.dashboard'])
                //     ->icon('dashboard')
                //     ->data('permissions', ['user', 'admin']);

                $menu->add(trans('front.menu.domain'), ['route' => 'user.domain.list'])
                    ->icon('globe')
                    ->data('permissions', ['user', 'admin']);

                $menu->add(trans('front.menu.profile'), ['route' => 'user.edit.profile'])
                    ->icon('user')
                    ->data('permissions', ['user', 'admin']);

                $menu->add(trans('front.menu.admin'), ['route' => 'admin.dashboard'])
                    ->icon('gears')
                    ->data('permissions', ['admin']);

                $menu->add(trans('front.menu.log_out'), ['route' => 'user.logout'])
                    ->icon('power-off')
                    ->data('permissions', ['user', 'admin']);
            })
            ->filter(function ($item) {
                if (!is_null(Auth::user())) {
                    if (Auth::user()->isAdmin()) {
                        return in_array('admin', $item->data('permissions'));
                    } else {
                        return in_array('user', $item->data('permissions'));
                    }
                }
            });
        });

        // admin dashboard
        view()->composer('admin.partials.dashboard_sidebar', function () use ($contactRepository) {
            Menu::make('admin_dashboard', function ($menu) use ($contactRepository) {
                $admin = 'admin.';

                $menu->add(trans('admin.menu.dashboard'), ['route' => $admin.'dashboard'])
                    ->icon('dashboard');

                $master = trans('admin.menu.master');

                $menu->add($master)
                    ->icon('server');

                $master = camel_case($master);
                $menu->{$master}->add(trans('admin.menu.api_key'), ['route' => $admin.'apikey.index'])
                    ->icon('key');

                $menu->{$master}->add(trans('admin.menu.zone'), ['route' => $admin.'zone.index'])
                    ->icon('list-ul');

                $menu->{$master}->add(trans('admin.menu.blacklist_domain'), ['route' => $admin.'blacklist-domain.index'])
                    ->icon('ban');

                $menu->add(trans('admin.menu.setting'), ['route' => $admin.'setting.index'])
                    ->icon('gear');

                $menu->add(trans('admin.menu.user'), ['route' => $admin.'user.index'])
                    ->icon('users');

                $menu->add(trans('admin.menu.page'), ['route' => $admin.'page.index'])
                    ->icon('file-text');

                $messageMenu = $menu->add(trans('admin.menu.message'), ['route' => $admin.'contact.index'])
                    ->icon('envelope');

                if (($total = $contactRepository->getCountUnread())) {
                    $messageMenu->data('label', ['blue', $total]);
                }

                $menu->add(trans('admin.menu.log_out'), ['route' => 'user.logout'])
                    ->icon('power-off');
            });
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
