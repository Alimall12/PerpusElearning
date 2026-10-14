<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_katalog_page_renders_with_filters(): void
    {
        $user = \App\Models\User::factory()->create([
            'role' => 'admin',
        ]);

        $buku = \App\Models\Buku::create([
            'kode_buku' => 'BK001',
            'judul' => 'Buku Uji Coba',
            'pengarang' => 'Penulis Uji',
            'penerbit' => 'Penerbit Uji',
            'tahun_terbit' => 2024,
            'genre' => 'Romansa',
            'stok' => 5,
        ]);

        $response = $this->actingAs($user)->get('/katalog?genre[]=Romansa');

        $response->assertStatus(200);
        $response->assertSee('Buku Uji Coba');
        $response->assertSee('name="genre[]"', false);
        $response->assertSee('checked', false);
    }
}
