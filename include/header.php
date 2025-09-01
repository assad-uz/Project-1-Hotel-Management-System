<?php
// Start the session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Horizon - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@400;500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #005f73;
      transition: all 0.4s ease-in-out;
    }

    .navbar.scrolled {
      background-color: #003d47;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-section {
      background: url('dist/images/index.jpg') no-repeat center center;
      background-size: cover;
      height: 100vh;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .hero-section h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }

    .service-card {
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .service-card:hover {
      transform: scale(1.05);
    }

    .room-card img {
      width: 100%;
      height: auto;
    }

    .testimonial-section {
      background-color: #f1f1f1;
      padding: 60px 0;
    }

    .testimonial-card {
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
    }

    footer {
      background-color: #003d47;
      color: white;
      padding: 30px 0;
      text-align: center;
    }
  </style>
</head>

<body>
