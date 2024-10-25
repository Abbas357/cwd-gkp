<x-email-layout title="Product Application Rejected">
    <h1>Dear {{ $product_name }} Owner,</h1>
    <p>We regret to inform you that your application has been rejected.</p>
    <p><strong>Reason:</strong> {{ $rejected_reason }}</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
        <li><strong>Specification Details:</strong> {{ $specification_details }}</li>
    </ul>
    <p>As this is your third deferment, we recommend that you reapply with complete and accurate information. Please contact our office if you have any questions.</p>
    <p>Thank you for your understanding.</p>
</x-email-layout>
