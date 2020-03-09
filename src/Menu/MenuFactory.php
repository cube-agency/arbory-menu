<?php

namespace CubeAgency\ArboryMenu\Menu;

use Arbory\Base\Nodes\Node;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class MenuFactory
{
    /** @var Menu */
    protected $menu;

    /**
     * MenuFactory constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return Collection
     */
    public function build(): Collection
    {
        $items = $this->menu->items()->with('relation.related')->get()
            ->map(function (Item $item) {
                $link = $item->link;
                $name = $item->name;
                if ($item->relation) {
                    /** @var Node $node */
                    $node = $item->relation->getAttribute('related');
                    if ($node !== null && $node instanceof Node) {
                        $link = $link ?? $node->getUrl('index');
                        $name = $name ?? $node->name;
                    }
                }
                if (!empty($link) && !empty($name)) {
                    return [
                        'link' => $link,
                        'name' => $name,
                        'active' => $this->isActive($link)
                    ];
                }
                return false;
            })
            ->filter();

        return $items;
    }

    /**
     * Detects if is active by uri
     * @param $link
     * @return bool
     */
    protected function isActive($link): bool
    {
        if (empty($link)) {
            return false;
        }
        $uri = Request::fullUrl();
        $pathParts = explode('?', $uri);
        $path = trim(reset($pathParts), '/ ');
        return strpos($path, $link) === 0;
    }

}
