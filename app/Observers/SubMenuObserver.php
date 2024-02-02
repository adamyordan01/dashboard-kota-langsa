<?php

namespace App\Observers;

use App\Models\SubMenu;

class SubMenuObserver
{
    public function creating(SubMenu $subMenu): void
    {
        if (is_null($subMenu->order)) {
            $subMenu->order = SubMenu::where('menu_id', $subMenu->menu_id)->max('order') + 1;
            return;
        }

        $lowerSubMenu = SubMenu::where('menu_id', $subMenu->menu_id)
            ->where('order', '>=', $subMenu->order)
            ->get();

        foreach ($lowerSubMenu as $lower) {
            $lower->order++;
            $lower->saveQuietly();
        }
    }

    public function updating(SubMenu $subMenu): void
    {
        if ($subMenu->isClean('order')) {
            return;
        }

        if (is_null($subMenu->order)) {
            $subMenu->order = SubMenu::where('menu_id', $subMenu->menu_id)->max('order');
        }

        if ($subMenu->getOriginal('order') > $subMenu->order) {
            $orderRange = [
                $subMenu->order,
                $subMenu->getOriginal('order')
            ];
        } else {
            $orderRange = [
                $subMenu->getOriginal('order'),
                $subMenu->order
            ];
        }

        $lowerSubMenu = SubMenu::where('menu_id', $subMenu->menu_id)
            ->where('id', '!=', $subMenu->id)
            ->whereBetween('order', $orderRange)
            ->get();

        foreach ($lowerSubMenu as $lower) {
            if ($subMenu->getOriginal('order') < $subMenu->order) {
                $lower->order--;
            } else {
                $lower->order++;
            }

            $lower->saveQuietly();
        }
    }


    public function deleted(SubMenu $subMenu): void
    {
        //
    }

    /**
     * Handle the SubMenu "restored" event.
     */
    public function restored(SubMenu $subMenu): void
    {
        //
    }

    /**
     * Handle the SubMenu "force deleted" event.
     */
    public function forceDeleted(SubMenu $subMenu): void
    {
        //
    }
}
