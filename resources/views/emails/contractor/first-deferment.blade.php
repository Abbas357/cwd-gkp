<x-email-layout title="Registration Deferred - First Notification">
    <h1>Dear {{ $owner_name }},</h1>
    <p>Your registration has been deferred due to the following reason:</p>
    <p><strong>Reason:</strong> {{ $deferred_reason }}</p>
    <ul>
        <li><strong>Contractor Name:</strong> {{ $contractor_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>Please visit the C&W office to address the issues mentioned above and complete your application process.</p>
</x-email-layout>
