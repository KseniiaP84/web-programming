<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PlaceAccessTest extends TestCase
{
    public function test_request_without_owner_header_is_blocked(): void
    {
        $response = $this->postJson('/places', [
            'name' => 'Міська бібліотека',
            'category' => 'Бібліотека',
            'address' => 'вул. Незалежності, 10',
            'city' => 'Івано-Франківськ',
            'accessibility_description' => 'Є пандус',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'access_denied',
            ]);
    }

    public function test_request_with_valid_owner_header_passes(): void
    {
        $response = $this->withHeaders([
            'X-Place-Owner-ID' => '123',
        ])->postJson('/places', [
            'name' => 'Міська бібліотека',
            'category' => 'Бібліотека',
            'address' => 'вул. Незалежності, 10',
            'city' => 'Івано-Франківськ',
            'accessibility_description' => 'Є пандус',
        ]);

        $response->assertStatus(201)
            ->assertHeader('X-Security-Policy', 'Owner-Verified')
            ->assertJsonPath('data.status', 'pending');
    }
}
