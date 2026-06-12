<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class CustomAvatarProvider implements AvatarProvider
{
    public function get(Model|Authenticatable $record): string
    {
        $name = urlencode($record->name ?? 'User');
        return "https://ui-avatars.com/api/?name={$name}&color=FFFFFF&background=0ea5e9&length=1";
    }
}
