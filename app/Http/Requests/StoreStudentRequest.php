<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;

    }

    public function rules()
    {
        return [
            'first_name'      => [
                'required'],
            'last_name'       => [
                'required'],
            'email'           => [
                'required'],
            'billing_address' => [
                'required'],
        ];

    }
}
