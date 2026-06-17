<?php

namespace DomainProvider\Http\Controllers\Admin;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Kris\LaravelFormBuilder\FormBuilder;

class BaseController extends Controller
{
    /**
     * render admin route
     *
     * @param string $route
     * @param array|null $params
     * @return string
     */
    protected function route($route, array $params = null)
    {
        return route('admin.'.$route, $params);
    }

    /**
     * Render response to display list of $data
     *
     * @param Repository|Model $data
     * @param string $view
     * @return Response
     */
    protected function defaultIndex($data, $view)
    {
        $var = camel_case(explode('.', $view)[1].'s');

        ${$var} = $data->paginate(15);

        return view($view, compact($var));
    }

    /**
     * Render the form to $view when create new record
     *
     * @param FormBuilder $formBuilder
     * @param string $formName
     * @param string $view
     * @return Response
     */
    protected function defaultCreate(FormBuilder $formBuilder, $formName, $view)
    {
        $form = $formBuilder->create($formName, [
            'method' => 'POST',
            'url' => $this->route(explode('.', $view)[1] . '.store'),
        ]);

        return view($view, compact('form'));
    }

    /**
     * Render the form to $view when edit a record
     *
     * @param FormBuilder $formBuilder
     * @param Model $model
     * @param string $formName
     * @param string $view
     * @param string $modelName
     * @return Response
     */
    protected function defaultEdit(FormBuilder $formBuilder, Model $model, $formName, $view, $modelName = null)
    {
        $form = $formBuilder->create($formName, [
            'method' => 'PUT',
            'url' => $this->route(explode('.', $view)[1] . '.update', ['id' => $model->id]),
            'model' => $model,
        ]);

        if ($modelName) {
            return view($view, ['form' => $form, $modelName => $model]);
        } else {
            return view($view, compact('form'));
        }
    }

    /**
     * Flash message when successful execute the action
     *
     * @param string $action
     * @param string $menu
     * @return string
     */
    public function returnMessage($action, $menu)
    {
        $menu = trans('admin.menu.'.$menu);
        switch ($action) {
            case 'store':
                return trans('admin.return_message.success_store', ['menu' => $menu]);
            case 'update':
                return trans('admin.return_message.success_update', ['menu' => $menu]);
            case 'destroy':
                return trans('admin.return_message.success_destroy', ['menu' => $menu]);
        }

        return sprintf("%s successfully %s", $menu, $action);
    }
}
