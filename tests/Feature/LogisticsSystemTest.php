<?php

use App\Models\User;
use App\Models\Jamaah;
use App\Models\TravelPackage;

test('home page displays system overview', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) =>
        $page->component('welcome')
    );
});

test('superadmin can access dashboard', function () {
    $superadmin = User::factory()->create([
        'role' => 'superadmin',
    ]);

    $response = $this->actingAs($superadmin)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) =>
        $page->component('dashboard')
            ->has('user')
            ->has('admin_stats')
    );
});

test('staffadmin can access dashboard', function () {
    $staffadmin = User::factory()->create([
        'role' => 'staffadmin',
    ]);

    $response = $this->actingAs($staffadmin)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) =>
        $page->component('dashboard')
            ->has('user')
            ->has('staff_stats')
    );
});

test('jamaah user can access dashboard', function () {
    $user = User::factory()->create([
        'role' => 'jamaah',
    ]);

    $jamaah = Jamaah::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) =>
        $page->component('dashboard')
            ->has('user')
            ->has('jamaah_data')
    );
});

test('user roles are properly assigned', function () {
    $superadmin = User::factory()->create(['role' => 'superadmin']);
    $staffadmin = User::factory()->create(['role' => 'staffadmin']);
    $jamaah = User::factory()->create(['role' => 'jamaah']);

    expect($superadmin->isSuperadmin())->toBeTrue();
    expect($superadmin->isStaffadmin())->toBeFalse();
    expect($superadmin->isJamaah())->toBeFalse();

    expect($staffadmin->isStaffadmin())->toBeTrue();
    expect($staffadmin->isSuperadmin())->toBeFalse();
    expect($staffadmin->isJamaah())->toBeFalse();

    expect($jamaah->isJamaah())->toBeTrue();
    expect($jamaah->isSuperadmin())->toBeFalse();
    expect($jamaah->isStaffadmin())->toBeFalse();
});

test('travel package capacity calculation', function () {
    $package = TravelPackage::factory()->create([
        'capacity' => 50,
        'registered_count' => 30,
    ]);

    expect($package->remaining_capacity)->toBe(20);
    expect($package->isFull())->toBeFalse();

    $package->update(['registered_count' => 50]);
    expect($package->isFull())->toBeTrue();
});

test('jamaah age calculation', function () {
    $jamaah = Jamaah::factory()->create([
        'date_of_birth' => now()->subYears(35),
    ]);

    expect($jamaah->age)->toBe(35);
});

test('models and relationships work', function () {
    $user = User::factory()->create(['role' => 'jamaah']);
    $jamaah = Jamaah::factory()->create(['user_id' => $user->id]);
    $package = TravelPackage::factory()->create();

    expect($jamaah->user)->toBeInstanceOf(User::class);
    expect($user->jamaah)->toBeInstanceOf(Jamaah::class);
    expect($package->available()->exists())->toBeTrue();
});