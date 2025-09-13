<?php session_start(); ?>
<?php include"../server/connection.php"; ?>

<header class="fixed-top bg-white text-white d-flex justify-content-between align-items-center px-4 py-2 shadow">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <span class="toggle-btn" onclick="toggleSidebar()">&#9776;</span>
  <h1 class="m-0 text-dark">Dashboard</h1>

  <a href="#" class="btn btn-light btn-sm">Sign Out</a>
</header>

<style>
  body {
    padding-top: 70px; /* Enough to push content below navbar */
  }
</style>
