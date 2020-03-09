# Arbory menu

CMS module for creating menus

### Installation

Require cube-agency/arbory-menu
```sh
$ composer require cube-agency/arbory-menu
```
Run migrations (creates `menus` and `menu_items` tables)

```sh
$ php artisan migrate
```
Enable module by adding to config `config/arbory.php` and register routes in `routes/admin.php`
```sh
'menu' => [
    ...
    \CubeAgency\ArboryMenu\Http\Controllers\Admin\MenuController::class
]
```
```php  
Admin::modules()->register(\CubeAgency\ArboryMenu\Http\Controllers\Admin\MenuController::class);
```

### Example usage

1. Create new menu called "Main menu (EN)" via admin module
2. Add `main_menu_id` field to LanguagePage using laravel migrations
3. Add select field under LanguagePage definition of fields in `routes/pages.php`

    ```sh
    Page::register(LanguagePage::class)
        ->fields(function (FieldSet $fieldSet) {
            ...
            $fieldSet->select('main_menu_id')->options( ... );
        })
    ```
4. Add relation to Pages/LanguagePage.php

    ```sh
    public function mainMenu(): BelongsTo
    {
        return $this->belongsTo(\CubeAgency\ArboryMenu\Menu\Menu::class);
    }
    ```
5. Get and assign menu items in your view composer

    ```sh
    public function compose(View $view): void
    {
        ...
        $view->with([
            ...
           'mainMenuItems' => $languageNode->content->mainMenu->getPreparedItems()
        ]);
    }
    ```
6. Output menu in layout view

    ```sh
     <ul>
        @foreach($mainMenuItems as $item)
            <li class="{{$item['active'] ? 'active' : ''}}">
                <a href="{{$item['link']}}">
                    {{$item['name']}}
                </a>
            </li>
        @endforeach
    </ul>
    ```