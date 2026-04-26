<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherAssignment;
use Illuminate\Database\Seeder;

class TeacherAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $teacher = Teacher::query()->where('nip', '198812312020011001')->first();
        $substituteTeacher = Teacher::query()->where('nip', '198901012021011002')->first();
        $class = SchoolClass::query()->where('name', 'X-A')->first();
        $classXB = SchoolClass::query()->where('name', 'X-B')->first();
        $classXIA = SchoolClass::query()->where('name', 'XI-A')->first();
        $subject = Subject::query()->where('kode', 'MTK-10')->first();

        if (! $teacher || ! $class || ! $subject) {
            return;
        }

        TeacherAssignment::updateOrCreate(
            [
                'teacher_id' => $teacher->id,
                'subject_id' => $subject->id,
                'class_id' => $class->id,
                'academic_year' => '2026/2027',
            ],
            [
                'is_homeroom_teacher' => true,
                'assignment_title' => 'Guru Matematika X-A',
                'status' => 'active',
            ]
        );

        if ($substituteTeacher) {
            TeacherAssignment::updateOrCreate(
                [
                    'teacher_id' => $substituteTeacher->id,
                    'subject_id' => $subject->id,
                    'class_id' => $class->id,
                    'academic_year' => '2026/2027',
                ],
                [
                    'is_homeroom_teacher' => false,
                    'assignment_title' => 'Guru Pengganti Matematika X-A',
                    'status' => 'active',
                ]
            );
        }

        foreach ([$classXB, $classXIA] as $extraClass) {
            if (! $extraClass) {
                continue;
            }

            TeacherAssignment::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'class_id' => $extraClass->id,
                    'academic_year' => '2026/2027',
                ],
                [
                    'is_homeroom_teacher' => false,
                    'assignment_title' => 'Guru Matematika '.$extraClass->name,
                    'status' => 'active',
                ]
            );

            if ($substituteTeacher) {
                TeacherAssignment::updateOrCreate(
                    [
                        'teacher_id' => $substituteTeacher->id,
                        'subject_id' => $subject->id,
                        'class_id' => $extraClass->id,
                        'academic_year' => '2026/2027',
                    ],
                    [
                        'is_homeroom_teacher' => false,
                        'assignment_title' => 'Guru Pengganti '.$extraClass->name,
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}
