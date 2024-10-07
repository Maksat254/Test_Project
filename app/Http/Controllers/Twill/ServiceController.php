<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\NestedModuleController as BaseModuleController;

class ServiceController extends BaseModuleController
{
    protected $moduleName = 'services';
    protected $showOnlyParentItemsInBrowsers = true;
    protected $nestedItemsDepth = 1;
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->enableReorder();
    }



    public function getCreateForm(): Form
    {
        return Form::make([
            Input::make()->name('name')->label('Name'),
            Input::make()->name('title')->label('Title'),
            Input::make()->name('price')->label('Price'),
            Input::make()->name('position')->label('Position'),
            Input::make()->name('project_example')->label('Project_example'),
            Input::make()->name('duration')->label('Duration'),
            Wysiwyg::make()->name('description')->label('Description')
        ]);
    }


    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        return Form::make([
            Input::make()->name('name')->label('Name'),
            Input::make()->name('title')->label('Title'),
            Input::make()->name('price')->label('Price'),
            Input::make()->name('position')->label('Position'),
            Input::make()->name('project_example')->label('Project_example'),
            Input::make()->name('duration')->label('Duration'),
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
            Text::make()->field('name')->title('Name')
        );
        $table->add(
            Text::make()->field('price')->title('Price')
        );
        $table->add(
            Text::make()->field('position')->title('Position')
        );
        $table->add(
            Text::make()->field('duration')->title('Duration')
        );
        $table->add(
            Text::make()->field('project_example')->title('Project_example')
        );
        $table->add(
            Text::make()->field('description')->title('Description')
        );
        $table->add(
            Text::make()->field('title')->title('Title')
        );
        return $table;
    }
}
