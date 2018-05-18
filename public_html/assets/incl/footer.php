<footer class="footer">
    <div class="footer-scroll-wrapper">
        <div class="footer-scroll"><i class="material-icons">expand_less</i></div>
    </div>
    <div class="footer-text">
        <h3>bageriet</h3>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam, quaerat!</p>
    </div>
    <div class="footer-copyright">
        <p>Copyright &#x24B8; 2017 bageriet aps</p>
    </div>
</footer>

<script>

// Open search input (header)
$(function() {
    $('#search').click( function() {
        if ($('.search-input').hasClass('search-input-open')) {
            $('.search-input').removeClass("search-input-open");
            $('.search-input').addClass("search-input-closed");
        } 
        else if ($('.search-input').hasClass('search-input-closed')) {
            $('.search-input').removeClass("search-input-closed");
            $('.search-input').addClass("search-input-open");
        }
        else {
            $('.search-input').addClass("search-input-open");
        }
        $('.search-input').focus();
    });
});

// Scroll to top
$("div[class='footer-scroll']").click(function() {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
});
</script>
<script>
    // Login Form Submit
    form = "#formLogin";
    
    $(form).on('submit', function(e) {
        
        e.preventDefault(); // Cancel the submit
        
        if (
            validateInput("#email", "Udfyld e-mail", "email") &&
            validateInput("#password", "Udfyld kodeord", "all")
        ) 
        { $(form)[0].submit(); }
    });
</script>
<script type="text/javascript" src="/assets/js/validate.js"></script>
    </body>
</html>