<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Scopes\TenantScope;

trait BelongsToTenant
{
	protected static function bootBelongsToTenant()
	{
		static::addGlobalScope(new TenantScope);

		static::creating(function ($model) {
				if (session()->has('tenant_it')) {
						$model->tenant_id = session()->get('tenant_id');
				}
		});
	}

	public function tenant(){
		return $this->belongsTo(Tenant::class);
	}
}