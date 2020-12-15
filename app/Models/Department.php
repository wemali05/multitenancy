<?php

namespace App\Models;

use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
		use HasFactory;
		
		protected $guarded =[];

		protected static function booted()
    {
				static::addGlobalScope(new TenantScope);
				
				static::creating(function($department){
					$department->tenant_id = session()->get('tenant_id');
				});
    }
}
