<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Option;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\User;

class   OrderController extends BaseModuleController
{
    protected $moduleName = 'orders';
    protected $showOnlyParentItemsInBrowsers = true;
    protected $nestedItemsDepth = 1;
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->enableReorder();
        $this->disableCreate();
    }



    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */

    public function getCreateForm(): Form
    {
        return Form::make([
            Input::make()->name('title')->label('Title'),
            Input::make()->name('user_id')->label('User_id'),
            Select::make()->name('morphable_type')->options(
                Options::make([
                    Option::make('App\\Models\\Product', 'Product'),
                    Option::make('App\\Models\\Service', 'Service')
                ])
            ),
            Input::make()->name('morphable_id')->label('Product/Service'),
            Input::make()->name('status')->label('Status'),
            Input::make()->name('quantity')->label('Quantity'),
            Input::make()->name('position')->label('Position'),
            Wysiwyg::make()->name('description')->label('Description')
        ]);
    }

    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);
        return Form::make([
            Input::make()->name('type')->label('Type'),
            Input::make()->name('title')->label('Title'),
            Input::make()->name('user_id')->label('User_id'),
            Input::make()->name('status')->label('Status'),
            Input::make()->name('quantity')->label('Quantity'),
            Input::make()->name('position')->label('Position'),
            Wysiwyg::make()->name('description')->label('Description')
        ]);


    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('title')->title('Title')
        );

        $table->add(
            Text::make()->field('user_id')->title('USER')->customRender(function ($order) {
                $user = User::find($order->user_id);
                return $user ? $user->name : 'Unknown';
            }),
        );

        $table->add(
            Text::make()->field('morphable_type')->title('Product/Service')->customRender(function ($order) {
                $type = explode('\\', $order->orderable_type);
                $type = end($type);
                return "$type: " . $order->orderable;
            })
        );

        $table->add(
            Text::make()->field('status')->title('Status')
        );

        $table->add(
            Text::make()->field('quantity')->title('Details')
        );

        $table->add(
            Text::make()->field('position')->title('Position')
        );

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }
}
