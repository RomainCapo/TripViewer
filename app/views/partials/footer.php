    </div>

    <br>
    <br>
    

    <!--<div class="footer">
        <p class="footer-content">Copyright © TripViewer 2019 - Romain Capocasale et Vincent Moulin</p>
    </div>-->

    <script>
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            document.getElementById("btnToTop").style.display = "block";
        } else {
            document.getElementById("btnToTop").style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
    </script>

</body>
</html>
