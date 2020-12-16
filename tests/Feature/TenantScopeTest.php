<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantScopeTest extends TestCase
{
		use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
		/** @test */
    public function a_model_has_a_tenant_id_on_the_migration()
    {
			$this->artisan('make:model Test -m');

			$files = File::glob(database_path() . '/migrations/*create_tests_table.php');
			count($files) > 0 ? $filename = $files[0] : $filename = null;

			$this->assertTrue(File::exists($filename));
			$this->assertStringContainsString('$table->unsignedBigInteger(\'tenant_id\')->index()', File::get($filename));

			File::delete($filename);
			File::delete(app_path('/Models/Test.php'));
		}
		
		/** @test */
		public function a_user_can_only_see_users_in_the_same_tenant(){
			$tenant1 = Tenant::factory()->create();
			$tenant2 = Tenant::factory()->create();

			$user1 = User::factory()->create(['tenant_id' => $tenant1]);

			User::factory()->count(9)->create(['tenant_id' => $tenant1]);
			 
			User::factory()->count(10)->create(['tenant_id' => $tenant2]);
			
			// dd(User::count());

			auth()->login($user1);
			
			$this->assertEquals(10, User::count());
		}

		/** @test */
		public function a_test_user_can_only_create_a_user_in_his_tenant_even_if_other_tenant_is_provided(){
			$tenant1 = Tenant::factory()->create();
			$tenant2 = Tenant::factory()->create();

			$user1 = User::factory()->create(['tenant_id' => $tenant1, ]);

			Auth::login($user1);
			
			$createdUser = User::factory()->make();
			$createdUser->tenant_id = $tenant2->tenant_id;
			$createdUser->save();

			$this->assertTrue($createdUser->tenant_id == $user1->tenant_id);
		}
}
