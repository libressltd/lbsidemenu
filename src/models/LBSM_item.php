<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\Role;
use App\Models\Permission;
use Auth;
use Log;

class LBSM_item extends Model
{
    use Uuid32ModelTrait;
    protected $table = "LBSM_items";
    protected $fillable = ["title", "title_translated", "icon", "url", "id_string", "order_number"];
    
    static public function all_to_option()
    {
    	$array = array();
        $array[] = array("name" => "None", "value" => "-1");
    	foreach (LBSM_item::get() as $item)
    	{
    		$array[] = array("name" => $item->title, "value" => $item->id);
    	}
    	return $array;
    }

    public function available()
    {
        Log::useFiles('php://stdout', 'info');
        Log::info($this);
        $user = Auth::user();
        if ($this->roles->count() == 0 && $this->permissions->count() == 0)
        {
            return true;
        }

        if ($this->roles->count() > 0)
        {
            foreach ($this->roles as $role)
            {
                if ($user->hasRole($role->code))
                {
                    return true;
                }
            }
        }

        if ($this->permissions->count() > 0)
        {
            foreach ($this->permissions as $permission)
            {
                if ($user->hasPermission($permission->code))
                {
                    return true;
                }
            }
        }
        return false;
    }

    public function roles()
    {
        return $this->belongsToMany("App\Models\Role", "LBSM_item_roles", "item_id", "role_id");
    }

    public function permissions()
    {
        return $this->belongsToMany("App\Models\Permission", "LBSM_item_permissions", "item_id", "permission_id");
    }

    public function parent()
    {
        return $this->belongsTo("App\Models\LBSM_item", "parent_id");
    }

    public function children()
    {
        return $this->hasMany("App\Models\LBSM_item", "parent_id");
    }

	public function creator()
	{
		return $this->belongsTo("App\Models\User", "created_by");
	}

	public function updater()
	{
		return $this->belongsTo("App\Models\User", "updated_by");
	}

    static public function boot()
    {
    	LBSM_item::bootUuid32ModelTrait();
        LBSM_item::saving(function ($category) {
        	if (Auth::user())
        	{
	            if ($category->id)
	            {
	            	$category->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$category->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
