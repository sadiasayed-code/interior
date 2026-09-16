<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
nav {
  padding: 0px 10px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  font-family: "Poppins", sans-serif;
}
ul {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 36px;
}
li {
  list-style: none;
}
#logo {
  font-size: 20px;
  font-weight: bold;
  color: #153d3d;
}
nav button {
  padding: 5px 20px;
  border-radius: 15px;
  border: transparent;
  background-color: #153d3d;
  color: white;
  font-family: "Poppins", sans-serif;
}
.main {
  width: 100%;
  height: 850px;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 4fr 0.8fr;
  column-gap: 12px;
  row-gap: 24px;
}
.txt {
  grid-column: 1/2;
  grid-row: 1/2;
  display: flex;
  flex-direction: column;
  text-align: left;
  justify-content: center;
  padding: 20px;
  text-wrap: wrap;
}
.txt h2 {
  font-size: 65px;
  margin: 0;
  color: #286318;
}
.txt p {
  font-size: 25px;
  color: #153d3d;
}
.buttons {
  display: flex;
  align-items: center;
  justify-content: left;
  gap: 24px;
}
.button {
  border-radius: 20px;
  border: transparent;
  font-weight: bold;
  font-size: 16px;
  height: 100%;
}
#btn1 {
  background-color: #153d3d;
  color: white;
  padding: 5px 20px;
}
#btn2 {
  color: #153d3d;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
  padding: 0px;
  padding-right: 10px;
}
#btn2 img {
  height: 30px;
  width: 40px;
  padding: 5px;
  border-radius: 50%;
}
.circle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 30%;
  height: 100%;
  background-color: #153d3d;
  border-radius: 20px;
}
.pictures {
  grid-column: 2/3;
  grid-row: 1/2;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  padding: 30px;
  gap: 10px;
  background: radial-gradient(#153d3dce, #153d3d4f, white, white);
  position: relative;
}
.img {
  width: 30%;
  height: 80%;
  border-radius: 70px;
}
#img1 {
  background-image: url("https://assets-news.housing.com/news/wp-content/uploads/2022/08/18184418/Green-colour-wall-paint-design-ideas-to-give-your-home-a-fresh-look-03.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center right;
  align-self: flex-start;
}
#img2 {
  background-image: url("https://cdn.shopify.com/s/files/1/0305/9521/9595/files/Screenshot_2022-04-01_at_08.45.14_480x480.png?v=1648799148");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center center;
  align-self: flex-end;
}
#img3 {
  background-image: url("https://i.pinimg.com/736x/05/91/78/0591788328fe38fe3f691b0028630595.jpg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center left;
  align-self: flex-start;
}

.brands {
  grid-column: 1/3;
  grid-row: 2/3;
  border-radius: 80px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-evenly;
  padding: 20px;
  background-color: #e2eddf;
  gap: 30px;
}
.brands img {
  max-width: 150px;
  width: 100px;
}
/* =========================
   SERVICES SECTION
========================= */

.services-section {
  width: 100%;
  padding: 100px 6%;
  box-sizing: border-box;
  background: #f7faf6;
  font-family: "Poppins", sans-serif;
}

.services-heading {
  max-width: 700px;
  margin: 0 auto 55px;
  text-align: center;
}

.services-heading span {
  color: #286318;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 3px;
}

.services-heading h2 {
  margin: 10px 0 15px;
  color: #153d3d;
  font-size: 48px;
}

.services-heading p {
  margin: 0;
  color: #687878;
  font-size: 16px;
  line-height: 1.8;
}


/* SERVICE GRID */

.services-grid {
  max-width: 1250px;
  margin: auto;

  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 28px;
}


/* CARD */

.service-card {
  background: #fff;
  border-radius: 25px;
  overflow: hidden;

  box-shadow: 0 15px 40px rgba(21, 61, 61, 0.08);

  transition: all 0.35s ease;
}

.service-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 25px 55px rgba(21, 61, 61, 0.15);
}


/* IMAGE */

.service-image {
  width: 100%;
  height: 230px;
  overflow: hidden;
  background: #e2eddf;
}

.service-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;

  transition: transform 0.5s ease;
}

.service-card:hover .service-image img {
  transform: scale(1.07);
}

.no-service-image {
  width: 100%;
  height: 100%;

  display: flex;
  align-items: center;
  justify-content: center;

  color: #286318;
  font-size: 20px;
  font-weight: 600;
}


/* CARD CONTENT */

.service-content {
  padding: 25px;
}

.service-content h3 {
  margin: 0 0 10px;

  color: #153d3d;
  font-size: 21px;
  font-weight: 700;
}

.service-content > p {
  margin: 0 0 20px;

  color: #718080;
  font-size: 14px;
  line-height: 1.7;

  min-height: 48px;
}


/* PRICE + DURATION */

.service-info {
  display: flex;
  gap: 35px;

  padding: 15px 0;

  border-top: 1px solid #edf1ed;
  border-bottom: 1px solid #edf1ed;

  margin-bottom: 20px;
}

.service-info div {
  display: flex;
  flex-direction: column;
  gap: 3px;
}

.service-info small {
  color: #8a9696;
  font-size: 11px;
}

.service-info strong {
  color: #286318;
  font-size: 14px;
}


/* VIEW DETAILS */

.service-details-btn {
  width: 100%;
  box-sizing: border-box;

  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 13px 18px;

  border-radius: 12px;

  background: #153d3d;
  color: #fff;

  text-decoration: none;

  font-size: 14px;
  font-weight: 600;

  transition: all 0.3s ease;
}

.service-details-btn:hover {
  background: #286318;
}

.service-details-btn span {
  font-size: 20px;
}


/* NO SERVICE */

.no-services {
  grid-column: 1 / -1;

  text-align: center;

  padding: 70px 20px;

  background: #fff;
  border-radius: 20px;
}

.no-services h3 {
  color: #153d3d;
  margin-bottom: 8px;
}

.no-services p {
  color: #777;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 900px) {

  .services-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .services-heading h2 {
    font-size: 40px;
  }

}


@media (max-width: 600px) {

  .services-section {
    padding: 70px 20px;
  }

  .services-heading {
    margin-bottom: 40px;
  }

  .services-heading h2 {
    font-size: 34px;
  }

  .services-heading p {
    font-size: 14px;
  }

  .services-grid {
    grid-template-columns: 1fr;
    gap: 22px;
  }

  .service-image {
    height: 220px;
  }

  .service-content {
    padding: 22px;
  }

}
    </style>
</head>
<body>
    <nav>
  <p id="logo">MODULARS</p>
  <ul class="links">
    <li>Home</li>
    <li>About</li>
    <li>Blog</li>
    <li>Contact</li>
  </ul>
  
  <a href="{{ route('customer.register') }}" style="padding: 10px; background-color:#286318; color:#fff">Request Project</a>
</nav>
<div class="main">
  <div class="txt">
    <h2>We're a creative design agency.</h2>
    <p>A brilliant, modular agency template for startup's build yours today. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo quia esse nihil.</p>
    <div class="buttons">
      <a href="{{ route('customer.register') }}" style="padding: 20px; background-color:#286318; color:#fff">Request Project</a>
      <button class="button" id="btn2">
        <div class="circle"><img src="https://static.vecteezy.com/system/resources/previews/017/196/544/non_2x/play-button-icon-transparent-background-free-png.png" alt="play"></div>Watch Video
      </button>
    </div>
  </div>
  <div class="pictures">
    <div class="img" id="img1"></div>
    <div class="img" id="img2"></div>
    <div class="img" id="img3"></div>
  </div>
  <!-- <div class="brands">
    <img src="https://www.freepnglogos.com/uploads/google-logo-png/google-logo-png-google-sva-scholarship-20.png" alt="google">
    <img src="https://1000logos.net/wp-content/uploads/2021/06/Slack-logo.png" alt="slack">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Agworld_Logo.svg/3840px-Agworld_Logo.svg.png" alt="Agworld">
    <img src="https://download.logo.wine/logo/Rio_Tinto_(corporation)/Rio_Tinto_(corporation)-Logo.wine.png" alt="riotinto">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/Heroku_logo.svg/960px-Heroku_logo.svg.png?_=20210504043420" alt="heroku">
  </div> -->
</div>



<!-- =========================
     OUR SERVICES SECTION
========================= -->

<section class="services-section">

    <div class="services-heading">
        <span>WHAT WE DO</span>

        <h2>Our Services</h2>

        <p>
            We provide professional interior design solutions
            to transform your space into a beautiful, modern,
            and comfortable environment.
        </p>
    </div>

    <div class="services-grid">

        @forelse($services as $service)

            <div class="service-card">

                <!-- Service Image -->
                <div class="service-image">

                    @if($service->image)

                        <img
                            src="{{ asset('storage/' . $service->image) }}"
                            alt="{{ $service->name }}"
                        >

                    @else

                        <div class="no-service-image">
                            Interior Design
                        </div>

                    @endif

                </div>


                <!-- Service Content -->
                <div class="service-content">

                    <h3>
                        {{ $service->name }}
                    </h3>


                    @if($service->short_description)

                        <p>
                            {{ Str::limit($service->short_description, 100) }}
                        </p>

                    @else

                        <p>
                            Professional interior design solutions
                            tailored to your needs.
                        </p>

                    @endif


                    <!-- Service Information -->
                    <div class="service-info">

                        @if($service->starting_budget !== null)

                            <div>
                                <small>Starting From</small>

                                <strong>
                                    ৳ {{ number_format((float) $service->starting_budget) }}
                                </strong>
                            </div>

                        @endif


                        @if($service->estimated_duration_days)

                            <div>
                                <small>Estimated Time</small>

                                <strong>
                                    {{ $service->estimated_duration_days }} Days
                                </strong>
                            </div>

                        @endif

                    </div>


                    <!-- View Details -->
                    <a
                        href="{{ route('services.show', $service->slug) }}"
                        class="service-details-btn"
                    >
                        <span>View Details</span>

                        <span>→</span>
                    </a>

                </div>

            </div>


        @empty

            <div class="no-services">

                <h3>No Services Available</h3>

                <p>
                    We are currently preparing our services.
                    Please check back soon.
                </p>

            </div>

        @endforelse

    </div>

</section>
</body>
</html>