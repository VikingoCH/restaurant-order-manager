# Laravel 12 App starter
## Intro
Laravel Base template based on Laravel 12 livewire starter kit.

Template for a personal App where user must be authenticad to get acces to the application. Only Admin user can add new users. 

Default Flux UI components library used by livewire starter kit is complete replaced by MaryUI.

___
**Disclamer:** 

I'm a self-learning hobbyist coder, that code in my free time. I love coding! so I create small web-apps for my personal use just for fun and learning.

I created this repository as a base for my web-apps.

You're free to use this repository but most likely you'll find some typical amateur mistakes or not so good coding practices.... :wink:

So, any feedback for improvement is more than welcome since will help me on my learning path... Thanks!!
___


## Authorization
Minimalist and simple authorizaiton implementation using laravel gates.

A is_admin column have to be created in the users table to manage admin basic permissions.

### roles
- Admin (is_admin => True):
  - Manage App setting
  - Add / Delete users
  - View / Add / Edit / Delete all records in DB
- User (is_admin => False):
  - View all records
  - Add / Edit records in DB

## Packages
- [Laravel 12] (https://laravel.com/docs/12.x)
- [Livewire 3] (https://livewire.laravel.com/docs/quickstart)
- [Mary-UI 2.0-Beta] (https://v2.mary-ui.com/docs/installation)
- [language flags] (https://github.com/MohmmedAshraf/blade-flags) :arrow_right: Language Switch selector
- [Laravel Lang] (https://github.com/Laravel-Lang/common) :arrow_right: Import default laravel files language
- [Extract untranslated strings] (https://github.com/amiranagram/localizator) :arrow_right: Extract translation strings / keys from code and remove un-used string in translation files

