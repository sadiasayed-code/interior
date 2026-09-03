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
  
  <a href="{{ route('login') }}">signup</a>
</nav>
<div class="main">
  <div class="txt">
    <h2>We're a creative design agency.</h2>
    <p>A brilliant, modular agency template for startup's build yours today. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo quia esse nihil.</p>
    <div class="buttons">
      <button class="button" id="btn1">signUp</button>
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
    
</body>
</html>