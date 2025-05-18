<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .header {
            background-color: #4b82e5;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pesan Kontak Baru</h1>
        </div>
        <div class="content">
            <div class="field">
                <span class="label">Nama:</span>
                <div>{{ $data['name'] }}</div>
            </div>
            
            <div class="field">
                <span class="label">Email:</span>
                <div>{{ $data['email'] }}</div>
            </div>
            
            @if(isset($data['phone']))
            <div class="field">
                <span class="label">Telepon:</span>
                <div>{{ $data['phone'] }}</div>
            </div>
            @endif
            
            <div class="field">
                <span class="label">Subjek:</span>
                <div>{{ $data['subject'] }}</div>
            </div>
            
            <div class="field">
                <span class="label">Pesan:</span>
                <div>{{ $data['message'] }}</div>
            </div>
        </div>
        <div class="footer">
            Pesan ini dikirim dari formulir kontak website.
        </div>
    </div>
</body>
</html> 