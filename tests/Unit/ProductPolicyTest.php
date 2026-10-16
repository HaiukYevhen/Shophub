<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductPolicyTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_regular_user_cannot_create_products(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertFalse($user->can('create', Product::class));
    }

    public function test_admin_can_create_products(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($admin->can('create', Product::class));
    }
}