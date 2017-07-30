<?php

namespace Tests\Feature;

use Config;
use Tests\TestCase;

class JwtAuthenticateTest extends TestCase
{
    public function testJwtAuthenticateTest_Login()
    {
        $employee = ClientEmployee::find(1);

        $params = [
            'nif' => $employee->employee->nif,
            'password' => '123456'
        ];

        $employee->update(['rule' => 'owner', 'sent_email' => 1, 'activated' => 1]);

        $employee = Employee::find(1);
        $employee->update(['password' => '123456']);

        $response = $this->post(route('employee.auth'), $params);

        $response->assertStatus(200);
        $this->assertNotNull($response->original['access_token']);
    }
}
