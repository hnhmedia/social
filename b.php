<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaurav Kumar Mishra | Portfolio</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: #050b18;
      color: white;
    }

    header {
      width: 100%;
      padding: 80px 10%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .hero-text {
      max-width: 520px;
    }

    .hero-text h1 {
      font-size: 55px;
      font-weight: 700;
    }

    .hero-text h1 span {
      color: #ff7a18;
    }

    .hero-text h2 {
      margin: 15px 0;
      font-size: 22px;
      font-weight: 400;
      color: #00d4ff;
    }

    .hero-text p {
      margin: 20px 0;
      font-size: 16px;
      color: #ddd;
      line-height: 1.6;
    }

    .btn-group {
      margin-top: 25px;
    }

    .btn {
      padding: 12px 25px;
      border-radius: 30px;
      border: none;
      cursor: pointer;
      font-size: 15px;
      font-weight: 600;
      transition: 0.3s;
      margin-right: 15px;
    }

    .btn-primary {
      background: linear-gradient(90deg, #00d4ff, #007bff);
      color: white;
    }

    .btn-primary:hover {
      transform: scale(1.05);
    }

    .btn-outline {
      background: transparent;
      border: 2px solid #ff7a18;
      color: white;
    }

    .btn-outline:hover {
      background: #ff7a18;
    }

    .hero-img img {
      width: 320px;
      border-radius: 20px;
      box-shadow: 0 0 25px rgba(0,212,255,0.5);
    }

    /* Stats */
    .stats {
      width: 100%;
      display: flex;
      justify-content: space-around;
      padding: 25px 10%;
      background: rgba(255,255,255,0.03);
      border-top: 1px solid rgba(255,255,255,0.08);
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .stat-box {
      text-align: center;
    }

    .stat-box h3 {
      font-size: 22px;
      color: #ff7a18;
    }

    .stat-box p {
      font-size: 14px;
      color: #aaa;
    }

    /* About */
    section {
      padding: 70px 10%;
    }

    section h2 {
      font-size: 32px;
      margin-bottom: 20px;
      border-left: 5px solid #ff7a18;
      padding-left: 12px;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }

    .card {
      background: rgba(255,255,255,0.05);
      padding: 25px;
      border-radius: 15px;
      border: 1px solid rgba(255,255,255,0.1);
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 0 20px rgba(0,212,255,0.3);
    }

    .card h3 {
      color: #00d4ff;
      margin-bottom: 10px;
    }

    /* Projects */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .project {
      background: rgba(255,255,255,0.05);
      border-radius: 15px;
      overflow: hidden;
      border: 1px solid rgba(255,255,255,0.1);
      transition: 0.3s;
    }

    .project img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .project-content {
      padding: 18px;
    }

    .project-content h3 {
      margin-bottom: 10px;
      color: #ff7a18;
    }

    .project-content a {
      display: inline-block;
      margin-top: 10px;
      padding: 8px 18px;
      border-radius: 20px;
      background: #00d4ff;
      color: black;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
    }

    .project-content a:hover {
      background: #ff7a18;
      color: white;
    }

    /* Footer */
    footer {
      padding: 30px;
      text-align: center;
      background: rgba(255,255,255,0.03);
      color: gray;
      margin-top: 40px;
    }
  </style>
</head>

<body>

  <!-- HERO -->
  <header>
    <div class="hero-text">
      <h1>Hello, I'm <br><span>Gaurav</span> Kumar Mishra</h1>
      <h2>Technical Architect | Solution Architect</h2>
      <p>
        Crafting scalable & high-performance solutions with 12+ years of expertise
        in eCommerce, Cloud Architecture, DevOps, and Performance Optimization.
      </p>

      <div class="btn-group">
        <button class="btn btn-primary">Download CV</button>
        <button class="btn btn-outline">Contact Me</button>
      </div>
    </div>

    <div class="hero-img">
      <img src="profile.jpg" alt="Profile Photo">
    </div>
  </header>

  <!-- STATS -->
  <div class="stats">
    <div class="stat-box">
      <h3>12+</h3>
      <p>Years Experience</p>
    </div>
    <div class="stat-box">
      <h3>20+</h3>
      <p>Major Projects</p>
    </div>
    <div class="stat-box">
      <h3>500×</h3>
      <p>Growth Impact</p>
    </div>
  </div>

  <!-- ABOUT -->
  <section>
    <h2>About Me</h2>
    <p>Innovative. Scalable. Results-Driven.</p>

    <div class="cards">
      <div class="card">
        <h3>Cloud Architecture</h3>
        <p>AWS & GCP scalable infrastructure solutions.</p>
      </div>

      <div class="card">
        <h3>eCommerce Platforms</h3>
        <p>Magento, Drupal, WordPress high-performance builds.</p>
      </div>

      <div class="card">
        <h3>DevOps & Automation</h3>
        <p>CI/CD pipelines, monitoring, deployments.</p>
      </div>
    </div>
  </section>

  <!-- PROJECTS -->
  <section>
    <h2>My Projects</h2>

    <div class="projects-grid">

      <div class="project">
        <img src="zodiac.jpg" alt="">
        <div class="project-content">
          <h3>Zodiac Clothing</h3>
          <p>Magento D2C platform scaled to 6–8× sales growth.</p>
          <a href="#">View Project</a>
        </div>
      </div>

      <div class="project">
        <img src="arks.jpg" alt="">
        <div class="project-content">
          <h3>ARKS Club</h3>
          <p>Celebrity lifestyle D2C brand platform.</p>
          <a href="#">View Project</a>
        </div>
      </div>

      <div class="project">
        <img src="act.jpg" alt="">
        <div class="project-content">
          <h3>ACT Fibernet</h3>
          <p>Enterprise Drupal broadband platform.</p>
          <a href="#">View Project</a>
        </div>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    © 2026 | Portfolio Website - Gaurav Kumar Mishra
  </footer>

</body>
</html>
