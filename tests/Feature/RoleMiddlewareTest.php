<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase; // لتنظيف قاعدة البيانات الوهمية بعد كل اختبار

    // 1. اختبار: الزائر العادي يجب أن يُطرد لصفحة الدخول
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }

    // 2. اختبار: الدكتور الموثق يمكنه الدخول للداشبورد بنجاح (200)
    public function test_doctor_can_access_dashboard(): void
    {
        $doctor = User::factory()->create([
            'role' => 'doctor',
            'email_verified_at' => now(), // حساب موثق
        ]);

        $response = $this->actingAs($doctor)->get('/dashboard');

        $response->assertStatus(200);
    }

    // 3. اختبار: الأدمن ممنوع من دخول داشبورد الطبيب (يجب أن يعطيه 403)
    public function test_admin_cannot_access_doctor_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(404);
    }
}