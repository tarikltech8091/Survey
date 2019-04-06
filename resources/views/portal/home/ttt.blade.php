@extends('portal.layout.master')
@section('content')
<div class="home" style="margin-bottom: 55px">
	<style type="text/css">
		/* just for jsfiddle */
		@font-face {
		  font-family: 'Material Icons';
		  font-style: normal;
		  font-weight: 400;
		  src: local('Material Icons'), local('MaterialIcons-Regular'), url(https://fonts.gstatic.com/s/materialicons/v18/2fcrYFNaTjcS6g4U3t-Y5ZjZjT5FdEJ140U2DJYC3mY.woff2) format('woff2');
		}

		.material-icons {
		  font-family: 'Material Icons';
		  font-weight: normal;
		  font-style: normal;
		  font-size: 24px;
		  line-height: 1;
		  letter-spacing: normal;
		  text-transform: none;
		  display: inline-block;
		  white-space: nowrap;
		  word-wrap: normal;
		  direction: ltr;
		  -moz-font-feature-settings: 'liga';
		  -moz-osx-font-smoothing: grayscale;
		}

		.middle-indicator{
		   position:absolute;
		   top:50%;
		   }
		  .middle-indicator-text{
		   font-size: 4.2rem;
		  }
		  a.middle-indicator-text{
		    color:white !important;
		  }
		.content-indicator{
		    width: 64px;
		    height: 64px;
		    background: none;
		    -moz-border-radius: 50px;
		    -webkit-border-radius: 50px;
		    border-radius: 50px; 
		  }
		    .indicators{
		  	visibility: hidden;
		  }

	</style>
	<br><br><br>
	<div class="carousel carousel-slider">
	    <div class="carousel-fixed-item center middle-indicator">

		<div class="left">
	      <a href="Previo" class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons left  middle-indicator-text">chevron_left</i></a>
	     </div>
	     
	    <div class="right">
	     <a href="Siguiente" class=" moveNextCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons right middle-indicator-text">chevron_right</i></a>
	    </div>
	</div>

    <a class="carousel-item" href="#one!"><img src="https://lorempixel.com/250/250/nature/1"></a>
    <a class="carousel-item" href="#two!"><img src="https://lorempixel.com/250/250/nature/2"></a>
    <a class="carousel-item" href="#three!"><img src="https://lorempixel.com/250/250/nature/3"></a>
    <a class="carousel-item" href="#four!"><img src="https://lorempixel.com/250/250/nature/4"></a>
    <a class="carousel-item" href="#five!"><img src="https://lorempixel.com/250/250/nature/5"></a>
  </div>
  	<br><br><br><br><br><br><br><br><br><br><br><br>



<!-- <div class="container">
  <div class="carousel carousel-slider center " data-indicators="true">
    <div class="carousel-fixed-item center middle-indicator">
     <div class="left">
      <a href="Previo" class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons left  middle-indicator-text">chevron_left</i></a>
     </div>
     
     <div class="right">
     <a href="Siguiente" class=" moveNextCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons right middle-indicator-text">chevron_right</i></a>
     </div>
    </div>
    <div class="carousel-item red white-text" href="#one!">
      <h2>First Panel</h2>
      <p class="white-text">This is your first panel</p>
    </div>
    <div class="carousel-item amber white-text" href="#two!">
      <h2>Second Panel</h2>
      <p class="white-text">This is your second panel</p>
    </div>
    <div class="carousel-item green white-text" href="#three!">
      <h2>Third Panel</h2>
      <p class="white-text">This is your third panel</p>
    </div>
    <div class="carousel-item blue white-text" href="#four!">
      <h2>Fourth Panel</h2>
      <p class="white-text">This is your fourth panel</p>
    </div>
  </div>

</div>

  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

 -->




</div>
@endsection
@section('JScript')
<script type="text/javascript">
    $(document).ready(function(){
      $('.carousel.carousel-slider').carousel({
      		fullWidth: true
      		// indicators: false
      });
    });

   // move next carousel
   $('.moveNextCarousel').click(function(e){
      e.preventDefault();
      e.stopPropagation();
      $('.carousel').carousel('next');
   });

   // move prev carousel
   $('.movePrevCarousel').click(function(e){
      e.preventDefault();
      e.stopPropagation();
      $('.carousel').carousel('prev');
   });
</script>
@endsection