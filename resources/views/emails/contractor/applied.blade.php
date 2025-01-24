<x-email-layout title="Registration Submitted">
    <h1>Dear {{ $name }},</h1>
    <p>Thank you for submitting application.</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
        <li><strong>Applied Date:</strong> {{ $applied_date }}</li>
    </ul>
    <p>We will review your application and reach out if further information is required.</p>
</x-email-layout>
