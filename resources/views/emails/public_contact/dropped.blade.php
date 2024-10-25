<x-email-layout title="Your Query / Message Dropped">
    <h1>Dear {{ $name }},</h1>
    <p>We regret to inform you that your message/complaint is dropped.</p>
    <p><strong>Reason:</strong> {{ $remarks }}</p>
    <ul>
        <li><strong>Submission date:</strong> {{ $submission_date }}</li>
        <li><strong>CNIC:</strong> {{ $cnic }}</li>
    </ul>
    <p>You are always welcome at C&W Office for further assistance.</p>
    <p>Best Wishes</p>
</x-email-layout>
