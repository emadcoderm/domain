<?php

Route::group(['prefix' => 'upgrade'], function () {
    Route::get('/', [
        'as' => 'upgrade_index',
        function () {
            try {
                Artisan::call('config:clear', ['--env' => 'production']);
                Artisan::call('route:clear', ['--env' => 'production']);
            } catch (\Exception $e) {
            }

            return view('upgrade.index');
        }
    ]);

    Route::post('/process', [
        'as' => 'upgrade_process',
        function () {
            // migrate
            Artisan::call('migrate', ['--force' => true, '-n' => true, '--env' => 'production']);

            // for google recaptcha key
            $env = rtrim(base_path(), '/').'/.env';

            if (!is_writeable($env)) {
                return redirect()->back()
                    ->withErrors($env . ' not writeable.');
            }

            try {
                if (is_file($env)) {
                    if (!env('NOCAPTCHA_SECRET') && !env('NOCAPTCHA_SITEKEY')) {
                        file_put_contents($env, "\nNOCAPTCHA_SITEKEY=\nNOCAPTCHA_SECRET=\n", FILE_APPEND);
                    }
                }
            } catch (\Exception $e) {
            }

            return redirect(route('upgrade_success'))
                ->with('key', 'key');
        }
    ]);

    Route::get('success', [
        'as' => 'upgrade_success',
        function () {

            $key = Session::get('key');

            if (!$key) {
                abort(404);
            }

            try {
                // optimize
                Artisan::call('optimize', ['--force' => true, '--env' => 'production']);
                Artisan::call('config:cache', ['--env' => 'production']);
                Artisan::call('route:cache', ['--env' => 'production']);
            } catch (\Exception $e) {
            }

            $removeFiles = [];
            if (is_file($install = app_path('Http/Routes/front/install.php'))) {
                $removeFiles[] = $install;
            }

            if (is_file($upgrade = app_path('Http/Routes/front/upgrade.php'))) {
                $removeFiles[] = $upgrade;
            }

            return view('upgrade.success', compact('removeFiles'));
        }
    ]);
});
