<x-email-layout title="Registration Deferred - Second Notification">
    <h1>Dear {{ $name }},</h1>
    <p>Your registration has been deferred for the second time due to the following reason:</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>Please visit the C&W office to address these issues. Note that this is your second deferment notification, and it’s important to resolve the identified deficiencies as soon as possible.</p>
</x-email-layout>
