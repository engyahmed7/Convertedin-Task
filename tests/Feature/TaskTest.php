<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\WithFaker;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_task_creation()
    {
        $admin = Admin::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($admin, 'admin');

        $response = $this
            ->post('/admin/tasks', [
                'title' => 'Sample Task',
                'description' => 'Sample Description',
                'assigned_to_id' => $user->id,
                'assigned_by_id' => $admin->id,
            ]);

        $response->assertRedirect('/admin/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Sample Task']);
    }

    public function test_task_list_as_user()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web');

        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
    }

    public function test_task_list_as_admin()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/tasks');
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
    }

    public function test_statistics_page_as_admin()
    {
        $admin = Admin::factory()->create();

        $this->actingAs($admin, 'admin');

        $response = $this->get('/statistics');
        $response->assertStatus(200);
        $response->assertViewIs('statistics.index');
    }
}
