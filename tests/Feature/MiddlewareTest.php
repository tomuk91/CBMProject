<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | IsAdmin Middleware
    |--------------------------------------------------------------------------
    */

    public function test_is_admin_middleware_allows_admin_users_through(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_is_admin_middleware_returns_403_for_non_admin(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_is_admin_middleware_redirects_unauthenticated_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_is_admin_middleware_blocks_non_admin_on_all_admin_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $routes = [
            ['GET', route('admin.customers.index')],
            ['GET', route('admin.appointments.slots')],
        ];

        foreach ($routes as [$method, $url]) {
            $response = $this->actingAs($user)->call($method, $url);
            $this->assertEquals(403, $response->status(), "Non-admin should get 403 on {$method} {$url}");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SetLocale Middleware
    |--------------------------------------------------------------------------
    */

    public function test_set_locale_middleware_sets_locale_from_session(): void
    {
        $response = $this->withSession(['locale' => 'hu'])->get('/');

        $this->assertEquals('hu', App::getLocale());
        $response->assertStatus(200);
    }

    public function test_set_locale_middleware_defaults_to_config_locale(): void
    {
        $defaultLocale = config('app.locale');

        $response = $this->get('/');

        $this->assertEquals($defaultLocale, App::getLocale());
        $response->assertStatus(200);
    }

    public function test_language_switch_route_sets_session_locale(): void
    {
        $response = $this->get(route('language.switch', 'hu'));

        $response->assertRedirect();
        $response->assertSessionHas('locale', 'hu');
    }

    public function test_language_switch_rejects_invalid_locale(): void
    {
        $response = $this->get(route('language.switch', 'fr'));

        $response->assertRedirect();
        $response->assertSessionMissing('locale');
    }

    public function test_set_locale_persists_across_requests(): void
    {
        // Set locale to Hungarian
        $this->withSession(['locale' => 'hu'])->get('/');
        $this->assertEquals('hu', App::getLocale());
    }
}
