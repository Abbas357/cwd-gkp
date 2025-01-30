<x-email-layout title="Application Rejected">
    <h1>Dear</h1>
    <p>We regret to inform you that your application has been rejected.</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Firm Name:</strong> {{ $firm_name }}</li>
    </ul>
    <p>As your application is rejected, we recommend that you to visit the C&W office to address the issues mentioned above and complete your application process.</p>
</x-email-layout>
