<x-email-layout title="Registration Deferred - Final Notification">
    <h1>Dear {{ $name }},</h1>
    <p>We regret to inform you that your registration has been deferred for the third time due to insufficient data.</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>As this is your third deferment, we recommend that you reapply with complete and accurate information. Please contact IT Cell C&W Department if you have any questions.</p>
</x-email-layout>