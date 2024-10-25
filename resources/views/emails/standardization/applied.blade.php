<x-email-layout title="Application Submitted">
    <h1>Dear {{ $product_name }} Owner,</h1>
    <p>Thank you for submitting application.</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>Specification Details:</strong> {{ $specification_details }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Applied Date:</strong> {{ $applied_date }}</li>
    </ul>
    <p>We will review your application and reach out if further information is required.</p>
</x-email-layout>
