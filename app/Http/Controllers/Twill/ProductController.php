<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Product;

class ProductController extends BaseModuleController
{
    protected $moduleName = 'products';
    protected $showOnlyParentItemsInBrowsers = true;
    protected $nestedItemsDepth = 1;

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->enableReorder();
        $this->disablePermalink();
    }

    /**
     * This method returns the form fields when creating a product.
     */
    public function getCreateForm(): Form
    {
        return Form::make([
            Input::make()->name('name')->label('Product Name'),
            Input::make()->name('type')->label('Type'),
            Input::make()->name('price')->label('Price'),
            Input::make()->name('color')->label('Color'),
            Input::make()->name('size')->label('Size'),
            Input::make()->name('stock')->label('Stock'),
            Input::make()->name('image')->label('Image'), // Uncomment this if needed
            Wysiwyg::make()->name('description')->label('Description')
        ]);
    }

    /**
     * This method returns the form fields when editing a product.
     */
    public function getForm(TwillModelContract $model): Form
    {
        return Form::make([
            Input::make()->name('name')->label('Product Name'),
            Input::make()->name('type')->label('Type'),
            Input::make()->name('title')->label('Title'),
            Input::make()->name('price')->label('Price'),
            Input::make()->name('color')->label('Color'),
            Input::make()->name('size')->label('Size'),
            Input::make()->name('stock')->label('Stock'),
            Input::make()->name('image')->label('Image')->required(false), // image is optional
            Wysiwyg::make()->name('description')->label('Description')
        ]);
    }

    /**
     * This method defines additional columns for the index table.
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
            Text::make()->field('color')->title('Color')
        );
        $table->add(
            Text::make()->field('size')->title('Size')
        );
        $table->add(
            Text::make()->field('stock')->title('Stock')
        );
        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }
}
