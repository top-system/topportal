<?php

use Illuminate\Database\Seeder;
use TopSystem\TopAdmin\Models\Menu;
use TopSystem\TopAdmin\Models\MenuItem;

class PortalMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Menu Item
        $menu = Menu::where('name', 'admin')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Portal',
            'url'     => '',
            'route'   => 'admin.portal.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'admin-news',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 6,
            ])->save();
        }
        MenuItem::where('route','admin.categories.index')->update([
            'parent_id' => $menuItem->id
        ]);
        MenuItem::where('route','admin.posts.index')->update([
            'parent_id' => $menuItem->id
        ]);
        MenuItem::where('route','admin.pages.index')->update([
            'parent_id' => $menuItem->id
        ]);
        MenuItem::where('route','admin.tags.index')->update([
            'parent_id' => $menuItem->id
        ]);
    }
}
