<x-email-layout title="Registration Deferred - Final Notification">
    <h1>Dear {{ $owner_name }},</h1>
    <p>We regret to inform you that your registration has been deferred for the third time due to insufficient data.</p>
    <p><strong>Reason:</strong> {{ $deferred_reason }}</p>
    <ul>
        <li><strong>Contractor Name:</strong> {{ $contractor_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>As this is your third deferment, we recommend that you reapply with complete and accurate information. Please contact our office if you have any questions.</p>
    <p>Thank you for your understanding.</p>
</x-email-layout>