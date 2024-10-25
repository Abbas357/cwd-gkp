<x-email-layout title="Product Application Approved">
    <h1>Dear {{ $product_name }} Owner,</h1>
    <p>We are pleased to inform you that your application has been approved!</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>Specification Details:</strong> {{ $specification_details }}</li>
    </ul>
    <p>Please proceed with the payment and visit our office to collect your certificate.</p>
    <p>Thank you for registering with us!</p>
</x-email-layout>
