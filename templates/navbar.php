<!-- Navigationsbar -->
<nav class="navbar navbar-expand navbar-light navbgwhite topbar mb-4 static-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand goingdark" href="#">Dave's Webshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Dropdown Menü -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active goingdark" aria-current="page" href="#">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link goingdark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategorie &nbsp;<i class="fi fi-rr-angle-small-down"></i>
                    </a>
                    <ul class="dropdown-menu darkcard animated--grow-in" aria-labelledby="navbarDropdown">
                        <!-- Kategorie aus Datebank -->
                        <?php
                        include_once 'functions\db_funktionen.php';
                        $sql = "SELECT * FROM kategorien";
                        $result = db_query($sql);

                        while ($row = mysqli_fetch_row($result)) {
                            echo  "<li><a class= \"dropdown-item goingdark\" href= \"index.php/category.php?cat=$row[0] \">$row[1]</a></li>";
                        }


                        ?>

                        
                    </ul>
                </li>
                <!-- Dropdown Menü Ende -->
                <li class="nav-item">
                    <a class="nav-link disabled goingdark">Coming Soon</a>
                </li>
            </ul>
            <i class="fi fi-rr-sun sunt goingdark"></i>
            <div class="custom-control custom-switch">
                <div class="darkmodetoggle">

                    <input type="checkbox" class="custom-control-input" id="ChangeTheme">

                    <label class="custom-control-label" for="ChangeTheme"></label>

                </div>

            </div>
            <i class="fi fi-rr-moon moont goingdark"></i>
            <form class="d-flex" id="onetwo" action="index.php/search" method="POST">
                <input class="form-control me-2 searchbar goingdark" type="search" placeholder="Name/ArtNr" aria-label="Search" name="searchproduct">
                <button class="btn btn-outline-success" type="submit">Suche</button>
            </form>
            <style>
                #onetwo {
                    margin-right: 10px;
                }
            </style>
            <?php
            if (!isLoggedIn()) {
                echo  '<form class= "d-flex " method= "get " action= "index.php/login " id= "onetwo ">

                <button class= "btn btn-outline-success " type= "submit ">Login/Register

                    
                </button>
            </form> ';
            } else {
                echo  '<form class="d-flex" method= "get " action= "index.php/cart " id= "onetwo ">

                <button class= "btn btn-outline-success " id="warenkorbanzahl" type= "submit ">Warenkorb (';

                $userid = getCurrentUserId();
                $items = countCartItems($userid);
                if ($items === null) {
                    $items = 0;
                }
                echo  "$items";
                echo  ') </button>
                </form> ';

                require 'templates/usericon.php';
            }
            ?>
        </div>
    </div>

</nav>
<script>

    var checkbox = document.getElementById("ChangeTheme"); //get the checkbox to a variable

    //check storage if dark mode was on or off
    if (sessionStorage.getItem("mode") == "dark") {
        darkmode(); //if dark mode was on, run this funtion
    } else {
        nodark(); //else run this funtion
    }

    //if the checkbox state is changed, run a funtion
    checkbox.addEventListener("change", function() {
        //check if the checkbox is checked or not
        if (checkbox.checked) {
            darkmode(); //if the checkbox is checked, run this funtion
        } else {
            nodark(); //else run this funtion
        }
    });

    //function for checkbox when checkbox is checked
    function darkmode() {
        document.body.classList.add("dark-mode"); //add a class to the body tag
        checkbox.checked = true; //set checkbox to be checked state
        sessionStorage.setItem("mode", "dark"); //store a name & value to know that dark mode is on
    }

    //function for checkbox when checkbox is not checked
    function nodark() {
        document.body.classList.remove("dark-mode"); //remove added class from body tag
        checkbox.checked = false; //set checkbox to be unchecked state
        sessionStorage.setItem("mode", "light"); //store a name & value to know that dark mode is off or light mode is on
    }
    
</script>


<!-- Navigationsbar Ende -->