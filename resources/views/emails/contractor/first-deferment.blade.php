<x-email-layout title="Registration Deferred - First Notification">
    <h1>Dear {{ $name }},</h1>
    <p>Your registration has been deferred due to the following reason:</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>Please visit the C&W office to address the issues mentioned above and complete your application process.</p>
</x-email-layout>
