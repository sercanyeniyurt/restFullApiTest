<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_register()
    {
        $register = [
            'name' => 'UserTest',
            'email' => 'user@test.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ];

        $this->json('POST', 'api/register', $register)->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }


    public function test_login()
    {

        $register = [
            'email' => 'user@test.com',
            'password' => 'testpass'
        ];

        $this->json('POST', 'api/login', $register)->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function test_capsule(){

        $register = [
            'email' => 'user@test.com',
            'password' => 'testpass'
        ];

        $result = $this->json('POST', 'api/login', $register)->assertStatus(200)->assertJsonStructure(['token']);


        $this->assertArrayHasKey('token', $result->json());

        $token = $result->json()['token'];
        $res = $this->json('GET','api/capsules', [], ['HTTP_Authorization' => 'Bearer '.$token]);
        $res->assertStatus(200);

    }

    public function test_capsuleWithCID(){

        $register = [
            'email' => 'user@test.com',
            'password' => 'testpass'
        ];

        $result = $this->json('POST', 'api/login', $register)->assertStatus(200)->assertJsonStructure(['token']);


        $this->assertArrayHasKey('token', $result->json());

        $token = $result->json()['token'];
        $res = $this->json('GET','api/capsules/C101', [], ['HTTP_Authorization' => 'Bearer '.$token]);
        $res->assertStatus(200);

    }

    public function test_capsuleWithStatus(){

        $register = [
            'email' => 'user@test.com',
            'password' => 'testpass'
        ];

        $result = $this->json('POST', 'api/login', $register)->assertStatus(200)->assertJsonStructure(['token']);


        $this->assertArrayHasKey('token', $result->json());

        $token = $result->json()['token'];
        $res = $this->json('GET','api/capsules?status=unknown', [], ['HTTP_Authorization' => 'Bearer '.$token]);
        $res->assertStatus(200);

    }

    public function test_updateSpaceXData()
    {
        $this->assertTrue(class_exists(\App\Console\Commands\updateSpaceXData::class));
    }
}
