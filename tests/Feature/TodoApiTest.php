<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_todo一覧を取得できる(): void
    {
        $response = $this->getJson('/api/todos');

        $response->assertStatus(200)
                    ->assertJson([]);
    }

    public function test_todoを作成できる(): void
    {
        $response = $this->postJson('/api/todos', [
            'title' => '買い物',
        ]);

        $response->assertStatus(201)
                    ->assertJson([
                        'title' => '買い物',
                        'done' => false,
                    ]);

        $this->assertDatabaseHas('todos', [
            'title' => '買い物',
        ]);
    }

    public function test_タイトルなしでは作成できない(): void
    {
        $response = $this->postJson('/api/todos', [
            'title' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_todoを完了できる(): void
    {
        $todo = \App\Models\Todo::create(['title' => '掃除', 'done' => false]);

        $response = $this->putJson("/api/todos/{$todo->id}/done");

        $response->assertStatus(200)
                    ->assertJson(['done' => true]);
        
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'done' => true,
        ]);
    }

    public function test_存在しないtodoの完了はエラー(): void
    {
        $response = $this->putJson('/api/todos/999/done');

        $response->assertStatus(404);
    }
}
