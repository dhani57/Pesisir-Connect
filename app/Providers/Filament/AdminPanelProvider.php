<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\MenuItem;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Sky,
                'danger' => Color::Rose,
                'accent' => Color::Rose,
            ])
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make('Laporan & Transaksi')->collapsible(),
                \Filament\Navigation\NavigationGroup::make('Manajemen Pengguna')->collapsible(),
                \Filament\Navigation\NavigationGroup::make('Manajemen Konten')->collapsible(),
            ])
            ->globalSearch(false)
            ->breadcrumbs(false)
            ->font('Plus Jakarta Sans')
            ->darkMode(false)
            ->defaultAvatarProvider(\App\Filament\AvatarProviders\CustomAvatarProvider::class)
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('Profil Saya')
                    ->url(fn (): string => route('profile.edit')),
                'logout' => MenuItem::make()
                    ->label('Keluar')
                    ->color('danger'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // Widgets are auto-discovered from App\Filament\Widgets
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
