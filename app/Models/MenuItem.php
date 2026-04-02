<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;


class MenuItem extends Model {
    protected $fillable = ['menu_id','parent_id','title','url','route_name','order','open_new_tab'];
    protected $casts = ['open_new_tab' => 'boolean'];
    public function menu() { return $this->belongsTo(Menu::class); }
    public function parent() { return $this->belongsTo(MenuItem::class, 'parent_id'); }
    public function children() { return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order'); }
    public function getHrefAttribute(): string 
    {
        if ($this->route_name && \Route::has($this->route_name)) {
            try {
                // Attempt to pass the 'url' field as a parameter named 'slug'
                // or whatever the route expects.
                return route($this->route_name, $this->url);
        } catch (\Exception $e) {
            // Fallback if the route exists but parameters don't match
            return '#'; 
        }
    }

    return $this->url ?? '#';
}
}