<?php

namespace App\Services;

use App\Models\Program;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ProgramService
{
    public function getAll()
    {
        return Program::with('faculty')->get();
    }

    public function create(array $data)
    {
        $this->validate($data);
        return Program::create($data);
    }

    public function update($id, array $data)
    {
        $program = Program::findOrFail($id);
        $this->validate($data, $program->id);
        $program->update($data);
        return $program;
    }

    public function delete($id)
    {
        Program::findOrFail($id)->delete();
    }

    protected function validate(array $data, $id = null)
    {
        $rules = [
            'code' => 'required|unique:programs,code,' . $id,
            'name' => 'required',
            'short_name' => [
                'required', 'size:2', 'alpha', 'unique:programs,short_name,' . $id,
                function ($attribute, $value, $fail) use ($data) {
                    $words = explode(' ', $data['name']);
                    $expected = count($words) === 1
                        ? strtoupper(substr($words[0], 0, 1) . substr($words[0], 0, 1))
                        : strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                    if ($value !== $expected) {
                        $fail('Nama singkat tidak sesuai aturan.');
                    }
                }
            ],
            'faculty_id' => 'required|exists:faculties,id',
        ];

        Validator::make($data, $rules)->validate();
    }
}
