<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover" name="viewport">
        <meta content="{{ csrf_token() }}" name="csrf-token">
        <!-- Mary UI date picker plugin styles -->
        <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
        <link href="https://unpkg.com/flatpickr/dist/plugins/monthSelect/style.css" rel="stylesheet">

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
                <x-theme-toggle class="btn-ghost btn-sm" darkTheme="pbdark" lightTheme="pblight" />
                <x-menus.user-menu />
            </x-slot:actions>
        </x-nav>

        {{-- The main content with `full-width` --}}
        <x-main full-width with-nav>

            {{-- This is a sidebar that works also as a drawer on small screens --}}
            {{-- Notice the `main-drawer` reference here --}}
            <x-slot:sidebar class="bg-base-300" collapsible drawer="main-drawer">

                {{-- Activates the menu item when a route matches the `link` property --}}
                <x-menu activate-by-route>
                    <x-menu-item icon="o-building-storefront" link="/" title="{{ __('labels.manage') }}" />

                    <x-menu-item icon="o-shopping-cart" link="{{ route('orders.index') }}"
                        title="{{ __('labels.orders') }}" />

                    <x-menu-item icon="gmdi.payments-o" link="{{ route('transactions.index') }}"
                        title="{{ __('labels.payments') }}" />

                    <x-menu-item icon="o-presentation-chart-bar" link="{{ route('reports.index') }}"
                        title="{{ __('labels.reports') }}" />

                    <x-menu-sub icon="gmdi.menu-book-o" title="{{ __('labels.menu') }}">
                        <x-menu-item icon="gmdi.restaurant-menu-o" link="{{ route('menu.index') }}"
                            title="{{ __('labels.menu_items') }}" />
                        <x-menu-item icon="gmdi.settings-input-component-o" link="{{ route('sections.index') }}"
                            title="{{ __('labels.menu_sections') }}" />
                        <x-menu-item icon="gmdi.discount-o" link="{{ route('sides.index') }}"
                            title="{{ __('labels.menu_sides') }}" />
                    </x-menu-sub>

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

        <!-- Mary UI Toast -->
        <x-toast position="toast-bottom toast-end" />

        <!-- Sortable plugin (sort data tables) -->
        <script defer src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>

        <!-- Mary UI curency plugin -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js">
        </script>

        <!-- Mary UI chart plugin -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <!-- Mary UI date picker plugin -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://unpkg.com/flatpickr/dist/plugins/monthSelect/index.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/de.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/it.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
    </body>

</html>
