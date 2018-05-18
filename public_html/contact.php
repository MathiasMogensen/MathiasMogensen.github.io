<?php
$pageTitle = "Kontakt";
include("assets/incl/header.php");
?>

<section class="contact">
    <div class="contact-header">
        <h1>Kontakt os</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur quasi exercitationem repellat, maxime laboriosam soluta odio sequi adipisci commodi tempora!</p>
    </div>
    <div class="contact-content">
        <form class="contact-content-form" method="post">
            <div class="form-group">
                <input type="text" name="fullname" placeholder="Dit navn.." required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Din e-mail.." required>
            </div>
            <div class="form-group">
                <textarea name="message" rows="10" placeholder="Din besked.." required></textarea>
            </div>
            <button type="submit" name="contactsubmit">Send</button>
        </form>
        <div class="contact-content-info">
            <p><b>addresse:</b> Øster Uttrupvej 1, 9200 Aalborg</p>
            <p><b>telefon:</b> +45 25 26 95 40</p>
            <div class="contact-content-info-map" id="map"></div>
        </div>
    </div>
</section>

<!-- CONTACT FORM AJAX -->
<script>livequery(".contact-content-form", false, "/assets/ajax/contact.php");</script>

<!-- GOOGLE MAPS -->
<script>
    function initMap() {
    var uluru = {lat: 57.047821, lng: 9.966863};
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
      center: uluru
    });
    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });
  }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWUo3gFHl1b1w1KRx_kO31HCF8oKX0A-8&callback=initMap">
</script>
<?php
include("assets/incl/footer.php");
?>