<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Http\Requests\Admin\SettingRequest;
use DomainProvider\Models\Setting;
use DomainProvider\Repositories\SettingRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class SettingController extends BaseController
{
    private $settingRepository;

    /**
     * [DependencyInjection]
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Display a listing of the Setting.
     *
     * @return Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $setting = $this->settingRepository->findOneForList();

        return $this->defaultEdit($formBuilder, $setting, 'Admin\SettingForm', 'admin.setting.index', 'settings');
    }

    /**
     * Show the form for creating a new Setting.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created Setting in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified Setting.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified Setting.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function edit(Setting $setting, FormBuilder $formBuilder)
    {
        return $this->defaultEdit($formBuilder, $setting, 'Admin\SettingForm', 'admin.setting.form', 'settings');
    }

    /**
     * Update the specified Setting in storage.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function update(Setting $setting, SettingRequest $request)
    {
        $settings = $request->except(['_token', '_method', '_wysihtml5_mode']);

        if ($request->has('captcha_on_register')) {
            $settings['captcha_on_register'] = 1;
        } else {
            $settings['captcha_on_register'] = 0;
        }

        if ($request->has('captcha_on_login')) {
            $settings['captcha_on_login'] = 1;
        } else {
            $settings['captcha_on_login'] = 0;
        }

        $this->settingRepository->update($settings, $setting->id);

        return redirect($this->route('setting.index'))
            ->with('success', $this->returnMessage('update', 'setting'));
    }

    /**
     * Remove the specified Setting from storage.
     *
     * @param  Setting $setting
     * @return Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
