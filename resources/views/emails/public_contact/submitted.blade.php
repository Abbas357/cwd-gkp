<x-email-layout title="Message Submitted">
    <h1>Dear {{ $name }},</h1>
    <p>Thank you for submitting the query.</p>
    <ul>
        <li><strong>Submission date:</strong> {{ $submission_date }}</li>
        <li><strong>CNIC:</strong> {{ $cnic }}</li>
    </ul>
    <p>We will review your query and reach out if further information is required.</p>
    <p>Best Wishes</p>
</x-email-layout>
