# Restaurant Order Manager
## Intro
Laravel-Livewire APP for managing in house orders, print order receipt and control payment for small restaurant.
Note: User must be authenticaed to access the APP. i.e. not possible to access the APP without athenticated user.
___
**Disclamer:** 

I'm a self-learning hobbyist coder, that code in my free time. I love coding! so I create small web-apps for my personal use just for fun and learning.

You're free to use this repository but most likely you'll find some typical amateur mistakes or not so good coding practices.... :wink:

So, any feedback for improvement is more than welcome since will help me on my learning path... Thanks!!
___


## Authorization
Minimalist and simple authorizaiton implementation using laravel gates.

A is_admin column added to the users table to manage admin basic permissions.

### roles
- Admin (is_admin => True):
  - Manage App setting
  - Add / Delete users
  - Manage soft deleted records
  - View / Add / Edit / Delete records in DB
- User (is_admin => False):
  - View / Add / Edit / Delete records in DB

## Authorization
Included languages:
  - en
  - de
  - it
  - pt
  - es

## Packages
- [Laravel 12] (https://laravel.com/docs/12.x)
- [Livewire 3] (https://livewire.laravel.com/docs/quickstart)
- [Mary-UI 2.0-Beta] (https://v2.mary-ui.com/docs/installation)
- [language flags] (https://github.com/MohmmedAshraf/blade-flags) :arrow_right: Language Switch selector
- [Laravel Lang] (https://github.com/Laravel-Lang/common) :arrow_right: Import default laravel files language
- [Extract untranslated strings] (https://github.com/amiranagram/localizator) :arrow_right: Extract translation strings / keys from code and remove un-used string in translation files

