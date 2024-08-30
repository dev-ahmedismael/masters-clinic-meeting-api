<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin_role = Role::create(['name' => 'admin']);
        $customer_service_role = Role::create(['name' => 'customer_service']);
        $doctor_role = Role::create(['name' => 'doctor']);

        $admin = User::create([
            'name' => 'Ali Fathy',
            'email' => 'admin',
            'password' => Hash::make('root'),
        ]);
        $admin->assignRole('admin');

        // Create Branches
        $branches = [
            ['slug' => 'mecca-alawaly', 'title' => 'فرع مكة المكرمة - العوالي', 'address' => '', 'location' => ''],
            ['slug' => 'jeddah', 'title' => 'فرع جدة', 'address' => 'برج النخبة سكوير - حي الشاطئ خلف برج الشاشة - جدة', 'location' => ''],
            ['slug' => 'mecca-alkhaldiya', 'title' => 'فرع مكة المكرمة - الخالدية', 'address' => 'برج المشارق - الطريق الدائري الثالث - حي الخالدية - مكة المكرمة', 'location' => ''],
        ];
        foreach ($branches as $branch) {
            Branch::create(
                [
                    'slug' => $branch['slug'],
                    'title' => $branch['title'],
                    'address' => $branch['address'],
                    'location' => $branch['location'],
                ]
            );
        }

        // Create Departments
        $departments = [
            [
                'slug' => 'dermatology',
                'title' => 'الجلدية والتجميل'
            ],
            [
                'slug' => 'dentistry',
                'title' => 'طب الأسنان'
            ],
            [
                'slug' => 'nutrition-and-fitness',
                'title' => 'التغذية والرشاقة'
            ],
            [
                'slug' => 'obstetrics-and-gynecology',
                'title' => 'النساء والتوليد والتجميل النسائي'
            ],
            [
                'slug' => 'internal',
                'title' => 'الباطنة'
            ],
            [
                'slug' => 'otorhinolaryngology',
                'title' => 'الأنف والأذن'
            ],
            [
                'slug' => 'orthopedics',
                'title' => 'العظام'
            ],
            [
                'slug' => 'pediatrics',
                'title' => 'الأطفال'
            ],
            [
                'slug' => 'laboratory',
                'title' => 'المختبر'
            ],
            [
                'slug' => 'rays',
                'title' => 'الآشعة'
            ]
        ];

        foreach ($departments as $department) {
            Department::create(
                [
                    'slug' => $department['slug'],
                    'title' => $department['title'],
                    'content' => 'المحتوى تحت الإنشاء'
                ]
            );
        }
    }
}
