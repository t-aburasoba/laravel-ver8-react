<?php

namespace Tests\Feature;

use App\Models\Task;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 一覧を取得できる()
    {
        $tasks = Task::factory()->count(10)->create();
        $response = $this->getJson('api/tasks');

        $response
            ->assertOk()
            ->assertJsonCount($tasks->count());
    }

    /**
     * @test
     */
    public function 新規作成できる()
    {
        $data = [
            'title' => 'test 投稿です'
        ];
        $response = $this->postJson('api/tasks', $data);
        $response
            ->assertCreated()
            ->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function 更新できる()
    {
        $task = Task::factory()->create();

        $task->title = '書き換え';
        $response = $this->patchJson("api/tasks/{$task->id}", $task->toArray());
        $response
            ->assertOk()
            ->assertJsonFragment($task->toArray());
    }

    /**
     * @test
     */
    public function 削除できる()
    {
        $tasks = Task::factory()->count(10)->create();

        $response = $this->deleteJson("api/tasks/13");
        $response->assertOk();

        $response = $this->getJson("api/tasks");
        $response->assertJsonCount($tasks->count() -1);
    }

    /**
     * @test
     */
    public function タイトルが空の場合は登録できない()
    {
        $data = [
            'title' => ''
        ];
        $response = $this->postJson('api/tasks', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'title' => 'タイトルは、必ず指定してください。'
                ]
            );
    }

    /**
     * @test
     */
    public function タイトルが255文字以上の時は登録できない()
    {
        $data = [
            'title' => str_repeat('た', 256)
        ];
        $response = $this->postJson('api/tasks', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(
                [
                    'title' => 'タイトルは、255文字以下にしてください。'
                ]
            );
    }
}
