<x-email-layout title="Card Application Approved">
    <h1>Dear {{ $name }},</h1>
    <p>We are pleased to inform you that your application has been approved!</p>
    <ul>
        <li><strong>Father Name:</strong> {{ $father_name }}</li>
        <li><strong>Personnel Number:</strong> {{ $personnel_number }}</li>
    </ul>
    <p>Please visit the IT Cell C&W Department to collect your ID Card.</p>
    <p>Regards</p>
</x-email-layout>
