<x-email-layout title="Registration Approved">
    <h1>Dear {{ $name }},</h1>
    <p>We are pleased to inform you that your card has been renewed!</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>PEC Number:</strong> {{ $pec_number }}</li>
    </ul>
    <p>Please proceed with the payment and visit our office to collect your registration card.</p>
    <p>Thank you for registering with us!</p>
</x-email-layout>
