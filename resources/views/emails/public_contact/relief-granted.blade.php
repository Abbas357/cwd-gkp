<x-email-layout title="Relief Granted">
    <h1>Dear {{ $name }},</h1>
    <p>We are pleased to inform you that relief grant as per your query!</p>
    <p><strong>Remarks:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Submission date:</strong> {{ $submission_date }}</li>
        <li><strong>CNIC:</strong> {{ $cnic }}</li>
    </ul>
    <p>Thanks for contacting us.</p>
    <p>Best Wishes</p>
</x-email-layout>

