<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeAdminWidget extends Widget
{
    protected static ?int $sort = -1;
    protected int | string | array $columnSpan = 'full';
    
    protected string $view = 'filament.widgets.welcome-admin-widget';
}
