<?php

namespace App\Observers;

use App\Models\Menu;
use Illuminate\Support\Str;

class MenuObserver
{
    public function creating(Menu $menu): void
    {
        if (is_null($menu->order)) {
            $menu->order = Menu::max('order') + 1;
            return;
        }

        $lowerMenu = Menu::where('order', '>=', $menu->order)->get();

        foreach ($lowerMenu as $lower) {
            $lower->order++;
            $lower->saveQuietly();
        }
    }

    public function updating(Menu $menu): void
    {
        if ($menu->isClean('order')) {
            return;
        }

        if (is_null($menu->order)) {
            $menu->order = Menu::max('order');
        }

        if ($menu->getOriginal('order') > $menu->order) {
            $orderRange = [
                $menu->order,
                $menu->getOriginal('order')
            ];
        } else {
            $orderRange = [
                $menu->getOriginal('order'),
                $menu->order
            ];
        }

        $lowerMenu = Menu::where('id', '!=', $menu->id)
            ->whereBetween('order', $orderRange)
            ->get();

        foreach ($lowerMenu as $lower) {
            if ($menu->getOriginal('order') < $menu->order) {
                $lower->order--;
            } else {
                $lower->order++;
            }

            $lower->saveQuietly();
        }
    }

    /**
     * Handle the Menu "created" event.
     */
    public function created(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "updated" event.
     */
    public function updated(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "deleted" event.
     */
    public function deleted(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "restored" event.
     */
    public function restored(Menu $menu): void
    {
        //
    }

    /**
     * Handle the Menu "force deleted" event.
     */
    public function forceDeleted(Menu $menu): void
    {
        //
    }
}
