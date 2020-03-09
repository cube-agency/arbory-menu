<?php

namespace CubeAgency\ArboryMenu\Http\Controllers\Admin;

use Arbory\Base\Nodes\Node;
use Arbory\Base\Admin\Form;
use Arbory\Base\Admin\Form\FieldSet;
use Arbory\Base\Admin\Grid;
use CubeAgency\ArboryMenu\Menu\Menu;
use Illuminate\Routing\Controller;
use Arbory\Base\Admin\Traits\Crudify;

class MenuController extends Controller
{
    use Crudify;

    /**
     * @var string
     */
    protected $resource = Menu::class;

    /**
     * @param Form $form
     * @return Form
     */
    protected function form(Form $form)
    {
        $form->setFields(function (FieldSet $fields) {
            $fields->text('name')->rules('required');
            $fields->hasMany('items', function (FieldSet $fields) {
                $fields->objectRelation('node', Node::class, 1);
                $fields->text('name')->rules('required_without:resource.items.*.node.related_id');
                $fields->text('link')->rules('nullable|url|required_without:resource.items.*.node.related_id')
                    ->setLabel('link (replaces the node field value)');
            })->sortable('position');
        });

        return $form;
    }

    /**
     * @param Grid $grid
     */
    public function grid(Grid $grid)
    {
        $grid->column('name');
    }
}
