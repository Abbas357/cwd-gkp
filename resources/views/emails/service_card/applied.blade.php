<x-email-layout title="Application Submitted">
    <h1>Dear {{ $name }},</h1>
    <p>Thank you for submitting application.</p>
    <ul>
        <li><strong>Father:</strong> {{ $father_name }}</li>
        <li><strong>Personnel Number:</strong> {{ $personnel_number }}</li>
        <li><strong>Applied Date:</strong> {{ $applied_date }}</li>
    </ul>
    <p>We will review your application and reach out if further information is required.</p>
    <p>Regards</p>
</x-email-layout>
