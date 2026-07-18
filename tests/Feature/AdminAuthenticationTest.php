<?php

use App\Models\User;

it('shows the login page to guests', function () {
    $this->get(route('admin.login'))
        ->assertSuccessful()
        ->assertSee('Sign in');
});

it('redirects authenticated users away from the login page', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.login'))
        ->assertRedirect(route('admin.dashboard'));
});

it('logs in with valid credentials', function () {
    $user = User::factory()->create();

    $this->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid credentials', function () {
    $user = User::factory()->create();

    $this->from(route('admin.login'))->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertRedirect(route('admin.login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('rate limits repeated login attempts', function () {
    $user = User::factory()->create();

    foreach (range(1, 5) as $attempt) {
        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }

    $this->post(route('admin.login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertTooManyRequests();
});

it('logs out and invalidates the session', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('admin.logout'))
        ->assertRedirect(route('admin.login'));

    $this->assertGuest();
});

it('redirects guests to the login page from protected admin routes', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.messages.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.settings.edit'))->assertRedirect(route('admin.login'));
});
