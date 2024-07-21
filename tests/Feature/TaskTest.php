<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_creation()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();

        $response = $this
        // ->withoutMiddleware()
        ->post('/tasks', [
            'title' => 'Sample Task',
            'description' => 'Sample Description',
            'assigned_to_id' => $user->id,
            'assigned_by_id' => $admin->id,
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Sample Task']);
    }

    public function test_task_list()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
    }

    public function test_statistics_page()
    {
        $response = $this->get('/statistics');
        $response->assertStatus(200);
        $response->assertViewIs('statistics.index');
    }
}
