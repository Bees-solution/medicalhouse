<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            padding: 50px;
            margin: auto;
            background-color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            max-width: 1200px;
        }

        h1, h2 {
            color: #004d66;
            font-weight: 700;
        }

        h1 {
            font-size: clamp(1.8rem, 3vw, 3rem); /* Responsive text size for h1 */
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            font-size: clamp(1.5rem, 2.5vw, 1.8rem); /* Responsive text size for h2 */
            margin-top: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        h2:after {
            content: '';
            width: 60px;
            height: 4px;
            background-color: #004d66;
            display: block;
            margin-top: 5px;
            border-radius: 2px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        p, ul {
            line-height: 1.8;
            color: #555;
            font-size: clamp(1rem, 1.5vw, 1.25rem); /* Responsive text size for paragraphs and lists */
        }

        ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }

        ul li:before {
            content: '\2022';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.2rem;
            color: #004d66;
        }

        .video-section {
            flex: 1;
            min-width: 300px;
        }

        .content-section {
            flex: 1;
            min-width: 300px;
            padding-left: 20px;
        }

        /* Button Styling for Vision/Mission Section */
        .content-section p strong {
            background: linear-gradient(45deg, #004d66, #007b8f);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        /* Add hover effect on the container for interactivity */
        .container:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }

        /* Media Queries for Responsive Elements */
        @media (max-width: 1200px) {
            .container {
                max-width: 95%;
                flex-direction: column;
                align-items: center;
            }

            .video-section, .content-section {
                max-width: 100%;
                padding: 0;
            }
        }

        @media (max-width: 768px) {
            iframe {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            iframe {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <h1>Our Story</h1>
    <div class="container">
        <!-- Video Section -->
        <div class="video-section">
            <iframe 
                src="https://www.youtube.com/embed/hlwlM4a5rxg?si=IoRgYXcSfla9Knvl" 
                title="YouTube video player" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
            <p><strong>[Hospital Name]</strong> is a leading healthcare institution dedicated to providing exceptional medical services with a focus on compassion, innovation, and excellence. Equipped with state-of-the-art technology and a team of highly skilled professionals, the hospital offers comprehensive care across various specialties, including cardiology, pediatrics, orthopedics, and oncology. With 24/7 emergency services, advanced diagnostic facilities, and patient-centered treatment plans, <strong>[Hospital Name]</strong> ensures the highest standards of care. The hospital also features modern amenities, comfortable patient rooms, and digital health solutions for seamless access to consultations and appointments. Committed to enhancing the well-being of the community, <strong>[Hospital Name]</strong> is where advanced medicine meets personalized care.</p>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <h2>Vision</h2>
            <p><strong>"To Be the Hospital of Tomorrow"</strong></p>
            <p>To provide quality and safe healthcare to the people whilst maintaining leadership and excellence in the healthcare facility.</p>

            <h2>Mission</h2>
            <p><strong>"Healing with Feeling"</strong></p>
            <p>To provide the best quality healthcare in accordance with international standards to the needy in a cost-effective, timely, and professional manner.</p>

            <h2>Our Values</h2>
            <p>We understand the dynamic and urgent nature of the healthcare sector, which has evolved over the decades from a reactive to a proactive service. Our key values include:</p>
            <ul>
                <li>Strengthen Safety and Quality</li>
                <li>Drive Innovation, Technology, and Research</li>
                <li>Enable Our People</li>
                <li>Plan for a Sustainable Future</li>
                <li>Achieve Financial Health</li>
            </ul>
        </div>
    </div>
</body>
</html>
