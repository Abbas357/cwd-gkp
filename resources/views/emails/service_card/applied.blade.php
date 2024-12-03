<x-email-layout title="Application Submitted">
    <p style="margin-top:0">
        <img src="https://lh3.googleusercontent.com/9d_ulk_blK9zaSvJNqpidRssACYA4178SSIJP3uhYamWxrLmgytl6GCnyJfCgGTc-6Q" style="width:50px;height:50px;float:left;margin:0 3% 3% 0"></p>
    <div style="float:left">
        <b>{{ $name }}</b>
    </div>
    <p></p>
    <p style="clear:both;font-style:italic"></p>
    <pre style="font-family:inherit;white-space:pre-wrap;word-wrap:break-word"><b></b> Thank you for submitting application.</pre>
    <p></p>
    <div style="background:#f6f6f6;padding:20px">
        <b>Father Name:</b> <pre style="font-family:inherit;white-space:pre-wrap;word-wrap:break-word">{{ $father_name }}</pre>
    </div>
    <div style="background:#f6f6f6;padding:20px">
        <b>Personnel Number:</b> <pre style="font-family:inherit;white-space:pre-wrap;word-wrap:break-word">{{ $personnel_number }}</pre>
    </div>
    <div style="background:#f6f6f6;padding:20px">
        <b>Applied Date:</b> <pre style="font-family:inherit;white-space:pre-wrap;word-wrap:break-word">{{ $applied_date }}</pre>
    </div>
    <p style="margin:20px 0 0 0">
        <a href="#" style="text-decoration:none;background:#3aaaba;color:white;padding:5px 30px;border-radius:3px" target="_blank">Go Back</a>
    </p>
</x-email-layout>
