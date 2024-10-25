<x-email-layout title="Relief Not Granted">
    <h1>Dear {{ $name }},</h1>
    <p>We regret to inform you that relief cannnot be granted as per your query!</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Submission date:</strong> {{ $submission_date }}</li>
        <li><strong>CNIC:</strong> {{ $cnic }}</li>
    </ul>
    <p>Thanks for contacing us.</p>
    <p>Best Wishes</p>
</x-email-layout>