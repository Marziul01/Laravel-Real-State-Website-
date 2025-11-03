<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Property Submission - {{ $client->name }}</title>
    <style>
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px 0;
        }

        .container {
            background-color: #ffffff;
            max-width: 700px;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .header {
            background: linear-gradient(135deg, #007bff, #00c3ff);
            color: #ffffff;
            text-align: center;
            padding: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .content {
            padding: 30px;
            color: #333333;
        }

        .content h2 {
            font-size: 18px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .content p {
            margin: 8px 0;
            font-size: 15px;
        }

        .property-info {
            background-color: #f9fbfd;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .property-info strong {
            color: #007bff;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .gallery img {
            width: calc(33.33% - 10px);
            border-radius: 8px;
            border: 1px solid #ddd;
            object-fit: cover;
        }

        .footer {
            background-color: #f1f3f6;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #666666;
        }

        @media (max-width: 600px) {
            .gallery img {
                width: calc(50% - 10px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Property Submission</h1>
        </div>

        <div class="content">
            <h2>Client Details</h2>
            <div class="property-info">
                <p><strong>Name:</strong> {{ $client->name }}</p>
                <p><strong>Email:</strong> {{ $client->email }}</p>
                <p><strong>Phone:</strong> {{ $client->phone }}</p>
                <p><strong>Type:</strong> {{ ucfirst($client->type) }}</p>
            </div>

            <h2>Property Details</h2>
            <div class="property-info">
                <p><strong>Address:</strong> {{ $client->property_address }}</p>
                <p><strong>Space:</strong> {{ $client->property_space }}</p>
                <p><strong>Bedrooms:</strong> {{ $client->property_bedrooms }}</p>
                <p><strong>Estimated Price:</strong> {{ number_format($client->property_estimated_price, 2) }} BDT</p>
            </div>

            
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ $setting->site_name }}. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
