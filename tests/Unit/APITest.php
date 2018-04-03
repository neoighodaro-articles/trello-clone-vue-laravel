<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    /**
     * This function tests the creation of a new user
     *
     * @return void
     */
    public function testUserCreation()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'neo3',
            'email' => 'neo4@trelloclone.com',
            'password' => '12345',
            'c_password' => '12345'
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'token',
                    'name'
                ]
            ]);
    }


    /**
     * This function tests logging in an existing user
     *
     * @return void
     */
    public function testUserLogin()
    {
        $response = $this->json('POST', '/api/login', [
            'email' => 'neo3@trelloclone.com',
            'password' => '12345'
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success' => [
                    'token',
                    'name'
                ]
            ]);
    }


    /**
     * This function tests the creation of a new category resource
     *
     * @return void
     */
    public function testCategoryCreation()
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/category', [
            'name' => 'Tested',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Category Created'
            ]);
    }


    /**
     * This function tests retreiving of all categories
     *
     * @return void
     */
    public function testCategoryFetch()
    {
        $this->withoutMiddleware();
        $response = $this->json('GET', '/api/category');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]);
    }


    /**
     * This function tests the deletion for a single category resource
     *
     * @return void
     */
    public function testCategoryDeletion()
    {
        $this->withoutMiddleware();
        $response = $this->json('DELETE', '/api/category/1');
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Category Deleted'
            ]);
    }


}