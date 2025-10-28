> Coding notes - not to forget how to....
# Livewire-Sortable 
## Installation
Add CDN at end of app.blade.php
```
    <script defer src="https://cdn.jsdelivr.net/gh/livewire/sortable@v1.x.x/dist/livewire-sortable.js"></script>
```
## MaryUI Tables
To integrate Livewire-Sortable in MaryUI tables include following in Table.php component:
```php
    //Line 345
    <tbody
        @if($attributes->has('changeRowOrder'))
            wire:sortable="changeRowOrder"
        @endif
    >
    //Line 351
    <tr
        //existingCode...
        @if($attributes->has('changeRowOrder'))
            wire:sortable.item="{{ $row->id }}"
        @endif
    >
```
Include the 'changeRowOrder' attribute in Table component.
In the livewire component include 'changeRowOrder' method:
```php
    public function changeRowOrder($items)
        {
            foreach ($items as $item)
            {
                Model::find($item['value'])->update(['position' => $item['order']]);
            }
            $this->success(__('Items reordered successfully'));
        }
```

