<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token">
        <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-base-200/50 dark:bg-base-200/75 font-[verdana] antialiased">

        {{-- The navbar with `sticky` and `full-width` --}}
        <x-nav full-width sticky>

            <x-slot:brand>
                {{-- Drawer toggle for "sidebar-drawer" --}}
                <label class="mr-3 lg:hidden" for="main-drawer">
                    <x-icon class="cursor-pointer" name="o-bars-3" />
                </label>
                <!-- APP LOGO -->
                <x-app-logo />

            </x-slot:brand>

            {{-- Right side actions --}}
            <x-slot:actions>
                <x-menus.lang-menu />
                <x-theme-toggle class="btn-ghost btn-sm" darkTheme="mydark" lightTheme="mylight" />
                <x-menus.user-menu />
            </x-slot:actions>
        </x-nav>

        {{-- The main content with `full-width` --}}
        <x-main full-width with-nav>

            {{-- This is a sidebar that works also as a drawer on small screens --}}
            {{-- Notice the `main-drawer` reference here --}}
            <x-slot:sidebar class="bg-base-300" collapsible drawer="main-drawer">

                {{-- Activates the menu item when a route matches the `link` property --}}
                <x-menu :title="null" activate-by-route>
                    <x-menu-item icon="gmdi.shopping-cart-o" link="/" title="{{ __('labels.orders') }}" />

                    <x-menu-item icon="gmdi.food-bank-o" link="{{ route('transactions.index') }}"
                        title="{{ __('labels.transanctions') }}" />

                    <x-menu-sub icon="gmdi.menu-book-o" title="{{ __('labels.menu') }}">
                        <x-menu-item icon="gmdi.restaurant-menu-o" link="{{ route('menu.index') }}"
                            title="{{ __('labels.menu_items') }}" />
                        <x-menu-item icon="gmdi.settings-input-component-o" link="{{ route('sections.index') }}"
                            title="{{ __('labels.menu_sections') }}" />
                        <x-menu-item icon="gmdi.discount-o" link="{{ route('sides.index') }}"
                            title="{{ __('labels.menu_sides') }}" />
                    </x-menu-sub>

                    <x-menu-item icon="o-presentation-chart-bar" link="###"
                        title="{{ __('labels.statistics') }}" />

                    @can('manage_settings')
                        <x-menu-sub icon="gmdi.construction-o" title="{{ __('labels.settings') }}">
                            <x-menu-item icon="o-credit-card" link="{{ route('settings.payment.methods') }}"
                                title="{{ __('labels.payment_methods') }}" />
                            <x-menu-item icon="gmdi.location-on-o" link="{{ route('settings.table.locations') }}"
                                title="{{ __('labels.table_locations') }}" />
                            <x-menu-item icon="gmdi.print-o" link="{{ route('settings.printers') }}"
                                title="{{ __('labels.printers') }}" />
                            <x-menu-item icon="o-cog-6-tooth" link="{{ route('settings.general') }}"
                                title="{{ __('labels.app_settings') }}" />
                            <x-menu-item icon="o-users" link="{{ route('settings.users.list') }}"
                                title="{{ __('labels.users') }}" />
                            <x-menu-item icon="gmdi.restore-from-trash-o" link="###"
                                title="{{ __('labels.trash') }}" />
                        </x-menu-sub>
                    @endcan
                </x-menu>
            </x-slot:sidebar>

            {{-- The `$slot` goes here --}}
            <x-slot:content>
                {{ $slot }}
            </x-slot:content>
        </x-main>

        {{--  TOAST area --}}
        <x-toast position="toast-bottom toast-end" />
        <script defer src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js">
        </script>
    </body>

</html>
