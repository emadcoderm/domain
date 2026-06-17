<?php

Route::group(['prefix' => 'install'], function () {
    Route::get('/', [
        'as' => 'install_index',
        function () {
            try {
                Artisan::call('config:clear', ['--env' => 'production']);
                Artisan::call('route:clear', ['--env' => 'production']);
            } catch (\Exception $e) {
            }

            return view('install.index');
        }
    ]);

    Route::post('/', [
        'as' => 'install_change',
        function (\Illuminate\Http\Request $request) {
            $v = Validator::make($request->all(), [
                'host' => 'required',
                'username' => 'required',
                'password' => 'required',
                'name' => 'required',
                'admin_full_name' => 'required|max:255',
                'admin_email' => 'required|email|max:255',
                'admin_password' => 'required',
            ]);

            if ($v->fails()) {
                return redirect()->back()
                    ->withInput($request->except(['_token']))
                    ->withErrors($v->errors());
            }

            // process the input
            $path = base_path('.env');

            if (!is_writeable($path)) {
                return redirect()->back()
                    ->withInput($request->except(['_token']))
                    ->withErrors($path . ' not writeable.');
            }

            try {
                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        'DB_HOST='.env('DB_HOST'),
                        'DB_HOST='.$request->host,
                        file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'DB_DATABASE='.env('DB_DATABASE'),
                        'DB_DATABASE='.$request->name,
                        file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'DB_USERNAME='.env('DB_USERNAME'),
                        'DB_USERNAME='.$request->username,
                        file_get_contents($path)
                    ));
                    file_put_contents($path, str_replace(
                        'DB_PASSWORD='.env('DB_PASSWORD'),
                        'DB_PASSWORD='.$request->password,
                        file_get_contents($path)
                    ));
                }
            } catch (\Exception $e) {
            }

            return redirect(route('install_process'))
                ->with('request', $request->except(['_token']));
        }
    ]);

    Route::get('/process', [
        'as' => 'install_process',
        function () {
            $request = Session::get('request');

            if (!$request) {
                abort(404);
            }

            // test db connection
            try {
                DB::connection()->getDatabaseName();
            } catch (Exception $e) {
                return redirect(route('install_index'))
                    ->withInput($request)
                    ->withErrors($e->getMessage());
            }

            // migrate, db:seed
            Artisan::call('migrate', ['--force' => true, '-n' => true, '--env' => 'production']);
            Artisan::call('db:seed', ['--force' => true, '-n' => true, '--env' => 'production', '--class' => 'ProductionSeeder']);

            return redirect(route('install_success'))
                ->with('request', $request);
        }
    ]);

    Route::get('success', [
        'as' => 'install_success',
        function () {
            $request = Session::get('request');

            if (!$request) {
                abort(404);
            }

            // regenerate key for security
            Artisan::call('key:generate');

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

            return view('install.success', compact('request', 'removeFiles'));
        }
    ]);
});
