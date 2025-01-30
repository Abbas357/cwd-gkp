<x-email-layout title="Card Application Rejected">
    <h1>Dear {{ $name }},</h1>
    <p>We regret to inform you that your application has been rejected.</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Father Name:</strong> {{ $father_name }}</li>
        <li><strong>Personnel Number:</strong> {{ $personnel_number }}</li>
    </ul>
    <p>As your application is rejected, we recommend that you to visit the C&W office to address the issues mentioned above and complete your application process.</p>
    <p>Regards</p>
</x-email-layout>
