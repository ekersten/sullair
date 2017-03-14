<?php
/**
 * Created by IntelliJ IDEA.
 * User: ego
 * Date: 06-Mar-17
 * Time: 12:17
 */

namespace Modules\Admin\Filters;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;


class MenuPermissionFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (! $this->isVisible($item)) {
            return false;
        }

        if (isset($item['header'])) {
            $item = $item['header'];
        }

        return $item;
    }

    protected function isVisible($item) {
        if ($user = Sentinel::getUser()) {
            if (isset($item['can'])) {
                return $user->hasAccess($item['can']) || $user->inRole('superadmin');
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}