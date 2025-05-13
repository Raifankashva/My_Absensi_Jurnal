<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #3b82f6, #4f46e5);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }
        .message-box {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .field {
            margin-bottom: 10px;
        }
        .field strong {
            display: inline-block;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
    </div>
    <div class="content">
        <p>You have received a new message from your website contact form.</p>
        
        <div class="field">
            <strong>Name:</strong> {{ $data['name'] }}
        </div>
        
        <div class="field">
            <strong>Email:</strong> {{ $data['email'] }}
        </div>
        
        <div class="field">
            <strong>Subject:</strong> {{ $data['subject'] }}
        </div>
        
        <div class="field">
            <strong>Date:</strong> {{ date('F j, Y, g:i a') }}
        </div>
        
        <div class="message-box">
            <strong>Message:</strong><br>
            {{ $data['message'] }}
        </div>
        
        <p>You can reply directly to this email to respond to {{ $data['name'] }}.</p>
    </div>
    <div class="footer">
        <p>© {{ date('Y') }} Your Company. All rights reserved.</p>
        <p>Depok, Indonesia</p>
    </div>
</body>
</html>