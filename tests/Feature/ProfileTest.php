<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders the profile form', function () {
    $this->actingAs($this->user)
        ->get(route('admin.profile.edit'))
        ->assertSuccessful()
        ->assertSee($this->user->email);
});

it('updates name and email without touching the password', function () {
    $this->actingAs($this->user)
        ->put(route('admin.profile.update'), [
            'name' => 'Hossam Soliuman',
            'email' => 'hossam@networx-solutions.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->user->refresh();

    expect($this->user->name)->toBe('Hossam Soliuman')
        ->and($this->user->email)->toBe('hossam@networx-solutions.com')
        ->and(Hash::check('password', $this->user->password))->toBeTrue();
});

it('changes the password when the current password is correct', function () {
    $this->actingAs($this->user)
        ->put(route('admin.profile.update'), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'current_password' => 'password',
            'password' => 'a-new-secret-password',
            'password_confirmation' => 'a-new-secret-password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(Hash::check('a-new-secret-password', $this->user->refresh()->password))->toBeTrue();
});

it('rejects a password change with the wrong current password', function () {
    $this->actingAs($this->user)
        ->put(route('admin.profile.update'), [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'current_password' => 'wrong-password',
            'password' => 'a-new-secret-password',
            'password_confirmation' => 'a-new-secret-password',
        ])
        ->assertSessionHasErrors('current_password');
});

it('rejects an email already used by another user', function () {
    $other = User::factory()->create();

    $this->actingAs($this->user)
        ->put(route('admin.profile.update'), [
            'name' => $this->user->name,
            'email' => $other->email,
        ])
        ->assertSessionHasErrors('email');
});
